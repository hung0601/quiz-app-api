<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySet extends Model
{
    use HasFactory;

    public const VIEW_ACCESS_LEVEL = 0;
    public const EDIT_ACCESS_LEVEL = 1;
    public const PUBLIC_ACCESS_TYPE = 0;
    public const SHARE_WITH_FOLLOWER_ACCESS_TYPE = 1;
    public const PRIVATE_ACCESS_TYPE = 2;
    protected $fillable=[
        'title',
        'description',
        'image_url',
        'access_type'
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

    public function members(){
        return $this->belongsToMany(User::class, 'study_set_access')->withPivot('access_level');
    }
}
