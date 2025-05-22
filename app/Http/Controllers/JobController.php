<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

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
}
