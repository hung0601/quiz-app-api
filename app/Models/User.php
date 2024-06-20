<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const FRIEND_PENDING = 0;
    public const FRIEND_APPROVED = 1;
    public const FRIEND_REJECTED = 2;
    public const FRIEND_DELETED = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function courses() {
        return $this->hasMany(Course::class, 'owner_id', 'id');
    }
    public function study_sets() {
        return $this->hasMany(StudySet::class, 'owner_id', 'id');
    }
    public function enrollments() {
        return $this->hasMany(Enrollment::class, 'user_id', 'id');
    }
    public function enrollRequests() {
        return $this->hasMany(EnrollmentRequest::class, 'participant_id', 'id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_followers', 'user_id', 'following_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_followers', 'following_id', 'user_id');
    }
}
