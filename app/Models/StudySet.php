<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySet extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
        'image_url',
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
    public function terms(){
        return $this->hasMany(Term::class,'study_set_id','id');
    }

    public function exams(){
        return $this->hasMany(StudySetTest::class,'study_set_id','id')->withCount('questions as question_count');
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'study_set_topics');
    }

    public function votes(){
        return $this->hasMany(Vote::class,'study_set_id','id');
    }
}
