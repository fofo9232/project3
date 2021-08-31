<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;


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

Route::get('/', [IndexController::class , 'home'])->name('index');


//end of frontend section//
//product category//
Route::get('product-cat/{slug}', [IndexController::class , 'productCategory'])->name('product.category');


//end product category//


