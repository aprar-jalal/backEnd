<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavoriteJobsController extends Controller
{
    //start abrar jalal
    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,job_id'
        ]);
        $user=Auth::user();
      $user->favoriteJobs()->syncWithoutDetaching([$request->job_id]);
      return response()->json(['job is added to favorite list'],200);
    }

    public function destroy (Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,job_id'
        ]);
        $user = Auth::user();
        $user->favoriteJobs()->detach([$request->job_id]);
        return response()->json(['job is removed From Favorite'],200);
    }

    public function index()
    {
        /** @var \App\Models\User|null $user**/
        $user = Auth::user();
        $favoriteJobs = $user->favoriteJobs;
     return response()->json($favoriteJobs);
    }

    //end
}
