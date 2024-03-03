<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySetTopic extends Model
{
    use HasFactory;
    protected $fillable=[
        'topic_id',
        'study_set_id',
    ];
    public function topic() {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }
    public function study_set() {
        return $this->belongsTo(StudySet::class, 'study_set_id', 'id');
    }
}
