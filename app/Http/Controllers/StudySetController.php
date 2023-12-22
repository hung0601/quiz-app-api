<?php

namespace App\Http\Controllers;

use App\Models\StudySet;
use Illuminate\Http\Request;

class StudySetController extends Controller
{
    public function index(Request $request){
        $studySet= StudySet::with(['terms'])->get();
        return $studySet;
    }
    public function show($id)
    {
        $studySet = StudySet::with(['terms'])->find($id);
        return $studySet;
    }
}
