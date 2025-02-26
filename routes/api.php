<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategorySubController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');

Route::get('/test', function () {
    return response()->json(['message' => 'success']);
});

// auth start
Route::post('/signup', [AuthController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'login']);
// auth end

// Route::middleware('auth:api')->group(function () {
// category start
Route::post('/category', [CategoryController::class, 'storeCategory']);
// category end

// category sub start
Route::post('/category-sub', [CategorySubController::class, 'storeSubCategory']);
// category sub end

// product start
Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/product', [ProductController::class, 'storeProduct']);
});

Route::get('/category-subs', [CategorySubController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
});

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::post('/product', [ProductController::class, 'storeProduct']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/my-products', [ProductController::class, 'myProducts']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
});

    // product end

// });
