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
        'image_url'
    ];

    public function terms(){
        return $this->hasMany(Term::class,'study_set_id','id');
    }

    public function study_set_tests(){
        return $this->hasMany(StudySetTest::class,'study_set_id','id');
    }
}
