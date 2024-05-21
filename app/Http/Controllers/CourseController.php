<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\StudySet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index(Request $request){
        $user= $request->user();
        $enrollmentCourses= Course::withCount('enrollments')->withCount('study_sets')->with(['owner'])
        ->whereHas('enrollments',function (Builder $query) use($user) {
            $query->where('user_id',$user->id);
        });
        $courses= Course::withCount('enrollments')->withCount('study_sets')->with(['owner'])
        ->where('owner_id',$user->id)
        ->union($enrollmentCourses)
        ->get();

        return $courses;
    }
    public function show($id)
    {
        $course= Course::with(['owner','study_sets','enrollments.user'])->find($id);
        $course->study_sets->load(['owner','topics'])->loadAvg('votes', 'star')->loadCount('terms as term_number');
        return $course;
    }
    public function delete($id)
    {
        $course= Course::find($id);
        $course->delete();
        return;
    }

    public function store(Request $request){
        try{
            $user= $request->user();
            $request->validate([
                'title' => 'required',
                'description' => 'required'
            ]);
            $course= new Course;
            $course->title=$request->title;
            $course->description=$request->description;
            $course->owner_id=$user->id;
            $course->save();
            return $course->load('owner')->loadCount(['study_sets','enrollments']);
        }catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }

    }

    public function addStudySet(Request $request){
        try{
            $user= $request->user();
            $request->validate([
                'course_id' => 'required',
                'study_set_ids' => 'required|array|min:1'
            ]);
            $course= Course::where('owner_id',$user->id)->find($request->course_id);
            if(!$course) return response()->json([
                'message' => 'No course found in your account',
            ],400);
            DB::transaction(function () use($request,$user,$course) {
                foreach( $request->study_set_ids as $study_set_id){
                    $study_set= StudySet::where('owner_id',$user->id)->findOrFail($study_set_id);
                    $study_set->course_id= $course->id;
                    $study_set->save();
                }
            });
            return;
        }catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }
}
