<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class User extends Model{
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
