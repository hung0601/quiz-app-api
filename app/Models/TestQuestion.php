<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;
    const MULTIPLE_CHOICE_QUESTION = "App\\Models\\QuizQuestion";
    const TYPE_ANSWER_QUESTION = "App\\Models\\TypeAnswerQuestion";
    const TRUE_FALSE_QUESTION = "App\\Models\\TrueFalseQuestion";
    protected $fillable=[
        'test_id',
        'term_referent_id',
        'has_audio',
        'audio_text',
        'audio_lang',
        'question',
        'question_type',
        'question_id',
        'point',
    ];

    public function study_set_test() {
        return $this->belongsTo(StudySetTest::class, 'test_id', 'id');
    }
    public function term_referent() {
        return $this->belongsTo(Term::class, 'term_referent_id', 'id');
    }

    public function question()
    {
        return $this->morphTo();
    }
}
