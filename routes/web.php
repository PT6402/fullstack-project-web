<?php

use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\ColorAdminController;
use App\Http\Controllers\CouponAdminController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\SizeAdminController;
use App\Http\Controllers\SubAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/reset-password-confirmation', function () {
    return view('reset-password-confirmation');
})->name('reset-password-confirmation');
Route::get('/', function () {
    return view('layout.layout');
});

Route::prefix('category')->group(function (){
    Route::get('/index', [CategoryAdminController::class, 'index']);
    Route::get('/create', [CategoryAdminController::class, 'create']);
    Route::post('/postCreate', [CategoryAdminController::class, 'postCreate']);
    Route::get('/edit/{id}', [CategoryAdminController::class, 'edit']);
    Route::post('/postEdit', [CategoryAdminController::class, 'postEdit']);
    Route::get('/delete/{id}', [CategoryAdminController::class, 'delete']);
    Route::get('/view/{id}', [CategoryAdminController::class, 'view']);
});

Route::prefix('subcategory')->group(function (){
    Route::get('/index',[SubAdminController::class,'index']);
    Route::get('/create', [SubAdminController::class,'create']);
    Route::post('/postCreate',[SubAdminController::class,'postCreate']);
    Route::get('/edit/{id}', [SubAdminController::class,'edit']);
    Route::post('/postEdit',[SubAdminController::class,'postEdit']);
    Route::get('/delete/{id}', [SubAdminController::class,'delete']);
    Route::get('/view/{id}', [SubAdminController::class,'view']);
});
Route::prefix('coupon')->group(function (){
    Route::get('/index',[CouponAdminController::class,'index']);
    Route::get('/create', [CouponAdminController::class,'index']);
    Route::post('/postCreate',[CouponAdminController::class,'postCreate']);
    Route::get('/edit/{id}', [CouponAdminController::class,'edit']);
    Route::post('/postEdit',[CouponAdminController::class,'postEdit']);
    Route::get('/delete/{id}', [CouponAdminController::class,'delete']);
    Route::get('/view/{id}', [CouponAdminController::class,'view']);
});
Route::prefix('order')->group(function (){
    Route::get('/index',[OrderAdminController::class,'index']);
    Route::get('/create', [OrderAdminController::class,'create']);
    Route::post('/postCreate',[OrderAdminController::class,'postCreate']);
    Route::get('/edit/{id}', [OrderAdminController::class,'edit']);
    Route::post('/postEdit',[OrderAdminController::class,'postEdit']);
    Route::get('/delete/{id}', [OrderAdminController::class,'delete']);
    Route::get('/view/{id}', [OrderAdminController::class,'view']);
});
Route::prefix('product')->group(function (){
    Route::get('/index',[ProductAdminController::class,'index']);
    Route::get('/create', [ProductAdminController::class,'add_product_index']);
    Route::post('/postCreate',[ProductAdminController::class,'add_product']);
    Route::get('/edit-product/{id}', [ProductAdminController::class,'edit_product']);
    Route::post('/update-product/{id}', [ProductAdminController::class,'update_product']);
    // Route::post('/postEdit',[ProductAdminController::class,'postEdit']);
    Route::get('/delete/{id}', [ProductAdminController::class,'delete_product']);
    Route::get('/view/{id}', [ProductAdminController::class,'view']);
});
Route::prefix('color')->group(function (){
    Route::get('/index',[ColorAdminController::class,'index']);
    Route::get('/create', [ColorAdminController::class,'create']);
    Route::post('/postCreate',[ColorAdminController::class,'postCreate']);
    Route::get('/edit/{id}', [ColorAdminController::class,'edit']);
    Route::post('/postEdit',[ColorAdminController::class,'postEdit']);
    Route::get('/delete/{id}', [ColorAdminController::class,'delete']);
    Route::get('/view/{id}', [ColorAdminController::class,'view']);
});
Route::prefix('size')->group(function (){
    Route::get('/index',[SizeAdminController::class,'index']);
    Route::get('/create', [SizeAdminController::class,'create']);
    Route::post('/postCreate',[SizeAdminController::class,'postCreate']);
    Route::get('/edit/{id}', [SizeAdminController::class,'edit']);
    Route::post('/postEdit',[SizeAdminController::class,'postEdit']);
    Route::get('/delete/{id}', [SizeAdminController::class,'delete']);
    Route::get('/view/{id}', [SizeAdminController::class,'view']);
});

// Inventory
// Route::prefix('inventory')->group(function (){
    Route::get('inventory/index',[InventoryController::class,'index']);
//     Route::get('/create', [SizeAdminController::class,'create']);
//     Route::post('/postCreate',[SizeAdminController::class,'postCreate']);
//     Route::get('/edit/{id}', [SizeAdminController::class,'edit']);
//     Route::post('/postEdit',[SizeAdminController::class,'postEdit']);
//     Route::get('/delete/{id}', [SizeAdminController::class,'delete']);
//     Route::get('/view/{id}', [SizeAdminController::class,'view']);
// });
