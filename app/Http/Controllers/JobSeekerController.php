<?php

namespace App\Http\Controllers;

use App\Models\JobSeeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class JobSeekerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');                  // لازم يكون ال user  مسجل دخوله
    }

    public function getMyProfile(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();                          // بترجعلك اليوزر اللي حالياً مسجل دخول
        $jobSeeker = $user->jobSeeker;

        return response()->json([
            'user' => $user,
            'jobSeeker' => $jobSeeker,
        ]);
    }

    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $data = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'profile_description' => 'nullable|string',
            'skills' => 'nullable|array',
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'major' => 'nullable|string',
            'degree' => 'nullable|string',
            'years_of_experience' => 'nullable|integer',
        ]);

        if (isset($data['phone']) || isset($data['location'])) {
            $user->update($request->only('phone', 'location'));
        }

        $jobSeeker = $user->jobSeeker;
        if ($jobSeeker) {
            $jobSeeker->update($data);
        } else {
            $jobSeeker = JobSeeker::create(array_merge($data, ['user_id' => $user->user_id]));
        }

        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function getAppliedJobs()
    {
        $user = Auth::user();
        $jobs = $user->AppliedJobs()->withPivot('applicationStatus')->get();

        return response()->json($jobs);
    }

    public function getFavoriteJobs()
    {
        $user = Auth::user();
        $favorites = $user->favoriteJob()->get();

        return response()->json($favorites);
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $jobSeeker = Auth::user()->jobSeeker;

        if (!$jobSeeker) {
            return response()->json(['message' => 'Job seeker profile not found'], 404);
        }

        if ($jobSeeker->resume) {
            Storage::disk('public')->delete($jobSeeker->resume);
        }

        $path = $request->file('resume')->store('resumes', 'public');
        $jobSeeker->resume = $path;
        $jobSeeker->save();

        return response()->json(['message' => 'Resume uploaded successfully', 'path' => Storage::url($path)]);
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|max:2048',
        ]);

        $jobSeeker = Auth::user()->jobSeeker;

        if (!$jobSeeker) {
            return response()->json(['message' => 'Job seeker profile not found'], 404);
        }

        if ($jobSeeker->picture) {
            Storage::disk('public')->delete($jobSeeker->picture);
        }

        $path = $request->file('picture')->store('pictures', 'public');
        $jobSeeker->picture = $path;
        $jobSeeker->save();

        return response()->json(['message' => 'Profile picture updated', 'path' => Storage::url($path)]);
    }

    public function uploadBackgroundPicture(Request $request)
    {
        $request->validate([
            'background_image' => 'required|image|max:2048',
        ]);

        $jobSeeker = Auth::user()->jobSeeker;

        if (!$jobSeeker) {
            return response()->json(['message' => 'Job seeker profile not found'], 404);
        }

        if ($jobSeeker->background_image) {
            Storage::disk('public')->delete($jobSeeker->background_image);
        }
        $path = $request->file('background_image')->store('backgrounds', 'public');

        $jobSeeker->background_image = $path;
        $jobSeeker->save();

        return response()->json([
            'message' => 'Background image uploaded successfully',
            'path' => Storage::url($path),
        ]);
    }



    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
}



