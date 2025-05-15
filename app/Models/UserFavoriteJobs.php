<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserFavoriteJobs extends Pivot
{
    protected $table = 'user_favorite_job';

}
