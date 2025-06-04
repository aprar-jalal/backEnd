<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\ResetPassword as ResetPasswordNotification;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $fillable = [

        'role_id',
        'email',
        'password',

        'phone',
        'location',

    ];

    protected $hidden = [
        'password',

    ];

    public function jobSeeker(): \Illuminate\Database\Eloquent\Relations\HasOne

    {
        return $this->hasOne(JobSeeker::class, 'user_id', 'user_id'); //foreign ->jobseeker , local->user
    }


    public function Employer()
    {
        return $this->hasOne(Employer::class);
    }


    public function favoriteJob(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'user_favorite_jobs', 'job_id ', 'user_id')
            ->using(UserFavoriteJobs::class);
    }

    public function AppliedJobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'user_application_job', 'job_id ', 'user_id')
            ->using(UserApplicationJob::class)
            ->withPivot('applicationStatus')
            ->withTimestamps();
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function Notification()
    {
        return $this->hasMany(Notification::class);

    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

}

