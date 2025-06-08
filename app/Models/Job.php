<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'job_full_disc',
        'workplace',
        'category'
    ];


    function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function favoriteBy() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_favorite_jobs' ,'job_id ','user_id')->
            using(UserFavoriteJobs::class);
    }

    public function applications() : HasMany {
        return $this->hasMany(UserApplicationJob::class);
    }

}
