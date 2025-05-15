<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{


    protected $fillable = [
        'job_id',
        'job_title',
        'description',
        'location',
        'salary',
        'job_type',
        'availability',
        ];

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
