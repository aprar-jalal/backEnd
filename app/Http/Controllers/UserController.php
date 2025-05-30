<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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


    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Email address not found.'],
            ]);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Password reset link sent successfully.'
            ], 200);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Password reset successfully.'
            ], 200);
        }

        return response()->json([
            'message' => __($status)
        ], 500);
    }


    public function adminOnly(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role_id != 1) {
            return response()->json(['message' => 'Unauthorized. Admin only.'], 403);
        }

        return response()->json(['message' => 'Welcome, Admin!']);
    }

    public function jobSeekerOnly(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role_id != 2) {
            return response()->json(['message' => 'Unauthorized. Job Seeker only.'], 403);
        }

        return response()->json(['message' => 'Welcome, Job Seeker!']);
    }

    public function employerOnly(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role_id != 3) {
            return response()->json(['message' => 'Unauthorized. Employer only.'], 403);
        }

        return response()->json(['message' => 'Welcome, Employer!']);
    }
}
