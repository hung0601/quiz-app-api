<?php

namespace App\Http\Controllers;

use App\Models\StudySet;
use App\Models\StudySetTest;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(Request $request){
        try{
            $user= $request->user();
            $request->validate([ 
                'setId' => 'required',
            ]);
            $set= StudySet::find($request->setId);
            if($set->terms->count()<4) return response()->json([
                'message' => "Study set must have 4 or more terms to be able to test",
            ],400);
            $result = null;
            DB::transaction(function () use(&$result,$set,$request) { 
                $test= new StudySetTest;
                $test->study_set_id= $request->setId;
                $test->test_name="default";
                $test->save();
                $result=$set->terms->map(function($term) use($test,$set){
                    $question= new TestQuestion;
                    $question->test_id=$test->id;
                    $question->term_referent_id	=$term->id;
                    $question->question	="Choose the correct answer\n"."Difinition of ".$term->term." ?";
                    $question->point=1;
                    $question->type=1;
                    $question->save();
                    return $question->load(['term_referent']);
                });
            });

            
            if($result != null)return $result;
            }catch (\Exception $error) {
                return response()->json([
                    'message' => $error->getMessage(),
                ],400);
            }
    }
}
