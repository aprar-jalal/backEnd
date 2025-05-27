<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'email',
        'password',
        'gender',
        'phone',
        'location',
        'password_reset_token',
    ];


  function employer()
    {
        return $this->hasOne(Employer::class);
    }


    public static function factory()
    {
    }

    public function jobSeeker(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(JobSeeker::class, 'role_id', 'role_id');
    }

    public function favoriteJob() : BelongsToMany{
        return $this->belongsToMany(Job::class, 'user_favorite_jobs' ,'user_id','job_id')
            ->using(UserFavoriteJobs::class);
    }

    public Function AppliedJobs() : HasMany {
        return $this->hasMany(UserApplicationJob::class);
    }
}
