<?php

namespace App\Http\Controllers;

use App\Http\Requests\Exam\StoreStudyResultRequest;
use App\Models\StudyResult;
use App\Models\StudySet;
use App\Models\StudySetTest;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(Request $request){
        $request->validate([
            'study_set_id' => 'required|exists:study_sets,id',
        ]);
        return StudySetTest::withCount('questions as question_count')->where('study_set_id', $request->study_set_id)->get();
    }

    public function show(string $id)
    {
        return StudySetTest::with('questions.question')->find($id);
    }
    public function storeStudyResults(StoreStudyResultRequest $request){
        DB::beginTransaction();
        try {
            $user = $request->user();
            $requestResults = $request->validated();
            foreach ($requestResults as $requestResult) {
                $result = StudyResult::where('user_id', $user->id)
                    ->where('term_id', $requestResult['term_id'])->first();
                if (!$result) {
                    StudyResult::create([
                        'user_id' => $user->id,
                        'term_id' => $requestResult['term_id'],
                        'correct_string' => $requestResult['is_correct'] ? 1 : 0,
                        'status' => $requestResult['is_correct'] ? 1 : 0
                    ]);
                } else {
                    if ($requestResult['is_correct']) {
                        $result->correct_string = $result->correct_string + 1;
                        $result->status = 1;
                        if ($result->correct_string >= 2) {
                            $result->status = 2;
                        }
                    } else {
                        $result->correct_string = 0;
                        if ($result->status !== 0){
                            $result->status = 1;
                        }
                    }
                    $result->save();
                }
            }
            DB::commit();
            return response()->json(['success']);
        }catch (\Exception $error) {
            DB::rollBack();

            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }

    public function submitExam(Request $request, string $id){
        return $request->all();
    }
}
