<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('signUp',[UserController::class, 'signUp']);
Route::post('logIn',[UserController::class, 'logIn']);
Route::middleware('auth:sanctum')->post('/logOut', [UserController::class, 'logOut']);
