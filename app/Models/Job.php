<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'location',
        'type',
        'salary_min',
        'salary_max',
        'requirements',
        'responsibilities',
        'deadline',
        'is_active',
        'is_approved',
    ];


    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'job_user', 'job_id', 'user_id')
            ->withPivot(['status', 'applied_at'])   // حقول إضافية (اختياري)
            ->withTimestamps();
    }
}
