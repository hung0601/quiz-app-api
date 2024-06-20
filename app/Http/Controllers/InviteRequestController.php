<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\EnrollmentRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InviteRequestController extends Controller
{

    public function getInvite(Request $request)
    {
        $user = $request->user();
        $enrollRequests = $user->enrollRequests;
        $inviteLsts = $enrollRequests->map(function ($enrollRequest) {
            return [
                'owner' => $enrollRequest->course->owner,
                'course_id' => $enrollRequest->course->id,
                'course_title' => $enrollRequest->course->title
            ];
        });
        return response()->json($inviteLsts);
    }

    public function invite(Request $request)
    {
        try {
            $user = $request->user();
            $request->validate([
                'course_id' => 'required',
                'participant_id' => 'required',
                'type' => 'required'
            ]);
            Course::where('owner_id', $user->id)->findOrFail($request->course_id);
            $enrollments = Enrollment::where('user_id', $request->participant_id)->where('course_id', $request->course_id)->get();
            if ($enrollments->isNotEmpty()) return;
            $enrollRequest = EnrollmentRequest::where('course_id', $request->course_id)->where('participant_id', $request->participant_id)->get();
            if ($enrollRequest->isNotEmpty()) return;
            $enrollmentRequest = new EnrollmentRequest;
            $enrollmentRequest->course_id = $request->course_id;
            $enrollmentRequest->participant_id = $request->participant_id;
            $enrollmentRequest->type = $request->type;
            $enrollmentRequest->save();
            return;
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function acceptInvite(Request $request)
    {
        try {
            $user = $request->user();
            $request->validate([
                'course_id' => 'required',
                'isAccept' => 'required'
            ]);
            $isAccept = filter_var($request->isAccept, FILTER_VALIDATE_BOOLEAN);
            Course::findOrFail($request->course_id);
            $enrollRequest = EnrollmentRequest::where('course_id', $request->course_id)->where('participant_id', $user->id)->firstOrFail();
            if (empty($enrollRequest)) return response()->json([
                'message' => 'invalid invite',
            ], 400);
            //return  $enrollRequest;
            DB::transaction(function () use ($request, $user, $isAccept) {
                EnrollmentRequest::where('course_id', $request->course_id)->where('participant_id', $user->id)->delete();
                if ($isAccept) {
                    $enroll = new Enrollment;
                    $enroll->course_id = $request->course_id;
                    $enroll->user_id = $user->id;
                    $enroll->save();
                }
            });
            return $request->isAccept;
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function searchUser(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'search' => 'required',
        ]);

        $owner = User::whereHas('courses', function (Builder $query) use ($request) {
            $query->where('id', $request->course_id);
        });
        $member = User::whereHas('enrollments', function (Builder $query) use ($request) {
            $query->where('course_id', $request->course_id);
        })->union($owner)->get();

        $search = User::where('email', 'LIKE', '%' . $request->search . '%')->get();
        $search = $search
            ->diff($member);
        return $search;
    }
}
