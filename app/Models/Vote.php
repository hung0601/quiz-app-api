<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
//    protected $primaryKey = ['study_set_id', 'user_id'];
//     public $incrementing = false; 

    protected $fillable=[
        'user_id',
        'study_set_id',
        'star'
    ];
    protected $guarded = [];
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function study_set() {
        return $this->belongsTo(StudySet::class, 'study_set_id', 'id');
    }
}
