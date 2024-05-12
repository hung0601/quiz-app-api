<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyResult extends Model
{
    use HasFactory;

    protected $fillable=[
        'term_id',
        'user_id',
        'correct_string',
        'status'
    ];
    const NOT_STUDIED = 0;
    const STILL_LEARNING = 1;
    const MASTERED = 2;

    public function term()
    {
        return $this->belongsTo(Term::class,'term_id','id');
    }
    public function user()
    {
        return $this->belongsTo(Term::class,'user_id','id');
    }

}
