<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\SubCategoryController as UserSubCategoryController;
// use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//-----------------------------------------[USER]---------------------------------------


Route::post('register', [AuthController::class, 'register']);
Route::get('list-category', [UserCategoryController::class, 'index']);
Route::get('list-subcategory', [UserSubCategoryController::class, 'index']);
Route::get('list-product', [UserProductController::class, 'index']);
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
    Route::post('store-favorite', [FavoriteController::class, 'store']);
    Route::post('view-favorite', [FavoriteController::class, 'index']);
    Route::post('delete-favorite', [FavoriteController::class, 'delete']);
    Route::post('store-payment', [PaymentController::class, 'store']);
    Route::post('code-discount', [CartController::class, 'applyDiscount']);
    Route::post('find-review', [ReviewController::class, 'findReview']);
    Route::post('store-review', [ReviewController::class, 'review']);
    Route::post('cancel-order', [OrderController::class, 'cancelOrder']);
    Route::get('view-cartitem',[CartController::class,'indexCartitem']);
    Route::post('edit-cart',[CartController::class,'update']);
    Route::get('edit-cartitem/{id}',[CartController::class,'edit']);
    Route::post('view-cart-user',[CartController::class,'viewcart']);
    Route::post('store-address',[AddressController::class,'store']);
    Route::post('edit-address',[AddressController::class,'edit']);
    Route::post('view-address',[AddressController::class,'index']);
    Route::post('update-address',[AddressController::class,'update']);
    Route::post('delete-address',[AddressController::class,'delete']);
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
    Route::get('view-image/{id}', [ProductImageController::class, 'indexImages']);
    Route::post('image-main', [ProductImageController::class, 'Is_main']);
    Route::get('delete-image/{id}', [ProductImageController::class, 'deleteImage']);
    //discount
    Route::post('store-discount', [DiscountController::class, 'store']);
    Route::get('edit-discount/{id}', [DiscountController::class, 'edit']);
    Route::post('update-discount', [DiscountController::class, 'update']);
    Route::get('delete-discount/{id}', [DiscountController::class, 'delete']);
    Route::get('view-discount', [DiscountController::class, 'show']);
    //
    Route::post('status-orders', [OrderController::class, 'updateOrderStatus']);
    Route::get('view-cart',[CartController::class,'index']);
});
