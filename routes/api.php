<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:member')->group(function () {
    Route::get('/exercises/{id}', [ExerciseController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/videos', [DataController::class, 'workout_videos']);
