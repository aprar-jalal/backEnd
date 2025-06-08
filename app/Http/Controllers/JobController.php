<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    function getJobsForEmployer()
    {
         $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $employer = Employer::with('jobs')->where('user_id', $user->user_id)->first();

        if (!$employer) {
            return response()->json(['message' => 'Employer profile not found'], 404);
        }

        return response()->json($employer->jobs, 200);
    }

    function store(Request $request)
    {
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->user_id)->first();

        if (!$employer) {
            return response()->json(['message' => 'Employer not found for authenticated user'], 404);
        }

        $validatedJob = $request->validate([
            'job_title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
            'job_full_disc' => 'required|string',
            'workplace' => 'required|in:onsite, hybrid, remote'
        ]);

        $validatedJob['employer_id'] = $employer->employer_id;

        $job = Job::create($validatedJob);
        return response()->json($job, 201);
    }

    function update(Request $request,$job_id)
    {
        $job = Job::findOrFail($job_id);
        $job->update(
            $request->only('job_title','description','location','salary','job_type','availability', 'workplace')
        );

    }

    function show($job_id){
        $job = Job::findOrFail($job_id);
        return response()->json($job,200);
    }

    function destroy($job_id){
        $job = Job::findOrFail($job_id);
        $job->delete();
        return response()->json(null,204);
    }
    //aprar search
    public function search(Request $request)
    {
        $item = $request->input('query');//to take the value from front end
        $results = DB::table('jobs')
            ->join('employers', 'jobs.employer_id', '=', 'employers.employer_id')
            ->select(
                'jobs.job_id',
                'jobs.job_title',
                'jobs.salary',
                'jobs.location',
                'jobs.job_type',
                'jobs.description',
                'employers.company_name',
                'employers.logo_url',
            )
            ->where('jobs.job_title', 'like', "%$item%")
            ->orWhere('jobs.location', 'like', "%$item%")
            ->orWhere('jobs.job_type', 'like', "%$item%")
            ->orWhere('employers.company_name', 'like', "%$item%")
            ->orWhere('jobs.description', 'like', "%$item%")
            ->get();
        if($results->all()==[]){
            return response()->json("there is no job with this data",404);
        }
        return response()->json($results,200);
    }

    //get all jobs with selected data
    public function getAllJobs(){
        $job=DB::table('jobs')
            ->join('employers', 'jobs.employer_id', '=', 'employers.employer_id')
            ->select(
                'jobs.job_id',
                'jobs.job_title',
                'jobs.location',
                'jobs.job_type',
                'jobs.description',
                'jobs.job_full_disc',
                'employers.company_name',
                'employers.logo_url',
                'availability',
            )->get();

        if($job->isEmpty()){
            return response()->json("there is no jobs to get",404);
        }
        return response()->json($job,200);
    }

    public function getJobByID($job_id){

        $job=DB::table('jobs')
            ->join('employers', 'jobs.employer_id', '=', 'employers.employer_id')
            ->select(
                'jobs.job_id',
                'jobs.job_title',
                'jobs.location',
                'jobs.job_type',
                'jobs.description',
                'jobs.job_full_disc',
                'employers.company_name',
                'employers.logo_url'
            )->where('jobs.job_id',$job_id)
            ->first();
        //اخلي الاجوب تصير عبارة عن اراي
        $job = (array) $job;

        //ما زبط اظهر الديتيلز غير بهاي الطريقة
        if (isset($job['job_full_disc'])) {
            $job['job_full_disc'] = json_decode($job['job_full_disc'], true);
        }
        if(!$job){
            return response()->json("there is no jobs to get",404);
        }
        return response()->json($job,200);
    }
    //end
}
