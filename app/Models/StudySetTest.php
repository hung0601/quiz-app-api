<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySetTest extends Model
{
    use HasFactory;
    protected $fillable=[
        'study_set_id',
        'test_name'
    ];

    public function study_set() {
        return $this->belongsTo(StudySet::class, 'study_set_id', 'id');
    }
}
