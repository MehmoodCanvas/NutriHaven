<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\VideosController;
use App\Http\Controllers\Admin\Exercise;
use App\Http\Controllers\Admin\MuscleController;
use App\Http\Controllers\Admin\MuscleGroupController;
use App\Http\Controllers\Admin\AdminEquipmentController;
use App\Http\Controllers\Admin\AdminAuxEquipmentController;
use App\Http\Controllers\Admin\AdminMasterExerciseController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProfileController;



Route::post('/auth',[Login::class,'authenticate']);
Route::get('/logout',function(){
    session()->flush();
    return redirect('/');
});
Route::get('/', function(){
    return redirect('admin/login');
});
Route::get('/login', function(){
    return redirect('admin/login');
})->name('login');

Route::get('/admin/login',function(){
    return view('admin.login');
})->name('admin/login');

Route::get('/admin',function(){
    return redirect('admin/dashboard');
});


Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index']);
    Route::get('/videos', [Dashboard::class, 'videos']);
    Route::get('/categories', [Dashboard::class, 'categories']);
    Route::get('/exercise', [Dashboard::class, 'exercise']);
    Route::get('/muscle', [Dashboard::class, 'muscle']);
    Route::get('/category', [Dashboard::class, 'category']);

    
    // Categories CRUD
    Route::post('/categories/store', [VideosController::class, 'store_category']);
    Route::get('/categories/{id}/edit', [VideosController::class, 'edit_category']);
    Route::post('/categories/{id}/update', [VideosController::class, 'update_category']);
    Route::post('/categories/{id}/delete', [VideosController::class, 'delete_category']);

    // Videos CRUD
    Route::post('/videos/store', [VideosController::class, 'add_workout_video']);
    Route::get('/videos/{id}/edit', [VideosController::class, 'edit_video']);
    Route::post('/videos/{id}/update', [VideosController::class, 'update_video']);
    Route::post('/videos/{id}/delete', [VideosController::class, 'delete_video']);

    // Legacy POST routes
    Route::post('post-exercise/',[Exercise::class,'store_exercise'])->name('post-exercise');
    Route::post('post-muscle/',[MuscleController::class,'store_muscle'])->name('post-muscle');
    //AMDIN POST END

    // Muscle Groups CRUD
    Route::get('/muscle-groups', [MuscleGroupController::class, 'index']);
    Route::post('/muscle-groups/store', [MuscleGroupController::class, 'store']);
    Route::get('/muscle-groups/{id}/edit', [MuscleGroupController::class, 'edit']);
    Route::post('/muscle-groups/{id}/update', [MuscleGroupController::class, 'update']);
    Route::post('/muscle-groups/{id}/delete', [MuscleGroupController::class, 'destroy']);

    // Equipment CRUD
    Route::get('/equipments', [AdminEquipmentController::class, 'index']);
    Route::post('/equipments/store', [AdminEquipmentController::class, 'store']);
    Route::post('/equipments/{id}/update', [AdminEquipmentController::class, 'update']);
    Route::post('/equipments/{id}/delete', [AdminEquipmentController::class, 'destroy']);

    // Aux Equipment CRUD
    Route::get('/aux-equipments', [AdminAuxEquipmentController::class, 'index']);
    Route::post('/aux-equipments/store', [AdminAuxEquipmentController::class, 'store']);
    Route::post('/aux-equipments/{id}/update', [AdminAuxEquipmentController::class, 'update']);
    Route::post('/aux-equipments/{id}/delete', [AdminAuxEquipmentController::class, 'destroy']);

    // Master Exercises CRUD
    Route::get('/master-exercises', [AdminMasterExerciseController::class, 'index']);
    Route::post('/master-exercises/store', [AdminMasterExerciseController::class, 'store']);
    Route::get('/master-exercises/{id}/edit', [AdminMasterExerciseController::class, 'edit']);
    Route::post('/master-exercises/{id}/update', [AdminMasterExerciseController::class, 'update']);
    Route::post('/master-exercises/{id}/delete', [AdminMasterExerciseController::class, 'destroy']);

    // Users (Members) Management
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit']);
    Route::post('/users/{id}/update', [AdminUserController::class, 'update']);
    Route::post('/users/{id}/delete', [AdminUserController::class, 'destroy']);

    // Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'index']);
    Route::post('/profile/update', [AdminProfileController::class, 'update']);
    Route::post('/profile/update-password', [AdminProfileController::class, 'updatePassword']);

});
