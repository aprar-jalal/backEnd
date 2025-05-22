<?php

use App\Http\Controllers\JobSeekerController;
use App\Models\UserApplicationJob;
use App\Models\UserFavoriteJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::get('employers', [EmployerController::class, 'index']);
Route::post('employers', [EmployerController::class, 'store']);
Route::put('employers/{id}', [EmployerController::class, 'update']);
Route::get('employers/{id}', [EmployerController::class, 'show']);
Route::delete('employers/{id}', [EmployerController::class, 'destroy']);

Route::get('jobs', [JobController::class, 'index']);
Route::post('jobs', [JobController::class, 'store']);
Route::put('jobs/{id}', [JobController::class, 'update']);
Route::get('jobs/{id}', [JobController::class, 'show']);
Route::delete('jobs/{id}', [JobController::class, 'destroy']);


Route::post('user/{user_id}/job',[UserFavoriteJob::class,'store']);
Route::delete('user/{user_id}/job',[UserFavoriteJob::class,'destroy']);

Route::post('user/{user_id}/job',[UserApplicationJob::class,'store']);

Route::post('/login', [UserController::class, 'manualLogin']);
Route::get('/check-auth', [UserController::class, 'checkout']);
Route::get('/current-user', [UserController::class, 'currentUser']);
Route::post('/logout', [UserController::class, 'logout']);


Route::get('/jobseeker/profile', [JobSeekerController::class, 'getMyProfile']);
Route::put('/jobseeker/profile', [JobSeekerController::class, 'updateProfile']);
Route::get('/jobseeker/applied-jobs', [JobSeekerController::class, 'getAppliedJobs']);
Route::get('/jobseeker/favorite-jobs', [JobSeekerController::class, 'getFavoriteJobs']);
Route::post('/jobseeker/upload-resume', [JobSeekerController::class, 'uploadResume']);
Route::post('/jobseeker/upload-picture', [JobSeekerController::class, 'uploadProfilePicture']);
Route::post('/jobseeker/change-password', [JobSeekerController::class, 'changePassword']);
