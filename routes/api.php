<?php

use App\Models\UserApplicationJob;
use App\Models\UserFavoriteJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('user/{user_id}/job',[UserFavoriteJobs::class,'store']);
Route::delete('user/{user_id}/job',[UserFavoriteJobs
::class,'destroy']);

Route::post('user/{user_id}/job',[UserApplicationJob::class,'store']);
