<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\CreatorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        if (isset($request->user_id)) $userId = $request->user_id;
        else $userId = $request->user()->id;
        $result = User::with('followers')->find($userId);
        $followers = $result->followers
            ->loadCount(['followers as is_following' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);

        return response()->json(CreatorResource::collection($followers));
    }

    public function getFollowing(Request $request)
    {
        $user = User::find($request->user()->id);
        return response()->json($user->followings);
    }

    public function follow(Request $request, $following_id)
    {
        try {
            $user = $request->user();
            if ($following_id == $user->id) {
                return response()->json([
                    'message' => 'Cannot follow yourself!',
                ], 404);
            }
            User::findOrFail($following_id);
            $result = DB::table('user_followers')->updateOrInsert(
                [
                    'user_id' => $user->id,
                    'following_id' => $following_id,
                ]
            );
            return response()->json($result);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function unFollow(Request $request, $following_id)
    {
        try {
            $user = $request->user();
            $result = DB::table('user_followers')
                ->where('user_id', $user->id)
                ->where('following_id', $following_id)
                ->delete();
            if (!$result) {
                return response()->json([
                    'message' => 'Cannot unfollow!',
                ], 400);
            }
            return response()->json($result);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }
}
