<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\JobSeeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class JobSeekerController extends Controller
{

    public function getMyProfile($user_id)
    {
        $user = User::find($user_id);
        if (!$user || !$user->jobSeeker) {
            return response()->json(['message' => 'Job seeker profile not found'], 404);
        }

        return response()->json([
            'user' => $user,
            'jobSeeker' => $user->jobSeeker,
        ]);
    }

    public function updateProfile(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

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
            'gender' => 'nullable|string',
        ]);

        $userData = array_filter($request->only('phone', 'location', 'gender'), fn($value) => !is_null($value) && $value !== '');

        if (!empty($userData)) {
            $user->update($userData);
        }

        if ($user->jobSeeker) {
            $user->jobSeeker->update(array_filter($data, fn($value) => !is_null($value) && $value !== ''));
        } else {
            JobSeeker::create(array_merge($data, ['user_id' => $user->id]));
        }

        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function getAppliedJobs($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $appliedJobs = $user->AppliedJobs()->with('job')->get();

        return response()->json($appliedJobs);
    }

    public function getFavoriteJobs($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $favorites = $user->favoriteJobs()->get();

        return response()->json($favorites);
    }

    public function uploadResume(Request $request, $user_id)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = User::find($user_id);
        if (!$user || !$user->jobSeeker) {
            return response()->json(['message' => 'Job seeker profile not found'], 404);
        }

        $jobSeeker = $user->jobSeeker;

        try {
            if ($jobSeeker->resume) {
                Storage::disk('public')->delete($jobSeeker->resume);
            }

            $path = $request->file('resume')->store('resumes', 'public');
            $jobSeeker->resume = $path;
            $jobSeeker->save();

            return response()->json(['message' => 'Resume uploaded successfully', 'path' => Storage::url($path)]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to upload resume'], 500);
        }
    }

    public function uploadProfilePicture(Request $request, $user_id)
    {
        $request->validate([
            'picture' => 'required|image|max:2048',
        ]);

        $user = User::find($user_id);
        if (!$user || !$user->jobSeeker) {
            return response()->json(['message' => 'Job seeker profile not found'], 404);
        }

        $jobSeeker = $user->jobSeeker;

        try {
            if ($jobSeeker->picture) {
                Storage::disk('public')->delete($jobSeeker->picture);
            }

            $path = $request->file('picture')->store('pictures', 'public');
            $jobSeeker->picture = $path;
            $jobSeeker->save();

            // هنا أرجع المسار النسبي فقط بدون Storage::url
            return response()->json(['message' => 'Profile picture updated', 'path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to upload profile picture'], 500);
        }
    }

    public function uploadBackgroundPicture(Request $request, $user_id)
    {
        $request->validate([
            'background_image' => 'required|image|max:2048',
        ]);

        $user = User::find($user_id);
        if (!$user || !$user->jobSeeker) {
            return response()->json(['message' => 'Job seeker profile not found'], 404);
        }

        $jobSeeker = $user->jobSeeker;

        try {
            if ($jobSeeker->background_image) {
                Storage::disk('public')->delete($jobSeeker->background_image);
            }

            $path = $request->file('background_image')->store('backgrounds', 'public');
            $jobSeeker->background_image = $path;
            $jobSeeker->save();

            // نفس الشيء هنا، المسار النسبي فقط
            return response()->json(['message' => 'Background image uploaded successfully', 'path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to upload background image'], 500);
        }
    }


    public function changePassword(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
}




