<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $users = User::query()
            ->when($status === 'pending', fn($q) => $q->where('is_approved', false))
            ->when($status === 'approved', fn($q) => $q->where('is_approved', true))
            ->when($status === 'rejected', fn($q) => $q->where('is_approved', false)->where('role', '!=', 'employer'))
            ->orderByDesc('created_at')
            ->get(['id', 'name', 'email', 'role', 'created_at', 'is_approved']);

        return response()->json($users);
    }

    public function approve(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return response()->json(['message' => 'User approved successfully.', 'user' => $user]);
    }

    public function reject(User $user)
    {
        $user->is_approved = false;
        $user->save();

        return response()->json(['message' => 'User rejected successfully.', 'user' => $user]);
    }
}
