<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use \Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Job extends Authenticatable
{

    use HasFactory, Notifiable;


    protected $primaryKey = 'job_id';

    protected $fillable = [
        'employer_id',
        'job_id',
        'job_title',
        'description',
        'location',
        'salary',
        'job_type',
        'availability',
        ];


    function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function favoriteBy() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_favorite_jobs' ,'job_id ','role_id')->
            using(UserFavoriteJobs::class);
    }

    public function applications() : BelongsToMany {
        return $this->belongsToMany(User::class,'user_application_job','role_id','job_id')
            ->using(UserApplicationJob::class)
            ->withPivot('applicationStatus')
            ->withTimestamps();
    }

}
