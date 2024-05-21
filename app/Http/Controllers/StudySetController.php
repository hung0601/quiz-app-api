<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudySet\StudySetDetailResource;
use App\Models\StudySet;
use App\Models\StudySetTopic;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use function response;

class StudySetController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $enrollmentSets = StudySet::with(['owner','topics'])
            ->withAvg('votes', 'star')
            ->withCount('terms as term_number')
            ->whereHas('course', function (Builder $query) use ($user) {
                $query->whereHas('enrollments', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            });
        $studySets = StudySet::with(['owner','topics'])
            ->withAvg('votes', 'star')
            ->withCount('terms as term_number')
            ->where('owner_id', $user->id)
            ->union($enrollmentSets)
            ->get();
        return response()->json($studySets);
    }

    // set not belong to any course
    public function getCreatedSet(Request $request)
    {
        $user = $request->user();
        $studySets = StudySet::with(['owner'])
            ->withCount('terms as term_number')
            ->where('owner_id', $user->id)
            ->where('course_id', null)
            ->get();
        return $studySets;
    }

    public function show(Request $request, string $id)
    {
        $studySet = StudySet::with(['owner', 'topics','exams'])
            ->with(['terms' => function ($query) use ($request) {
                $query->with(['study_results' => function ($query) use ($request) {
                    $query->where('user_id', $request->user()->id);
                }]);
            }])
            ->withCount('votes as vote_count')
            ->withAvg('votes', 'star')->find($id);
        if($request->user()->id != $studySet->owner_id) $studySet->permission=false;
        else $studySet->permission=true;
        return response()->json(new StudySetDetailResource($studySet));
    }

    public function delete($id)
    {
        $studySet = StudySet::find($id);
        $studySet->delete();
        return;
    }

    public function store(Request $request)
    {
        try {
            $user = $request->user();
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'image' => 'mimes:jpeg,png,jpg,gif',
                'term_lang' => 'string|nullable',
                'def_lang' => 'string|nullable',
                'topic_ids' => 'array',
                'topic_ids.*' => 'integer|exists:topics,id',
            ]);
            $set = new StudySet;
            $set->title = $request->title;
            $set->description = $request->description;
            $set->owner_id = $user->id;
            $set->image_url=null;
            if($request->term_lang) $set->term_lang = $request->term_lang;
            if($request->def_lang) $set->def_lang = $request->def_lang;
            $image= $request->file('image');
            if(!empty($image)){
                $path=$image->move('storage/study_sets', $image->hashName());
                $image_url= asset($path);
                $set->image_url=$image_url;
            }
            if ($request->course_id) $set->course_id = (int)$request->course_id;
            $set->save();
            if(!empty($request->topic_ids) && count($request->topic_ids)>0){
                foreach ($request->topic_ids as $topic_id){
                    StudySetTopic::create([
                        'topic_id'=>$topic_id,
                        'study_set_id'=>$set->id,
                    ]);
                }
            }
            return $set->load(['owner'])
                ->loadCount('terms as term_number');
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }
}
