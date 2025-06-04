<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;

    protected $primaryKey = 'job_seeker_id';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'picture',
        'major',
        'background_image',
        'resume',
        'profile_description',
        'skills',
        'degree',
        'years_of_experience',
        'gender',

    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

