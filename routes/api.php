<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/admin/users', [\App\Http\Controllers\Api\V1\AdminController::class, 'users']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/categories', [\App\Http\Controllers\Api\V1\CategoryController::class, 'index']);
        Route::post('/categories', [\App\Http\Controllers\Api\V1\CategoryController::class, 'store']);

        Route::get('/products', [\App\Http\Controllers\Api\V1\ProductController::class, 'index']);
        Route::post('/products', [\App\Http\Controllers\Api\V1\ProductController::class, 'store']);

        Route::post('/inventory/stock', [\App\Http\Controllers\Api\V1\InventoryController::class, 'updateStock']);
        Route::post('/cart/items', [\App\Http\Controllers\Api\V1\CartController::class, 'addItem']);
        Route::post('/orders', [\App\Http\Controllers\Api\V1\OrderController::class, 'store']);
        Route::post('/payments', [\App\Http\Controllers\Api\V1\PaymentController::class, 'store']);
        Route::post('/reviews', [\App\Http\Controllers\Api\V1\ReviewController::class, 'store']);
        Route::post('/coupons', [\App\Http\Controllers\Api\V1\CouponController::class, 'store']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
