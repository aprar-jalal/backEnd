<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jobSeeker extends Model
{
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'picture',
        'major',
        'background',
        'resume',
        'profile_description',
        'skills',
        'degree',
        'years_of_experience',
    ];
}
