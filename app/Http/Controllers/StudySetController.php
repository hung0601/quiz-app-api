<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudySet\StoreSetRequest;
use App\Http\Requests\StudySet\UpdateSetRequest;
use App\Http\Resources\StudySet\StudySetDetailResource;
use App\Http\Resources\User\MemberResource;
use App\Models\StudySet;
use App\Models\StudySetTopic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use function asset;
use function response;
use function str_replace;
use function url;

class StudySetController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $enrollmentSets = StudySet::with(['owner', 'topics'])
            ->withAvg('votes', 'star')
            ->withCount('terms as term_number')
            ->where(function (Builder $builder) use ($user) {
                $builder->whereHas('course', function (Builder $query) use ($user) {
                    $query->whereHas('enrollments', function (Builder $query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
                })
                    ->orWhereHas('members', function (Builder $query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
        $studySets = StudySet::with(['owner', 'topics'])
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
        try {
        $studySet = StudySet::with(['owner', 'topics', 'exams'])
            ->with(['terms' => function ($query) use ($request) {
                $query->with(['study_results' => function ($query) use ($request) {
                    $query->where('user_id', $request->user()->id);
                }]);
            }])
            ->withCount('votes as vote_count')
            ->withAvg('votes', 'star')->find($id);

        if(!$studySet){
            return response()->json([
                'message' => 'Study Set not found.',
            ], 400);
        }

        $studySet->permission = StudySet::NONE_ACCESS_LEVEL;
        $accessType = DB::table('study_set_access')
            ->where('user_id', $request->user()->id)
            ->where('study_set_id', $id)
            ->first();
        if ($accessType) $studySet->permission = $accessType->access_level;

        if ($request->user()->id == $studySet->owner_id)
            $studySet->permission = StudySet::OWNER_ACCESS_LEVEL;

        if ($studySet->access_type == StudySet::PRIVATE_ACCESS_TYPE
            && $studySet->permission == StudySet::NONE_ACCESS_LEVEL) {
            throw new \Exception("Forbidden access to studySet");
        } else if ($studySet->access_type == StudySet::SHARE_WITH_FOLLOWER_ACCESS_TYPE
            && $studySet->permission == StudySet::NONE_ACCESS_LEVEL) {
            $follow = DB::table('user_followers')
                ->where('following', $studySet->owner_id)
                ->where('user_id', $request->user()->id)
                ->first();
            if (!$follow) throw new \Exception("Forbidden access to studySet");
        }

        return response()->json(new StudySetDetailResource($studySet));
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function delete($id)
    {
        $studySet = StudySet::find($id);
        return $studySet->delete();
    }

    public function store(StoreSetRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $request->user();
            $set = new StudySet;
            $set->title = $request->title;
            $set->description = $request->description;
            $set->owner_id = $user->id;
            $set->image_url = null;
            if ($request->term_lang) $set->term_lang = $request->term_lang;
            if ($request->def_lang) $set->def_lang = $request->def_lang;
            if ($request->access_type) $set->access_type = $request->access_type;
            $image = $request->file('image');
            if (!empty($image)) {
                $path = $image->move('storage/study_sets', $image->hashName());
                $image_url = asset($path);
                $set->image_url = $image_url;
            }
            if ($request->course_id) $set->course_id = (int)$request->course_id;
            $set->save();
            if (!empty($request->topic_ids) && count($request->topic_ids) > 0) {
                foreach ($request->topic_ids as $topic_id) {
                    StudySetTopic::create([
                        'topic_id' => $topic_id,
                        'study_set_id' => $set->id,
                    ]);
                }
            }
            DB::commit();

            return $set->load(['owner'])
                ->loadCount('terms as term_number');
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function update(UpdateSetRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $set = StudySet::find($id);
            if ($request->title) $set->title = $request->title;
            if ($request->description) $set->description = $request->description;
            if ($request->term_lang) $set->term_lang = $request->term_lang;
            if ($request->def_lang) $set->def_lang = $request->def_lang;
            if ($request->access_type) $set->access_type = $request->access_type;

            if($request->has("image")) {
                $image = $request->file('image');
                if ($set->image_url) {
                    $relativePath = str_replace(url('/') . '/', '', $set->image_url);
                    if (File::exists($relativePath)) {
                        File::delete($relativePath);
                    }
                }
                if (!empty($image)) {
                    $path = $image->move('storage/study_sets', $image->hashName());
                    $image_url = asset($path);
                    $set->image_url = $image_url;
                }else{
                    $set->image_url = null;
                }
            }
            $set->save();
            if ($request->has('topic_ids')) {
                DB::table('study_set_topics')->where('study_set_id', $set->id)->delete();
                if(!empty($request->topic_ids) && count($request->topic_ids) > 0) {
                    foreach ($request->topic_ids as $topic_id) {
                        StudySetTopic::create([
                            'topic_id' => $topic_id,
                            'study_set_id' => $set->id,
                        ]);
                    }
                }
            }
            DB::commit();

            return $set->load(['owner'])
                ->loadCount('terms as term_number')
                ->load('topics');
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function invite(Request $request, $setId)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'access_level' => 'required|integer|in:0,1',
            ]);
            $user = $request->user();
            $sets = StudySet::where('owner_id', $user->id)
                ->findOrFail($setId);
            $result = DB::table('study_set_access')->updateOrInsert(
                [
                    'study_set_id' => $setId,
                    'user_id' => $request->user_id,
                ],
                [
                    'access_level' => $request->access_level,
                ]
            );
            return response()->json($result);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function removeMember(Request $request, $setId, $userId)
    {
        try {
            $user = $request->user();
            $sets = StudySet::where('owner_id', $user->id)
                ->findOrFail($setId);
            $result = DB::table('study_set_access')
                ->where('study_set_id', $setId)
                ->where('user_id', $userId)
                ->delete();
            return response()->json($result);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function leave(Request $request, $setId)
    {
        try {
            $user = $request->user();
            $result = DB::table('study_set_access')
                ->where('study_set_id', $setId)
                ->where('user_id', $user->id)
                ->delete();
            return response()->json($result);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function getMembers(Request $request, $setId)
    {
        try {
            $user = $request->user();

            $set = StudySet::findOrFail($setId);
            return response()->json(MemberResource::collection($set->members));
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }
}
