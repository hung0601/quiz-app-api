<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;
    protected $fillable=[
        'test_id',
        'term_referent_id',
        'question',
        'point',
        'type'
    ];

    public function study_set_test() {
        return $this->belongsTo(StudySetTest::class, 'test_id', 'id');
    }
    public function term_referent() {
        return $this->belongsTo(Term::class, 'term_referent_id', 'id');
    }
    public function answers(){
        return $this->hasMany(Answer::class,'question_id','id');
    }
}
