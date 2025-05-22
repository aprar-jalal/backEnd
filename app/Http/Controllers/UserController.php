<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

    public function checkout()
    {
        if (Auth::check()) {
            return response()->json(['status' => true, 'message' => 'User is logged in.']);
        }

        return response()->json(['status' => false, 'message' => 'No user is logged in.']);
    }


    public function currentUser()
    {
        if (Auth::check()) {
            return response()->json(Auth::user());
        }

        return response()->json(['message' => 'No user is currently logged in.'], 401);
    }


    public function manualLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login successful.', 'user' => Auth::user()]);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully.']);
    }
}

