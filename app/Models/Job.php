<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
<<<<<<< HEAD
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

=======
>>>>>>> 14cb334 (added models, routes, migrations, and controllers for admin dashboard)
use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
<<<<<<< HEAD

<<<<<<< Updated upstream
<<<<<<< Updated upstream
    use HasFactory, Notifiable;

=======
>>>>>>> 14cb334 (added models, routes, migrations, and controllers for admin dashboard)

=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    protected $primaryKey = 'job_id';

    protected $fillable = [
        'employer_id',
<<<<<<< HEAD
<<<<<<< Updated upstream
<<<<<<< Updated upstream
        'job_id',
        'job_title',
=======
        'title',
>>>>>>> 14cb334 (added models, routes, migrations, and controllers for admin dashboard)
        'description',
        'location',
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

<<<<<<< HEAD

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
=======
>>>>>>> 14cb334 (added models, routes, migrations, and controllers for admin dashboard)
    public function favoriteBy() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_favorite_jobs' ,'job_id ','user_id')->
            using(UserFavoriteJobs::class);
    }

    public function applications() : HasMany {
<<<<<<< HEAD
<<<<<<< Updated upstream
<<<<<<< Updated upstream
        return $this->hasMany(UserApplicationJob::class, 'job_id');
    }

=======
=======
>>>>>>> Stashed changes
        return $this->hasMany(JobApplication::class);
    }

=======
        return $this->hasMany(JobApplication::class);
    }

>>>>>>> 14cb334 (added models, routes, migrations, and controllers for admin dashboard)
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
<<<<<<< HEAD
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> 14cb334 (added models, routes, migrations, and controllers for admin dashboard)
}
