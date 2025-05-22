<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    protected $fillable = [
        'role_id',
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
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'role_id', 'role_id');
    }
}

