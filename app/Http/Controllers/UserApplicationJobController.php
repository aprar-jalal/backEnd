<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\UserApplicationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApplicationJobController extends Controller
{
    //start abrar jalal
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,job_id',
        ]);
//        $userID = Auth::id();
        $userID=1;
        $AppliedBefore = UserApplicationJob::where('user_id', $userID)
            ->where('job_id', $validated['job_id'])
            ->first();

        if ($AppliedBefore) {
            return response()->json(['message' => 'This job was already applied for.'], 409);
        }

        $applicationProcess = UserApplicationJob::create([
            'user_id' => $userID,
            'job_id' => $validated['job_id'],
            'application_status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Applied successfully',
            'application' => $applicationProcess
        ], 201);
    }

    //end
}
