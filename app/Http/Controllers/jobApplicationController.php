<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class jobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $users = User::query()
            ->when($status === 'pending', fn($q) => $q->where('is_approved', false))
            ->when($status === 'approved', fn($q) => $q->where('is_approved', true))
            ->when($status === 'rejected', fn($q) => $q->where('is_approved', false)->where('role', '!=', 'employer'))
            ->orderByDesc('created_at')
            ->get();

        return response()->json($users);
    }

    // الموافقة على مستخدم
    public function approve(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return response()->json(['message' => 'User approved successfully.', 'user' => $user]);
    }

    // رفض مستخدم
    public function reject(User $user)
    {
        $user->is_approved = false;
        $user->save();

        return response()->json(['message' => 'User rejected successfully.', 'user' => $user]);
    }
}
