<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\UniversalProcessController;










Route::post('/auth',[Login::class,'authenticate']);
Route::get('/logout',function(){
    session()->flush();
    return redirect('/');
});


//AMDIN POST END 
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
    Route::get('/order', [Dashboard::class, 'order']);
    Route::get('/products', [Dashboard::class, 'products']);
    Route::get('/add-product', [Dashboard::class, 'add_product']);
    Route::get('/category', [Dashboard::class, 'category']);
    Route::get('/sub-category', [Dashboard::class, 'sub_category']);
    Route::get('/add-new-category', [Dashboard::class, 'add_new_category']);
    Route::get('/add-new-sub-category', [Dashboard::class, 'add_new_sub_category']);

    
    //POST METHOD
    Route::post('post-video',[UniversalProcessController::class,'add_workout_video']);
    Route::post('post-category/',[UniversalProcessController::class,'store_category']);

    
});
