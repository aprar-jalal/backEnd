<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{


    protected $fillable = [
        'company_name',
        'description',
        'industry',
        'logo_url',
        'established_date',
        'company_size',
        'verified',
    ];
}
