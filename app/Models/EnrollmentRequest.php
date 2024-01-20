<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentRequest extends Model
{
    use HasFactory;
    protected $fillable=[
        'type',
        'course_id',
        'participant_id'
    ];
    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function participant() {
        return $this->belongsTo(User::class, 'participant_id', 'id');
    }
}
