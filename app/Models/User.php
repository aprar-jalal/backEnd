<?php

namespace App\Models;

use App\Models\Notifications\CustomResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\ResetPassword as ResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'user_id';
   protected $fillable = [
        'email',
        'password',
        'role_id',
        'phone',
        'location',
        'password_reset_token',
    ];
 

    public function jobSeeker(): \Illuminate\Database\Eloquent\Relations\HasOne

    {
        return $this->hasOne(JobSeeker::class, 'user_id', 'user_id'); //foreign ->jobseeker , local->user
    }



    public static function factory(){
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
        return $this->hasMany(UserApplicationJob::class, 'user_id', 'user_id');

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


