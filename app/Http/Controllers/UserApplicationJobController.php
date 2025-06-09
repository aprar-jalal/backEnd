<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
use App\Models\UserApplicationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApplicationJobController extends Controller
{
    //start abrar jalal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,job_id',
        ]);
        $userID = Auth::id();

        $AppliedBefore = UserApplicationJob::where('user_id', $userID)
            ->where('job_id', $validated['job_id'])
            ->first();

        if ($AppliedBefore) {
            return response()->json(['message' => 'This job was already applied before.'], 409);
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


    //mohammad
    public function displayApplicationsForEmployer()
    {

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $employer = Employer::where('user_id', $user->user_id)->first();

        if (!$employer) {
            return response()->json(['error' => 'Employer not found'], 404);
        }



        $applications = UserApplicationJob::select('user_application_job.*')
            ->join('jobs', 'user_application_job.job_id', '=', 'jobs.job_id')
            ->where('jobs.employer_id', $employer->employer_id)
            ->with(['user', 'job'])
            ->get()
            ->map(function ($application) {
                return [
                    'application_id' => $application->id,
                    'job_title' => $application->job->job_title,
                    'job_type' => $application->job->job_type,
                    'salary' => $application->job->salary,
                    'location' => $application->job->location,
                    'description' => $application->job->description,
                    'applied_at' => $application->created_at,
                    'application_status' => $application->application_status,
                    'applicant' => [
                        'name' => $application->user->name,
                        'email' => $application->user->email,
                        'birth_date' => $application->user->birth_date,
                        'country' => $application->user->location,
                        'major' => $application->user->major,
                        'avatar' => $application->user->avatar,
                        'id' => $application->user->user_id,
                        'description' => $application->user->description,
                    ],
                ];
            });

        if ($applications->isEmpty()) {
            return response()->json(['message' => 'No applications found'], 404);
        }

        return response()->json($applications, 200);
    }

}
