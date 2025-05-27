<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavoriteJobsController extends Controller
{
    //start abrar jalal
    public function store(Request $request,$user_id): \Illuminate\Http\JsonResponse
    {
      $user= User::findOrFail($user_id);
      $user->favoriteJob()->syncWithoutDetaching([$request->job_id]);
      return response()->json(['job is added to favorite list'],200);
    }

    public function destroy (Request $request,$user_id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($user_id);
        $user->favoriteJob()->detach([$request->job_id]);
        return response()->json(['job is removed From Favorite'],204);
    }


    //end
}
