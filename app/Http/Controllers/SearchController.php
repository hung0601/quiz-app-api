<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudySet;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){
        $request->validate([ 
            'search'=>'required',
        ]);
        $courses=Course::withCount('enrollments')->withCount('study_sets')->with(['owner'])
        ->where('title','LIKE','%'.$request->search.'%')
        ->orWhere('description','LIKE','%'.$request->search.'%')
        ->get();
        $sets=StudySet::with(['owner'])
        ->withCount('terms as term_number')
        ->where('title','LIKE','%'.$request->search.'%')
        ->orWhere('description','LIKE','%'.$request->search.'%')
        ->get();
        $creators=User::withCount('courses')->withCount('study_sets')->orderBy('study_sets_count','desc')
        ->where('name','LIKE','%'.$request->search.'%')->get();
        return response()->json([
            'courses' => $courses,
            'study_sets'=>$sets,
            'creators'=> $creators
        ]); 
    }
}
