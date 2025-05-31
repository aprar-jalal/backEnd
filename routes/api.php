<?php



use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserApplicationJobController;
use App\Http\Controllers\UserFavoriteJobsController;
use App\Models\UserApplicationJob;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin', [UserController::class, 'adminOnly']);
    Route::get('/jobseeker', [UserController::class, 'jobSeekerOnly']);
    Route::get('/employer', [UserController::class, 'employerOnly']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//aprar
Route::post('user/{user_id}/Favorite',[UserFavoriteJobsController::class,'store']);
Route::delete('user/{user_id}/Favorite',[UserFavoriteJobsController::class,'destroy']);
Route::get('user/{user_id}',[UserFavoriteJobsController::class,'index']);

Route::post('user/applied',[UserApplicationJobController::class,'store']);

Route::get('/allJobs',[JobController::class,'getAllJobs']);

Route::get('/search', [JobController::class, 'search']);
Route::get('/jobDetails/{job_id}', [JobController::class, 'getJobByID']);

//end
Route::post('/login', [UserController::class, 'manualLogin']);
Route::get('/check-auth', [UserController::class, 'checkout']);
Route::get('/current-user', [UserController::class, 'currentUser']);
Route::post('/logout', [UserController::class, 'logout']);





Route::post('signUp',[UserController::class, 'signUp']);
Route::post('logIn',[UserController::class, 'logIn']);
Route::middleware('auth:sanctum')->post('/logOut', [UserController::class, 'logOut']);
Route::post('forgotPassword', [UserController::class, 'forgotPassword']);
Route::post('reset-password', [UserController::class, 'reset']);

/*
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jobseeker/profile', [JobSeekerController::class, 'getMyProfile']);
    Route::post('/jobseeker/profile', [JobSeekerController::class, 'updateProfile']);
    Route::get('/jobseeker/applied-jobs', [JobSeekerController::class, 'getAppliedJobs']);
    Route::get('/jobseeker/favorite-jobs', [JobSeekerController::class, 'getFavoriteJobs']);
    Route::post('/jobseeker/upload-resume', [JobSeekerController::class, 'uploadResume']);
    Route::post('/jobseeker/upload-profile-picture', [JobSeekerController::class, 'uploadProfilePicture']);
    Route::post('/jobseeker/upload-background-picture', [JobSeekerController::class, 'uploadBackgroundPicture']);
    Route::post('/jobseeker/change-password', [JobSeekerController::class, 'changePassword']);
});

*/

Route::get('/test/jobseeker/profile/{user_id}', [JobSeekerController::class, 'getMyProfile']);
Route::put('/test/jobseeker/profile/{user_id}', [JobSeekerController::class, 'updateProfile']);
Route::get('/test/jobseeker/applied-jobs/{user_id}', [JobSeekerController::class, 'getAppliedJobs']);
Route::get('/test/jobseeker/favorite-jobs/{user_id}', [JobSeekerController::class, 'getFavoriteJobs']);
Route::post('/test/jobseeker/upload-resume/{user_id}', [JobSeekerController::class, 'uploadResume']);
Route::post('/test/jobseeker/upload-profile-picture/{user_id}', [JobSeekerController::class, 'uploadProfilePicture']);
Route::post('/test/jobseeker/upload-background-picture/{user_id}', [JobSeekerController::class, 'uploadBackgroundPicture']);
Route::post('/test/jobseeker/change-password/{user_id}', [JobSeekerController::class, 'changePassword']);



Route::get('/notifications/{id}',[NotificationController::class,'byUserId']);
Route::post('/notifications', [NotificationController::class, 'store']);
Route::get('/notifications/{userId}','App\Models\NotificationController@index');

