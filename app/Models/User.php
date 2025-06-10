<?php

namespace App\Models;

use App\Models\Notifications\CustomResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\ResetPassword as ResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'company_name',
        'company_description',
        'phone',
        'address',
        'resume_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_approved' => 'boolean',
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

    public function postedJobs()
    {
        return $this->hasMany(Job::class, 'employer_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEmployer()
    {
        return $this->role === 'employer';
    }

    public function isJobSeeker()
    {
        return $this->role === 'jobseeker';
    }
}


