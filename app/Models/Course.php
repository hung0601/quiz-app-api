<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function study_sets() {
        return $this->hasMany(StudySet::class, 'course_id', 'id');
    }

    public function enrollments() {
        return $this->hasMany(Enrollment::class, 'course_id', 'id');
    }


}
