<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer',
            'email' => 'required|email|string|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:15',
            'location' => 'nullable|string|max:255'
        ]);

        $user = User::create([
            'role_id' => $request['role_id'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'gender' => $request['gender'],
            'phone' => $request['phone'],
            'location' => $request['location'] ?? null,
        ]);

        return response()->json([
            'message' => 'User signed up successfully.',
            'User' => $user
        ], 201);
    }

    public function logIn(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email or password is wrong.',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User login successfully.',
            'User' => $user,
            'Token' => $token
        ], 200);
    }

    public function logOut(Request $request)
    {
        $user = Auth::user();


        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json([
            'message' => 'User logged out successfully.'
        ]);
    }
}
