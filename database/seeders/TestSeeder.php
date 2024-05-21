<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use App\Models\StudySet;
use App\Models\StudySetTest;
use App\Models\TestQuestion;
use App\Models\TrueFalseQuestion;
use App\Models\TypeAnswerQuestion;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $test = StudySetTest::create([
            'study_set_id' => 1,
            'test_name' => "Test"
        ]);
        $questionType1 = QuizQuestion::create([
            'question' => "Result of : 1+ 1 ?",
            'answers' => json_encode(["A. 1", "B. 2", "C. 3", "D. 4"]),
            'correct_answer' => 1,
        ]);
        $questionType2 = TrueFalseQuestion::create([
            'question' => "1+ 1 = 2 ?",
            'correct_answer' => true,
        ]);
        $questionType3 = TypeAnswerQuestion::create([
            'question' => "Con chó trong tiếng anh là gì?",
            'correct_answer' => "Dog",
        ]);
        $question1 =  new TestQuestion;
        $question1->test_id = $test->id;
        $question1->term_referent_id = 1;
        $question1->point = 10;
        $question1->question()->associate($questionType1);
        $question1->save();

        $question2 =  new TestQuestion;
        $question2->test_id = $test->id;
        $question2->term_referent_id = 2;
        $question2->point = 10;
        $question2->question()->associate($questionType2);
        $question2->save();

        $question3 =  new TestQuestion;
        $question3->test_id = $test->id;
        $question3->term_referent_id = 3;
        $question3->point = 10;
        $question3->question()->associate($questionType3);
        $question3->save();
    }
}
