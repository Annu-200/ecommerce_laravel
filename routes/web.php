<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserToken;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;

//home route
Route::view('/', 'welcome')->name('home');

// login and registration route

Route::view('/login', 'pages.login')->name('login');
Route::view('/register', 'pages.register')->name('register');

// dashboard routing
Route::view('/dashboard','Dashboards.index')
->name('admin-dashboard');
Route::view('/user','Dashboards.page.user-display')->name('users');

//category route
Route::get('category', [CategoryController::class, 'index'])->name('category');
