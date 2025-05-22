<?php


use App\Http\Controllers\UserController;
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

Route::post('/login', [UserController::class, 'manualLogin']);
Route::get('/check-auth', [UserController::class, 'checkout']);
Route::get('/current-user', [UserController::class, 'currentUser']);
Route::post('/logout', [UserController::class, 'logout']);

