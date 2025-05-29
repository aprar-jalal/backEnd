<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';


        'role_id',
        'email',
        'password',
        'gender',
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


 public function favoriteJobs() : BelongsToMany{
        return $this->belongsToMany(Job::class, 'user_favorite_jobs' ,'user_id','job_id')
            ->using(UserFavoriteJobs::class);
    }

   public Function AppliedJobs() : HasMany {
        return $this->hasMany(UserApplicationJob::class);

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
        $url = 'https://spa.test/reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }

}

