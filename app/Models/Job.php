<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
=======
>>>>>>> Stashed changes
use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Job extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

<<<<<<< Updated upstream
<<<<<<< Updated upstream
    use HasFactory, Notifiable;


=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    protected $primaryKey = 'job_id';

    protected $fillable = [
        'employer_id',
<<<<<<< Updated upstream
<<<<<<< Updated upstream
        'job_id',
        'job_title',
        'description',
        'location',
        'salary',
        'job_type',
        'availability',
        'workplace',
        'job_category'
    ];


    function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }


=======
        'title',
        'description',
        'location',
=======
        'title',
        'description',
        'location',
>>>>>>> Stashed changes
        'type',
        'salary_min',
        'salary_max',
        'requirements',
        'responsibilities',
        'deadline',
        'is_active',
        'is_approved'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    public function favoriteBy() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_favorite_jobs' ,'job_id ','user_id')->
            using(UserFavoriteJobs::class);
    }

    public function applications() : HasMany {
<<<<<<< Updated upstream
<<<<<<< Updated upstream
        return $this->hasMany(UserApplicationJob::class, 'job_id');
    }

=======
=======
>>>>>>> Stashed changes
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
}
