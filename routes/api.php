<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// 
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// JWT
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});
