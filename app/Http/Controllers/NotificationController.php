<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function byUserId($userId)
    {
        return Notification::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }


}
