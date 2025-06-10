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
            'application_status' => 'Under Review'
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
            ->join('job_seekers', 'user_application_job.user_id', '=', 'job_seekers.user_id')
            ->join('users', 'job_seekers.user_id', '=', 'users.user_id')
            ->where('jobs.employer_id', $employer->employer_id)
            ->with(['user', 'job', 'user.jobSeeker'])
            ->get()
            ->map(function ($application) {
                return [
                    'application_id' => $application->id,
                    'job_id' => $application->job_id,
                    'job_title' => $application->job->job_title,
                    'job_type' => $application->job->job_type,
                    'salary' => $application->job->salary,
                    'location' => $application->job->location,
                    'description' => $application->job->description,
                    'availability' => $application->job->availability,
                    'workplace' => $application->job->workplace,
                    'job_category' => $application->job->job_category,
                    'applied_at' => $application->created_at,
                    'application_status' => $application->application_status,

                    'jobSeekerEmail' => $application->user->email,
                    'jobSeekerPhone' => $application->user->phone,
                    'jobSeekerCountry' => $application->user->location,
                    'user_id' => $application->user->user_id,

                    'jobSeekerName' => $application->user->jobSeeker->first_name . ' ' . $application->user->jobSeeker->last_name,
                    'jobSeekerMajor' => $application->user->jobSeeker->major,
                    'jobSeekerAvatar' => $application->user->jobSeeker->picture,
                    'jobSeekerDescription' => $application->user->jobSeeker->profile_description,
                    'jobSeekerResume' => $application->user->jobSeeker->resume,
                    'jobSeekerSkills' => implode(', ', $application->user->jobSeeker->skills),
                    'jobSeekerDegree' => $application->user->jobSeeker->degree,
                    'jobSeekerExperience' => $application->user->jobSeeker->years_of_experience,
                    'jobSeekerGender' => $application->user->jobSeeker->gender,
                    'job_seeker_id' => $application->user->jobSeeker->job_seeker_id,
                ];
            });


        if ($applications->isEmpty()) {
            return response()->json(['message' => 'No applications found'], 404);
        }

        return response()->json($applications, 200);
    }


    public function getApplicationAndJobDetails($application_id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $employer = Employer::where('user_id', $user->user_id)->first();

        if (!$employer) {
            return response()->json(['error' => 'Employer not found'], 404);
        }

        $application = UserApplicationJob::select('user_application_job.*')
            ->join('jobs', 'user_application_job.job_id', '=', 'jobs.job_id')
            ->where('jobs.employer_id', $employer->employer_id)
            ->where('user_application_job.id', $application_id)
            ->with(['job'])
            ->first();

        if (!$application) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        $applicationAndJobDetails = [
            'application_id' => $application->id,
            'job_id' => $application->job_id,
            'applied_at' => $application->created_at,
            'application_status' => $application->application_status,

            'job_title' => $application->job->job_title,
            'description' => $application->job->description,
            'location' => $application->job->location,
            'salary' => $application->job->salary,
            'job_type' => $application->job->job_type,
            'availability' => $application->job->availability,
            'workplace' => $application->job->workplace,
            'job_category' => $application->job->job_category,
        ];

        return response()->json($applicationAndJobDetails, 200);
    }



    public function getJobSeekerDetailsFromApplication($application_id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $employer = Employer::where('user_id', $user->user_id)->first();

        if (!$employer) {
            return response()->json(['error' => 'Employer not found'], 404);
        }

        $application = UserApplicationJob::select('user_application_job.*')
            ->join('jobs', 'user_application_job.job_id', '=', 'jobs.job_id')
            ->join('job_seekers', 'user_application_job.user_id', '=', 'job_seekers.user_id')
            ->join('users', 'job_seekers.user_id', '=', 'users.user_id')
            ->where('jobs.employer_id', $employer->employer_id)
            ->where('user_application_job.id', $application_id)
            ->with(['user', 'user.jobSeeker'])
            ->first();

        if (!$application) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        $jobSeekerDetails = [
            'jobSeekerEmail' => $application->user->email,
            'jobSeekerPhone' => $application->user->phone,
            'jobSeekerCountry' => $application->user->location,
            'user_id' => $application->user->user_id,
            'application_status' => $application->application_status,

            'jobSeekerName' => $application->user->jobSeeker->first_name . ' ' . $application->user->jobSeeker->last_name,
            'jobSeekerMajor' => $application->user->jobSeeker->major,
            'jobSeekerAvatar' => $application->user->jobSeeker->picture,
            'jobSeekerDescription' => $application->user->jobSeeker->profile_description,
            'jobSeekerResume' => $application->user->jobSeeker->resume,
            'jobSeekerSkills' => implode(', ', $application->user->jobSeeker->skills ?? []),
            'jobSeekerDegree' => $application->user->jobSeeker->degree,
            'jobSeekerExperience' => $application->user->jobSeeker->years_of_experience,
            'jobSeekerGender' => $application->user->jobSeeker->gender,
            'job_seeker_id' => $application->user->jobSeeker->job_seeker_id,
        ];

        return response()->json($jobSeekerDetails, 200);
    }

    public function updateApplicationStatus(Request $request, $application_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $status = $request->input('application_status');

        if (!$status) {
            return response()->json(['error' => 'Status is required'], 400);
        }

        $allowedStatuses = ['Under Review', 'Accepted', 'Rejected'];
        if (!in_array($status, $allowedStatuses)) {
            return response()->json(['error' => 'Invalid status'], 400);
        }

        $application = UserApplicationJob::find($application_id);

        if (!$application) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        $application->application_status = $status;
        $application->updated_at = now();
        $application->save();

        return response()->json([
            'message' => 'Application status updated successfully',
            'application_id' => $application->id,
            'new_status' => $application->application_status,
            'updated_at' => $application->updated_at
        ], 200);
    }

}
