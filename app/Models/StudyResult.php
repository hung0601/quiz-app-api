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
        'status'
    ];

    public function term()
    {
        return $this->belongsTo(Term::class,'term_id','id');
    }
    public function user()
    {
        return $this->belongsTo(Term::class,'user_id','id');
    }

}
