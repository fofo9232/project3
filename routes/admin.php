<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//frontend section//



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

 //admin dashbord//
Route::group(['prefix'=>'admin','middleware'=>'auth'], function(){

    Route::get('/', [AdminController::class,'admin'])->name('admin');

 //banner section
 
 Route::get('banner',[App\Http\Controllers\Admin\BannerController::class, 'index'])->name('banner.index');
 Route::get('create',[BannerController::class, 'create'])->name('banner.create');
 Route::post('store',[BannerController::class, 'store'])->name('banner.store');
 Route::get('edit/{id}',[BannerController::class, 'edit'])->name('banner.edit');
 Route::post('update/{id}',[BannerController::class, 'update'])->name('banner.update');
 Route::get('destroy/{id}',[BannerController::class, 'destroy'])->name('banner.destroy');

 //category section

 Route::resource('/category','App\Http\Controllers\Admin\CategoryController');

 //brand section

 Route::resource('/brand','App\Http\Controllers\Admin\BrandController');

//product section

Route::resource('/product','App\Http\Controllers\Admin\ProductController');

//product section

Route::resource('/users','App\Http\Controllers\Admin\UserController');



});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
