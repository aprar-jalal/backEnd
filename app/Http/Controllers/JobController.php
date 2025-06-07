<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{

    function index()
    {
        $job = Job::all();
        return response()->json($job,200);
    }
    function store(Request $request)
    {
        $job = Job::create([
            'employer_id'=>$request->employer_id,
            'job_title'=>$request->job_title,
            'description'=>$request->description,
            'location'=>$request->location,
            'salary'=>$request->salary,
            'job_type'=>$request->job_type,
            'job_full_disc '=>$request->job_full_disc,
        ]);
        return response()->json($job,201);
    }

    function update(Request $request,$job_id)
    {
        $job = Job::findOrFail($job_id);
        $job->update(
            $request->only('job_title','description','location','salary','job_type','availability')
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
                'jobs.description',
                'jobs.location',
                'jobs.job_type',
                'availability',
                'jobs.job_full_disc',
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
