<?php

namespace App\Http\Controllers;

use App\Models\JobSeeker;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
class JobSeekerController extends Controller
{

    public function getMyProfile(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $jobSeeker = $user->jobSeeker;

        return response()->json($jobSeeker);
    }


    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $jobSeeker = $user->jobSeeker;

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

        $jobSeeker->update($data);
        $user->update([
            'phone' => $request->phone,
            'location' => $request->location,
        ]);

        return response()->json(['message' => 'Profile updated successfully']);
    }


    public function getAppliedJobs()
    {
        $user = Auth::user();
        $jobs = $user->appliedJobs()->withPivot('applicationStatus')->get();

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

        $path = $request->file('resume')->store('resumes', 'public');

        $jobSeeker = Auth::user()->jobSeeker;
        $jobSeeker->resume = $path;
        $jobSeeker->save();

        return response()->json(['message' => 'Resume uploaded successfully']);
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|max:2048',
        ]);

        $path = $request->file('picture')->store('pictures', 'public');

        $jobSeeker = Auth::user()->jobSeeker;
        $jobSeeker->picture = $path;
        $jobSeeker->save();

        return response()->json(['message' => 'Profile picture updated']);
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
*/

