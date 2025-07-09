<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\Workout_Routine_Controller;
use App\Http\Controllers\Api\RepetitionController;
use App\Http\Controllers\Api\Exercise_Muscle_Controller;
use App\Http\Controllers\Api\Exercise_Controller;
use App\Http\Controllers\Api\User_Workout_Controller;
use App\Http\Controllers\Api\Tag;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/exercises/{id}', [ExerciseController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return response()->json(['user' => $request->user()]);
    });

    Route::get('/videos', [DataController::class, 'workout_videos']);
    Route::get('/category', [DataController::class, 'category']);
    Route::get('/muscle', [DataController::class, 'muscle']);
    Route::get('/nutriheaven-exercise', [DataController::class, 'nutriheaven_exercise']);


    Route::post('/post-workout-routine', [Workout_Routine_Controller::class, 'store_routine']);
    Route::post('/post-repetition', [RepetitionController::class, 'store_repetition']);
    Route::post('/post-exercise-muscle', [Exercise_Muscle_Controller::class, 'store_exercise_muscle']);
    Route::post('/post-exercise', [Exercise_Controller::class, 'store_exercise']);
    Route::post('/user-workout', [User_Workout_Controller::class, 'store_user_workout']);
    Route::post('/post-tag', [Tag::class, 'store_tag']);
}
);


