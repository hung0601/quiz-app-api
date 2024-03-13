<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    public function studySets()
    {
        return $this->belongsToMany(StudySet::class, 'study_set_topics');
    }
}
