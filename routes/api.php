<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;

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
