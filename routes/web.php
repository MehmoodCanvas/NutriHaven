<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\VideosController;
use App\Http\Controllers\Admin\Exercise;
use App\Http\Controllers\Admin\MuscleController;






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

    
    //POST METHOD
    Route::post('post-video',[VideosController::class,'add_workout_video']);
    Route::post('post-category/',[VideosController::class,'store_category']);
    Route::post('post-exercise/',[Exercise::class,'store_exercise'])->name('post-exercise');
    Route::post('post-muscle/',[MuscleController::class,'store_muscle'])->name('post-muscle');
    //AMDIN POST END 

});
