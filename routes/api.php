<?php



use App\Http\Controllers\JobController;
use App\Http\Controllers\UserFavoriteJobsController;
use App\Models\UserApplicationJob;
use App\Http\Controllers\JobSeekerController;
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
Route::post('user/{user_id}/job',[UserFavoriteJobsController::class,'store']);
Route::delete('user/{user_id}/job',[UserFavoriteJobsController::class,'destroy']);

Route::post('user/{user_id}/job',[UserApplicationJob::class,'store']);

Route::get('/allJobs',[JobController::class,'getAllJobs']);

Route::get('/search', [JobController::class, 'search']);

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
Route::get('/notifications/{userId}','App\Models\NotificationController@index');


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


