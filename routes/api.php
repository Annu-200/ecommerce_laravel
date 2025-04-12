<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;

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
// user display
Route::get('/user', [AuthController::class, 'selectUsers'])->name('user');

// category --- store

Route::apiResource('/category', CategoryController::class)->middleware("auth:sanctum");