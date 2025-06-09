<?php


use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserApplicationJobController;
use App\Http\Controllers\UserFavoriteJobsController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



Route::post('/sign-up', [UserController::class, 'signUp']);
Route::post('/log-in', [UserController::class, 'logIn']);
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/reset-password', [UserController::class, 'reset']);
Route::middleware('auth:sanctum')->post('/logOut', [UserController::class, 'logOut']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/log-out', [UserController::class, 'logOut']);
    Route::get('/admin', [UserController::class, 'adminOnly']);
    Route::get('/job-seeker', [UserController::class, 'jobSeekerOnly']);
    Route::get('/employer', [UserController::class, 'employerOnly']);
});




//aprar
Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/AddFavorite',[UserFavoriteJobsController::class,'store']);
    Route::delete('user/RemoveFavorite',[UserFavoriteJobsController::class,'destroy']);
    Route::get('user/GetFavorite',[UserFavoriteJobsController::class,'index']);

    Route::post('user/applied',[UserApplicationJobController::class,'store']);
});


Route::get('/allJobs',[JobController::class,'getAllJobs']);

Route::get('/search', [JobController::class, 'search']);
Route::get('/jobDetails/{job_id}', [JobController::class, 'getJobByID']);

//end


Route::middleware('auth:sanctum')->group(function () {
//mohammad
    Route::get('employers', [EmployerController::class, 'index']);
    Route::put('employer', [EmployerController::class, 'update']);
    Route::get('employer', [EmployerController::class, 'show']);
    Route::delete('employer', [EmployerController::class, 'destroy']);

    Route::get('/jobs', [JobController::class, 'getJobsForEmployer']);
    Route::post('jobs', [JobController::class, 'store']);
    Route::put('jobs/{id}', [JobController::class, 'update']);
    Route::get('jobs/{id}', [JobController::class, 'show']);
    Route::delete('jobs/{id}', [JobController::class, 'destroy']);

});


Route::post('/login', [UserController::class, 'manualLogin']);
Route::get('/check-auth', [UserController::class, 'checkout']);
Route::get('/current-user', [UserController::class, 'currentUser']);
Route::post('/logout', [UserController::class, 'logout']);




Route::get('/notifications/{userId}','App\Models\NotificationController@index');


// Asmar

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jobseeker/profile', [JobSeekerController::class, 'getMyProfile']);
    Route::post('/jobseeker/profile', [JobSeekerController::class, 'updateProfile']);
    Route::get('/jobseeker/applied-jobs', [JobSeekerController::class, 'getAppliedJobs']);
    Route::get('/jobseeker/favorite-jobs', [JobSeekerController::class, 'getFavoriteJobs']);
    Route::post('/jobseeker/upload-resume', [JobSeekerController::class, 'uploadResume']);
    Route::post('/jobseeker/upload-profile-picture', [JobSeekerController::class, 'uploadProfilePicture']);
    Route::post('/jobseeker/upload-background-picture', [JobSeekerController::class, 'uploadBackgroundPicture']);
    Route::post('/jobseeker/change-password', [JobSeekerController::class, 'changePassword']);
    Route::delete('/job-seeker/resume', [JobSeekerController::class, 'deleteResume']);
    Route::delete('/jobseeker/applied/{job_id}', [JobSeekerController::class, 'destroy']);
    Route::delete('/jobseeker/favorite/{job_id}', [JobSeekerController::class, 'removeFavoriteJob']);

});
// Asmar End


Route::get('/notifications/{id}',[NotificationController::class,'byUserId']);
Route::post('/notifications', [NotificationController::class, 'store']);
Route::get('/notifications/{userId}','App\Models\NotificationController@index');
