<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model{
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
        return $this->belongsToMany(Job::class, 'user_favorite_jobs' ,'job_id ','role_id')
            ->using(UserFavoriteJobs::class);
    }

    public Function AppliedJobs() : BelongsToMany{
        return $this->belongsToMany(Job::class, 'user_application_job' ,'job_id ','role_id')
            ->using(UserApplicationJob::class)
            ->withPivot('applicationStatus')
            ->withTimestamps();
    }
}
