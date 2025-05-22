<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApplicationJobController extends Controller
{
    //start abrar jalal
    public function store(Request $request,$userId): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($userId);
        $user->AppliedJobs()->syncWithoutDetaching([$request->JobId=> ['applicationStatus' => true]]);
        return response()->json([
            'job_id' =>$request->JobId
        ]);

    }

    //or

    public function store1($JobId): \Illuminate\Http\JsonResponse
    {
       Job::findOrFail($JobId);
        Auth::user()->AppliedJobs()->syncWithoutDetaching([$JobId=> ['applicationStatus' => true]]);
        return response()->json([
            'job_id' =>$JobId
        ]);

    }


    //end
}
