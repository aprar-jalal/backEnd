<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\NewNotification;
class NotificationController extends Controller
{
    public function byUserId($id)
    {
        return Notification::where('user_id',$id)->orderBy('created_at','desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,role_id',
            'from' => 'required|string',
            'message' => 'required|string',
            'isOpened' => 'boolean'
        ]);

        Log::info('Creating Notification', $data);
        $notification = Notification::create($data);

        broadcast(new NewNotification($notification))->toOthers();

        return response()->json($notification, 201);
    }






}
