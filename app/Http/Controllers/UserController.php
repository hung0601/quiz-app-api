<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\CreatorResource;
use App\Models\Course;
use App\Models\StudySet;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use function response;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();
        return User::withCount(['courses', 'study_sets', 'followers'])
            ->find($user->id);
    }

    public function profile(Request $request, $userId)
    {
        $user = $request->user();
        $result = User::withCount(['courses', 'study_sets', 'followers'])
            ->withCount(['followers as is_following' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->find($userId);
        return response()->json(new CreatorResource($result));
    }

    public function topCreators()
    {
        $top_creators = User::withCount('courses')->withCount('study_sets')->orderBy('study_sets_count', 'desc')->get();
        return $top_creators;
    }

    public function getCourses(Request $request, $userId)
    {
        $courses = Course::withCount('enrollments')
            ->withCount('study_sets')->with(['owner'])
            ->where('owner_id', $userId)
            ->get();
        return $courses;
    }

    public function getSets(Request $request, $userId)
    {
        $user = $request->user();

        $studySets = StudySet::with(['owner', 'topics'])
            ->withAvg('votes', 'star')
            ->withCount('terms as term_number')
            ->where(function (Builder $query) use ($user) {
                $query
                    ->where(function (Builder $builder) use ($user) {
                        $builder
                            ->whereHas('course', function (Builder $query) use ($user) {
                                $query->whereHas('enrollments', function (Builder $query) use ($user) {
                                    $query->where('user_id', $user->id);
                                });
                            })
                            ->orWhereHas('members', function (Builder $query) use ($user) {
                                $query->where('user_id', $user->id);
                            });
                    })
                    ->orWhere(function (Builder $query) use ($user) {
                        $query->where('access_type', StudySet::PUBLIC_ACCESS_TYPE)
                            ->orWhere(function (Builder $builder) use ($user) {
                                $builder
                                    ->where('access_type', StudySet::SHARE_WITH_FOLLOWER_ACCESS_TYPE)
                                    ->whereHas('owner', function (Builder $query) use ($user) {
                                        $query->whereHas('followers', function (Builder $query) use ($user) {
                                            $query->where('user_id', $user->id);
                                        });
                                    });
                            });
                    });
            })
            ->where('owner_id', $userId)
            ->get();
        return response()->json($studySets);
    }
}
