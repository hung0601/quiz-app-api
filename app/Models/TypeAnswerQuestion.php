<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAnswerQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'correct_answer'];

    public function testQuestion() {
        return $this->morphOne(TestQuestion::class, 'question');
    }
}
