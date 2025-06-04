<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavoriteJobsController extends Controller
{
    //start abrar jalal
    public function store(Request $request,$user_id)
    {
      $user= User::findOrFail($user_id);
      $user->favoriteJobs()->syncWithoutDetaching([$request->job_id]);
      return response()->json(['job is added to favorite list',$user_id,$request->job_id],200);
    }
//    public function store($Job_id): \Illuminate\Http\JsonResponse
//    {
//        $job= User::findOrFail($Job_id);
//        Auth::user()->favoriteJob()->syncWithoutDetaching([$Job_id]);
//        return response()->json(['job is added to favorite list'],200);
//    }

    public function destroy (Request $request,$user_id)
    {
        $user = User::findOrFail($user_id);
        $user->favoriteJobs()->detach([$request->job_id]);
        return response()->json(['job is removed From Favorite'],204);
    }

    public function index($user_id)
    {
     $user=User::with('favoriteJobs')->find($user_id);
     return response()->json($user->favoriteJobs);
    }

    //end
}
