<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\JobSeeker;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'phone' => 'required',
            'location' => 'required',
            'role_id' => 'required|in:2,3',
            'company_name' => 'nullable|string',
            'industry' => 'nullable|string',


            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'major' => 'nullable|string',
            'degree' => 'nullable|string',
            'years_of_experience' => 'nullable|integer',
            'gender' => 'nullable|in:male,female',

        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'location' => $validated['location'],
            'role_id' => $validated['role_id']
        ]);

        if ($user->role_id == 3) {
            Employer::create([
                'user_id' => $user->user_id,
                'company_name' => $validated['company_name'] ?? '',
                'industry' => $validated['industry'] ?? '',
            ]);
        } elseif ($user->role_id == 2) {
            JobSeeker::create([
                'user_id' => $user->user_id,
                'first_name' => $validated['first_name'] ?? '',
                'last_name' => $validated['last_name'] ?? '',
                'major' => $validated['major'] ?? '',
                'degree' => $validated['degree'] ?? '',
                'years_of_experience' => $validated['years_of_experience'] ?? 0,
                'gender' => $validated['gender'] ?? null,

            ]);
        }

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function logIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => [
                'id' => $user->user_id,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ],
            'authToken' => $token
        ]);
}

    public function logOut(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent.']);
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
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

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully.'])
            : response()->json(['message' => __($status)], 422);
    }



}
