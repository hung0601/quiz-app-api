<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudySet;
use App\Models\Vote;

class VoteController extends Controller
{
    public function vote(Request $request)
    {
        try {
            $user = $request->user();
            $request->validate([
                'study_set_id' => 'required',
                'star' => 'required|numeric|max:5|min:1'
            ]);
            $set = StudySet::findOrFail((int) $request->study_set_id);
            $vote = Vote::updateOrCreate(
                [
                    'study_set_id' => $request->study_set_id,
                    'user_id' => $user->id,
                ],
                [
                    'star' => $request->star,
                ]
            );
            return $set->loadAvg('votes', 'star')->votes_avg_star;
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }
}
