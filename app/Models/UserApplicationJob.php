<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserApplicationJob extends Pivot
{
    protected $table = 'user_application_job';

    protected $fillable = [
        'user_id',
        'job_id',
        'application_status',
    ];

    public $timestamps = true;
}
