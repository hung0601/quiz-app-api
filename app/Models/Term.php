<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    protected $fillable=[
        'study_set_id',
        'term',
        'definition',
        'image_url'
    ];


    public function study_set() {
        return $this->belongsTo(StudySet::class, 'study_set_id', 'id');
    }

    public function study_results()
    {
        return $this->hasMany(StudyResult::class, 'term_id', 'id');
    }
}
