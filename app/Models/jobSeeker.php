<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jobSeeker extends Model
{
    protected $fillable = [
        'id',
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
