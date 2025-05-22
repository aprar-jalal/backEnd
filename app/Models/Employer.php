<?php

namespace App\Models;

use \Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Employer extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $primaryKey = 'employer_id';
    protected $fillable = [
        'user_id',
        'company_name',
        'description',
        'industry',
        'logo_url',
        'established_date',
        'company_size',
        'verified',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }
    function jobs()
    {
        return $this->hasMany(Job::class, 'employer_id');
    }
}
