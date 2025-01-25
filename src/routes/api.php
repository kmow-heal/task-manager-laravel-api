<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::post('/register', [RegisterController::class, 'register']);


Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('tasks', TaskController::class);
});