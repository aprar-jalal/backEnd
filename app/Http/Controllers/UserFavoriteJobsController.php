<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavoriteJobsController extends Controller
{
    //start abrar jalal
    public function store(Request $request,$userId): \Illuminate\Http\JsonResponse
    {
      $user= User::findOrFail($userId);
      $user->favoriteJob()->syncWithoutDetaching([$request->job_id]);
      return response()->json(['job is added to favorite list'],200);
    }

    //or

    public function store1($JobId): \Illuminate\Http\JsonResponse
    {
        Job::findOrFail($JobId);
        Auth::user()->favoriteJob()->syncWithoutDetaching([$JobId]);
        return response()->json(['job is added to favorite list'],200);
    }

    public function destroy (Request $request,$userId): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($userId);
        $user->favoriteJob()->detach([$request->job_id]);
        return response()->json(['job is removed From Favorite'],204);
    }

    //or
    public function destroy1 ($JobId): \Illuminate\Http\JsonResponse
    {
        Job::findOrFail($JobId);
        Auth::user()->favoriteJob()->detach([$JobId]);
        return response()->json(['job is removed From Favorite'],204);
    }
    //end
}
