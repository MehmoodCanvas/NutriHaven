<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Home;










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
    Route::get('/homepage', [Dashboard::class, 'homepage']);
    Route::get('/about', [Dashboard::class, 'about']);
    Route::get('/order', [Dashboard::class, 'order']);
    Route::get('/products', [Dashboard::class, 'products']);
    Route::get('/add-product', [Dashboard::class, 'add_product']);
    Route::get('/category', [Dashboard::class, 'category']);
    Route::get('/sub-category', [Dashboard::class, 'sub_category']);
    Route::get('/add-new-category', [Dashboard::class, 'add_new_category']);
    Route::get('/add-new-sub-category', [Dashboard::class, 'add_new_sub_category']);
    Route::get('/attribute', [Dashboard::class, 'attribute']);
    Route::get('/add-attribute', [Dashboard::class, 'add_attribute']);
    Route::get('/variant', [Dashboard::class, 'variant']);
    Route::get('/add-variant', [Dashboard::class, 'add_variant']);
    Route::get('/subscribers', [Dashboard::class, 'subscribers']);
    Route::get('/orders', [Dashboard::class, 'orders']);
    Route::get('/gallery', [Dashboard::class, 'gallery']);
    Route::get('/product-edit/{id}', [Dashboard::class, 'edit_product']);
    Route::get('/category-edit/{id}', [Dashboard::class, 'edit_category']);
    Route::get('/order-detail/{id}', [Dashboard::class, 'order_view']);
    Route::get('/attribute-edit/{id}', [Dashboard::class, 'edit_attribute']);
    Route::get('/variant-edit/{id}', [Dashboard::class, 'edit_variant']);
    Route::get('/gift', [Dashboard::class, 'gift']);
    Route::get('/gallery', [Dashboard::class, 'gallery']);
    Route::get('/add-gift',[Dashboard::class,'add_gift']);
    Route::get('/edit-gift/{id}',[Dashboard::class,'edit_gift']);
    Route::get('delete-gallery/{id}',[Gallery_landing::class,'destroy']);
    Route::get('product-delete/{id}',[Catlog::class,'destroy']);
    Route::get('gift-delete/{id}',[Catlog::class,'destroy_gift']);
    Route::get('/global-setting', [Dashboard::class, 'global']);
    Route::get('/brands', [Dashboard::class, 'brand']);
    Route::get('/add-new-brand', [Dashboard::class, 'store_brand']);
    
    //POST METHOD
    Route::post('edit-homepage/{id}',[Home::class,'Store']);
    Route::post('post-gallery',[Catlog::class,'post_gallery']);
    Route::post('post-category/',[Catlog::class,'store_category']);
    Route::post('post-product/',[Catlog::class,'store_product']);
    Route::post('post-attribute/', [Catlog::class, 'store_attribute']);
    Route::post('post-variant/', [Catlog::class, 'store_variant']);
    Route::put('edit-product/{id}',[Catlog::class,'edit_product']);
    Route::put('edit-category/{id}',[Catlog::class,'edit_category']);
    Route::put('edit-attribute/{id}',[Catlog::class,'edit_attribute']);
    Route::put('edit-variant/{id}',[Catlog::class,'edit_variant']);
    Route::post('post-gift',[Catlog::class,'add_gift']);
    Route::put('update-gift/{id}',[Catlog::class,'edit_gift']);
    Route::post('post-new-video/', [Sonic::class, 'video']);
    Route::put('post-global/{id}',[Home::class,'global_setting']);
    Route::post('edit-aboutpage/{id}',[Home::class,'about_pagw']);
    Route::post('post-sub-category/',[Catlog::class,'store_sub_category']);
    Route::post('post-brand/',[Catlog::class,'store_brand']);
    
});
