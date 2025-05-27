<?php


use App\Http\Controllers\JobController;
use App\Http\Controllers\UserApplicationJobController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFavoriteJobsController;
use App\Models\UserApplicationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//abrar
Route::post('user/{user_id}/job', [UserFavoriteJobsController::class, 'store']);
Route::delete('user/{user_id}/job',[UserFavoriteJobsController::class,'destroy']);

Route::get('/search', [JobController::class, 'search']);
Route::get('/allJobs', [JobController::class, 'getAllJobs']);

//Route::post('/application',[UserApplicationJobController::class,'store'])->middleware('auth:sanctum');

Route::post('/application',[UserApplicationJobController::class,'store']);

//end
Route::post('/login', [UserController::class, 'manualLogin']);
Route::get('/check-auth', [UserController::class, 'checkout']);
Route::get('/current-user', [UserController::class, 'currentUser']);
Route::post('/logout', [UserController::class, 'logout']);

