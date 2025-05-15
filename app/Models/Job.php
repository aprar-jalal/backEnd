<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{


    protected $fillable = [
        'job_title',
        'description',
        'location',
        'salary',
        'job_type',
        'availability',
        ];
}
