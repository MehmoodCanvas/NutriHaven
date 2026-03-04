<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\Workout_Routine_Controller;
use App\Http\Controllers\Api\RepetitionController;
use App\Http\Controllers\Api\Exercise_Muscle_Controller;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\User_Workout_Controller;
use App\Http\Controllers\Api\Tag;
use App\Http\Controllers\Api\MasterExerciseController;
use App\Http\Controllers\Api\ExerciseGroupController;
use App\Http\Controllers\Api\ExerciseLogController;



Route::fallback(function(){
    return response()->json([
        'status' => false,
        'message' => 'API route not found.',
    ], 404);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(
    function () {

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
        Route::post('/post-exercise', [ExerciseController::class, 'store_exercise']);
        Route::post('/user-workout', [User_Workout_Controller::class, 'store_user_workout']);
        Route::post('/post-tag', [Tag::class, 'store_tag']);

        // Master Data Routes
        Route::get('/master-exercise', [MasterExerciseController::class, 'index']);
        Route::get('/muscle-group', [MasterExerciseController::class, 'muscleGroups']);

        // Exercise Group & Logs
        Route::prefix('exercise-groups')->group(function () {
            Route::get('/list', [ExerciseGroupController::class, 'index']);
            Route::post('/create', [ExerciseGroupController::class, 'store']);
            Route::get('/{id}', [ExerciseGroupController::class, 'show']);
            Route::post('/update/{id}', [ExerciseGroupController::class, 'update']);
            Route::post('/delete/{id}', [ExerciseGroupController::class, 'destroy']);
            Route::post('/remove-exercise/{id}', [ExerciseGroupController::class, 'removeExercise']);
            Route::post('/toggle-save/{id}', [ExerciseGroupController::class, 'toggleSave']);
            Route::post('/duplicate/{id}', [ExerciseGroupController::class, 'duplicate']);
        });
        
        Route::prefix('exercise-logs')->group(function () {
            Route::get('/', [ExerciseLogController::class, 'index']);
            Route::post('/start', [ExerciseLogController::class, 'start']);
            Route::post('/end', [ExerciseLogController::class, 'end']);
        });
    }
);


