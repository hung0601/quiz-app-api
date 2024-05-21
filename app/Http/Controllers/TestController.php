<?php

namespace App\Http\Controllers;

use App\Http\Requests\Exam\AddQuestionsRequest;
use App\Http\Requests\Exam\StoreStudyResultRequest;
use App\Http\Requests\Exam\SubmitExamRequest;
use App\Http\Requests\Question\UpdateQuestionRequest;
use App\Http\Resources\Exam\ExamDetailResource;
use App\Models\QuizQuestion;
use App\Models\StudyResult;
use App\Models\StudySetTest;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\TrueFalseQuestion;
use App\Models\TypeAnswerQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function response;

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
        return response()->json(new ExamDetailResource(StudySetTest::with('questions.question')->find($id)));
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

    public function submitExam(SubmitExamRequest $request, string $id){
        DB::beginTransaction();
        try {
            $user = $request->user();
            $requestResults = $request->validated();
            foreach ($requestResults as $requestResult) {
               TestResult::updateOrCreate(
                   [
                       'user_id' => $user->id,
                       'question_id' => $requestResult['question_id'],
                   ],
                   [
                       'is_correct' => $requestResult['is_correct'],
                       'selected_answer' => $requestResult['selected_answer'],
                   ]
               );
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

    public function create(Request $request){
        $request->validate([
            'study_set_id' => 'required|exists:study_sets,id',
            'test_name' => 'required|string',
        ]);
        return StudySetTest::create([
            'study_set_id' => $request['study_set_id'],
            'test_name' => $request['test_name'],
        ]);
    }

    public function addQuestions(AddQuestionsRequest $request, $examId){
        DB::beginTransaction();
        try {
            StudySetTest::findOrFail($examId);
            $questions = $request->validated();
            foreach ($questions as $requestQuestion) {
                $questionDetail = null;
                switch ($requestQuestion['question_type']){
                    case TestQuestion::MULTIPLE_CHOICE_QUESTION:
                        $questionDetail = QuizQuestion::create([
                            'question' => $requestQuestion['question']['question'],
                            'answers' => json_encode($requestQuestion['question']['answers']),
                            'correct_answer' =>  $requestQuestion['question']['correct_answer'],
                        ]);
                        break;
                    case TestQuestion::TRUE_FALSE_QUESTION:
                        $questionDetail = TrueFalseQuestion::create([
                            'question' => $requestQuestion['question']['question'],
                            'correct_answer' =>  $requestQuestion['question']['correct_answer'],
                        ]);
                        break;
                    case TestQuestion::TYPE_ANSWER_QUESTION:
                        $questionDetail = TypeAnswerQuestion::create([
                            'question' => $requestQuestion['question']['question'],
                            'correct_answer' =>  $requestQuestion['question']['correct_answer'],
                        ]);
                        break;
                    default:
                        break;
                }
                $question =  new TestQuestion;
                $question->test_id = $examId;
                $question->has_audio = $requestQuestion['has_audio'];
                if( $requestQuestion['audio_text']) $question->audio_text = $requestQuestion['audio_text'];
                if($requestQuestion['audio_lang']) $question->audio_lang = $requestQuestion['audio_lang'];
                $question->question()->associate($questionDetail);
                $question->save();
            }

            DB::commit();

            return response()->json(new ExamDetailResource(StudySetTest::with('questions.question')->find($examId)));
        }catch (\Exception $error) {
            DB::rollBack();

            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }

    public function deleteQuestion(Request $request, $questionId)
    {
        DB::beginTransaction();
        try {
            $question = TestQuestion::findOrFail($questionId);
            $questionDetail = $question->question;

            $questionDetail->delete();
            $question->delete();
            DB::commit();

            return response()->json([
                'message' => 'success',
            ]);
        }catch (\Exception $error) {
            DB::rollBack();

            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }

    public function updateQuestion(UpdateQuestionRequest $request, $questionId){
        DB::beginTransaction();
        try {
            $question = TestQuestion::findOrFail($questionId);
            if(isset($request->has_audio)) $question->has_audio = $request->has_audio;
            if(isset($request->audio_text)) $question->audio_text = $request->audio_text;
            if(isset($request->audio_lang)) $question->audio_lang = $request->audio_lang;
            if (isset($request->question_type) && $request->question_type != $question->question_type){
                $question->question->delete();
                $question->question_type = $request->question_type;
                $questionDetail = null;
                switch ($question->question_type){
                    case TestQuestion::MULTIPLE_CHOICE_QUESTION:
                        $questionDetail = QuizQuestion::create([
                            'question' => $request['question']['question'],
                            'answers' => json_encode($request['question']['answers']),
                            'correct_answer' =>  $request['question']['correct_answer'],
                        ]);
                        break;
                    case TestQuestion::TRUE_FALSE_QUESTION:
                        $questionDetail = TrueFalseQuestion::create([
                            'question' => $request['question']['question'],
                            'correct_answer' =>  $request['question']['correct_answer'],
                        ]);
                        break;
                    case TestQuestion::TYPE_ANSWER_QUESTION:
                        $questionDetail = TypeAnswerQuestion::create([
                            'question' => $request['question']['question'],
                            'correct_answer' =>  $request['question']['correct_answer'],
                        ]);
                        break;
                    default:
                        break;
                }
                $question->question()->associate($questionDetail);

            }else {
                $questionDetail = $question->question;
                if(isset($request['question']['question']))  $questionDetail->question = $request['question']['question'];
                if(isset($request['question']['correct_answer']))  $questionDetail->correct_answer = $request['question']['correct_answer'];
                if(isset($request['question']['answers']))  $questionDetail->answers = json_encode($request['question']['answers']);
                $questionDetail->save();
            }
            $question->save();

            DB::commit();

            return response()->json([
                'message' => 'success',
            ]);
        }catch (\Exception $error) {
            DB::rollBack();

            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }

}
