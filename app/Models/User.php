<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [

        'role_id',
        'email',
        'password',
        'gender',
        'phone',
        'location',
        'password_reset_token',
    ];

    public function jobSeeker()
    {
        return $this->hasOne(JobSeeker::class);
    }

    public function Employer()
    {
        return $this->hasOne(Employer::class);
    }


    public function favoriteJob() : BelongsToMany{
        return $this->belongsToMany(Job::class, 'user_favorite_jobs' ,'job_id ','user_id')
            ->using(UserFavoriteJobs::class);
    }

    public Function AppliedJobs() : BelongsToMany{
        return $this->belongsToMany(Job::class, 'user_application_job' ,'job_id ','user_id')
            ->using(UserApplicationJob::class)
            ->withPivot('applicationStatus')
            ->withTimestamps();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
