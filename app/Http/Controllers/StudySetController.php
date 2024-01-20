<?php

namespace App\Http\Controllers;

use App\Models\StudySet;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class StudySetController extends Controller
{
    public function index(Request $request){
        $user= $request->user();
        $enrollmentSets= StudySet::with(['owner'])
        ->withCount('terms as term_number')
        ->whereHas('course',function (Builder $query) use($user) {
            $query->whereHas('enrollments',function (Builder $query) use($user) {
                $query->where('user_id',$user->id);
            });
        });
        $studySets= StudySet::with(['owner'])
        ->withCount('terms as term_number')
        ->where('owner_id',$user->id)
        ->union($enrollmentSets)
        ->get();
        return $studySets;
    }

    // set not belong to any course
    public function getCreatedSet(Request $request){
        $user= $request->user();
        $studySets= StudySet::with(['owner'])
        ->withCount('terms as term_number')
        ->where('owner_id',$user->id)
        ->where('course_id',null)
        ->get();
        return $studySets;
    }
    public function show($id)
    {
        $studySet = StudySet::with(['owner','terms'])->find($id);
        return $studySet;
    }

    public function delete($id)
    {
        $studySet = StudySet::find($id);
        $studySet->delete();
        return;
    }
    public function store(Request $request){
        try{
            $user= $request->user();
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'image'=>'required|mimes:jpeg,png,jpg,gif',
            ]);
            $image= $request->file('image');
            $path=$image->move('storage/study_sets', $image->hashName());
            $image_url= asset($path);
            $set= new StudySet;
            $set->title= $request->title;
            $set->description= $request->description;
            $set->owner_id= $user->id;
            $set->image_url=$image_url;
            if($request->course_id) $set->course_id= (int) $request->course_id;
            $set->save();
            return $set->load(['owner'])
            ->loadCount('terms as term_number');
        }catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }
}
