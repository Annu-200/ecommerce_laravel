<?php

use App\Http\Controllers\ColorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\SubCategoryController;
use App\Http\Controllers\Dashboard\ProductVarientController;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//  Authentication and Authorization

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/registerUser', [AuthController::class, 'registerUser'])->name('registerUser');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

// dashboard  redirection
Route::get('/dashboard', [AuthController::class, 'dashboard'])
->name('dashboard')->middleware('auth:sanctum');
Route::get('/LoginUserDetails', [AuthController::class, 'LoginUserDetails'])
->name('LoginUserDetails')->middleware('auth:sanctum');
// user display
Route::get('/user', [AuthController::class, 'selectUsers'])->name('user');


// category --- 
Route::apiResource('/category', CategoryController::class)->middleware("auth:sanctum");
Route::get('/AllCategory',[ CategoryController::class, 'AllCategory'])->middleware("auth:sanctum");
//sub category
Route::apiResource('subcategory', SubCategoryController::class)->middleware("auth:sanctum");

// brand
Route::apiResource('brand', BrandController::class)->middleware('auth:sanctum');
Route::get('showBrand',[ BrandController::class, 'showBrand'])->middleware('auth:sanctum')->name('showBrand');

// product
Route::apiResource('product', ProductController::class)->middleware('auth:sanctum');
Route::get('/product-category', [ProductController::class, 'showCategory'])->name('product-category');
// Route::get('/product-brand', [ProductController::class, 'showBrand'])->name('product-brand');
// Product-Varients
Route::apiResource('product-varient', ProductVarientController::class)->middleware('auth:sanctum');
Route::get('product-size', [ProductVarientController::class, 'showSize'])->name('product-size')->middleware('auth:sanctum');
Route::get('productDisplay', [ProductVarientController::class, 'productDisplay'])->name('productDisplay')->middleware('auth:sanctum');
Route::resource('colors', ColorController::class)->middleware('auth:sanctum');
Route::get('product-color', [ProductVarientController::class, 'showColor'])->name('product-color')->middleware('auth:sanctum');

Route::post('/update-order/{id}', [OrderController::class, 'OrderAdminUpdate'])->name('update-order')->middleware('auth:sanctum');
Route::get('/update-order-status/{id}', [OrderController::class, 'OrderAdminEdit'])->name('update-order-status')->middleware('auth:sanctum');
Route::get('/orderDelete/{id}', [OrderController::class, 'orderDestroy'])->name('orderDelete')->middleware('auth:sanctum');
