<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_employers' => User::where('role', 'employer')->count(),
            'total_job_seekers' => User::where('role', 'jobseeker')->count(),
            'total_jobs' => Job::count(),
            'pending_approvals' => User::where('role', 'employer')
                                    ->where('is_approved', false)
                                    ->count(),
            'active_jobs' => Job::where('is_active', true)->count(),
        ];

        return response()->json($stats);
    }

    public function users()
    {
        $users = User::where('role', '!=', 'admin')
                    ->with(['postedJobs', 'jobApplications'])
                    ->get();

        return response()->json($users);
    }

    public function approveEmployer($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== 'employer') {
            return response()->json(['message' => 'User is not an employer'], 400);
        }

        $user->update(['is_approved' => true]);

        return response()->json(['message' => 'Employer approved successfully']);
    }

    public function rejectEmployer($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== 'employer') {
            return response()->json(['message' => 'User is not an employer'], 400);
        }

        $user->update(['is_approved' => false]);

        return response()->json(['message' => 'Employer rejected successfully']);
    }

    public function jobs()
    {
        $jobs = Job::with(['employer', 'applications'])
                   ->get();

        return response()->json($jobs);
    }

    public function removeJob($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return response()->json(['message' => 'Job removed successfully']);
    }

    public function generateReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $report = [
            'jobs_stats' => [
                'total_posted' => Job::whereBetween('created_at', [$startDate, $endDate])->count(),
                'active_jobs' => Job::whereBetween('created_at', [$startDate, $endDate])
                                  ->where('is_active', true)
                                  ->count(),
                'applications_received' => JobApplication::whereBetween('created_at', [$startDate, $endDate])
                                                      ->count(),
            ],
            'top_job_categories' => Job::select('type', DB::raw('count(*) as total'))
                                      ->whereBetween('created_at', [$startDate, $endDate])
                                      ->groupBy('type')
                                      ->orderByDesc('total')
                                      ->get(),
            'application_status' => JobApplication::select('status', DB::raw('count(*) as total'))
                                                ->whereBetween('created_at', [$startDate, $endDate])
                                                ->groupBy('status')
                                                ->get(),
        ];

        return response()->json($report);
    }
} 