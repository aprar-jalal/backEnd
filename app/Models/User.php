<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    protected $fillable = [
        'role_id',
        'email',
        'password',
        'gender',
        'phone',
        'location',
        'password_reset_token',
    ];

}
