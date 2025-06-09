<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserApplicationJob extends Model
{
    protected $table = 'user_application_job';

    protected $fillable = [
        'user_id',
        'job_id',
        'application_status',
    ];

    public $timestamps = true;

    public function user() : BelongsTo {
     return $this->belongsTo(User::class, 'user_id');
 }

 public function job() : BelongsTo {
     return $this->belongsTo(Job::class, 'job_id');
 }

}
