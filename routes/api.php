<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




//-----------------------------------------[USER]---------------------------------------

Route::post('register', [AuthController::class, 'register']);
Route::post('forgetPassword', [AuthController::class, 'forgetPassword']);
Route::post('mailResetPassword', [AuthController::class, 'mailResetPassword']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('currentLogin', [AuthController::class, 'currentLogin']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('add-to-cart', [CartController::class, 'addToCart']);
    Route::post('check-out', [OrderController::class, 'placeOrder']);
    Route::post('resetPassword', [AuthController::class, 'resetPassword']);
    Route::get('refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
});

//------------------------------------------[ADMIN]---------------------------------------------------
Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('checkingAuthenticated', function () {
        return response()->json([
            'message' => 'You are in', 'status' => 200
        ], 200);
    });
//Category
Route::get('view-categories', [CategoryController::class, 'index']);
Route::post('store-categories', [CategoryController::class, 'store']);
Route::get('edit-categories/{id}', [CategoryController::class, 'edit']);
Route::post('update-categories', [CategoryController::class, 'update']);
Route::get('delete-categories/{id}', [CategoryController::class, 'delete']);
Route::get('categories/{categoryId}/subcategories', [CategoryController::class, 'subcategories']);
//SubCategory
Route::get('view-subcategories', [SubcategoryController::class, 'index']);
Route::post('store-subcategories', [SubCategoryController::class, 'store']);
Route::get('edit-subcategories/{id}', [SubCategoryController::class, 'edit']);
Route::post('update-subcategories', [SubCategoryController::class, 'update']);
Route::get('delete-subcategories/{id}', [SubCategoryController::class, 'delete']);
//color
Route::get('view-color', [ColorController::class, 'index']);
Route::post('store-color', [ColorController::class, 'store']);
Route::get('edit-color/{id}', [ColorController::class, 'edit']);
Route::post('update-color', [ColorController::class, 'update']);
Route::get('delete-color/{id}', [ColorController::class, 'delete']);
//size
Route::get('view-size', [SizeController::class, 'index']);
Route::post('store-size', [SizeController::class, 'store']);
Route::get('edit-size/{id}', [SizeController::class, 'edit']);
Route::post('update-size', [SizeController::class, 'update']);
Route::get('delete-size/{id}', [SizeController::class, 'delete']);
//Product
Route::get('view-products', [ProductController::class, 'index']);
Route::post('add-products', [ProductController::class, 'store']);
Route::get('edit-products/{id}', [ProductController::class, 'edit']);
Route::post('update-products', [ProductController::class, 'update']);
Route::get('showAll', [ProductController::class, 'showAll']);
Route::get('color-size/{id}', [ProductController::class, 'getColorSizes']);
//image
Route::post('upload-image', [ProductImageController::class, 'imageStore']);
Route::post('update-image', [ProductImageController::class, 'updateImage']);
Route::get('view-image/{id}', [ProductImageController::class, 'indexImages']);


});
