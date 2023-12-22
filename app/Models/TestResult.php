<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;
    protected $fillable=[
        'question_id',
        'user_id',
        'selected_answer_id'
    ];

    public function question() {
        return $this->belongsTo(TestQuestion::class, 'question_id', 'id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function selected_answer() {
        return $this->belongsTo(Answer::class, 'selected_answer_id', 'id');
    }
}
