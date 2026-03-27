<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController as DashboardCategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProductVarientController;
use App\Http\Controllers\Dashboard\SubCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\paymentController;
use Razorpay\Api\Resource;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/category/{id}', [HomeController::class, 'CategoryOne'])
    ->name('CategoryOne');

Route::get('/productdetails/{id}', [HomeController::class, 'productDetails'])
    ->name('productdetails');
        
Route::get('/shop', [HomeController::class, 'shopNow'])->name('shop');
Route::get('/filter-data', [HomeController::class, 'filterProduct'])->name('filter-data');
Route::get('/filter-category', [HomeController::class, 'filterProduct'])->name('filter-category');
Route::get('/filter-color', [HomeController::class, 'filterProduct'])->name('filter-color');
Route::get('/filterproduct',[HomeController::class, 'filterProduct'])->name('filterproduct');

Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::resource('checkout', CheckoutController::class);
Route::get('/chechout', [CheckoutController::class, 'index'])->name('checkout');

Route::view('/login', 'pages.login')->name('login');
Route::view('/register', 'pages.register')->name('register'); 

Route::get('/order/{id}', [OrderController::class, 'success'])->name('order-success'); 
Route::get('/order.delete/{id}', [OrderController::class, 'orderDestroy'])->name('order.destroy');
Route::get('/order-track', [OrderController::class, 'trackOrder'])->name('order.track');
Route::post('/order-status', [OrderController::class, 'trackOrderStatus'])->name('order.status');


//category route
Route::get('category', [DashboardCategoryController::class, 'index'])->name('category');
// dashboard routing
Route::view('/dashboard','Dashboards.index')
->name('admin-dashboard');
Route::view('/user','Dashboards.page.user-display')->name('users');

//category route
Route::get('category', [DashboardCategoryController::class, 'ViewCategory'])->name('category');
Route::get('allcategory', [DashboardCategoryController::class, 'ViewCategory'])->name('allcategory');

//SubCategory route
Route::get('subcategory', [SubCategoryController::class, 'SubCategory'])->name('subcategory');
Route::get('viewSubCategory', [SubCategoryController::class, 'ViewfetchCategory'])->name('viewSubCategory');

//brand route
Route::get('brand', [BrandController::class, 'brandAdd'])->name('brand');
Route::get('allbrands', [BrandController::class, 'fetchBrand'])->name('allbrands');
// color route
Route::get('color', [ColorController::class, 'addcolor'])->name('color');
Route::get('allcolor', [ColorController::class, 'fetchColor'])->name('allcolor');

//product route
Route::get('addproduct', [ProductController::class, 'addProduct'])->name('addproduct');
Route::get('view-product', [ProductController::class , 'viewProduct'])->name('view-product');
Route::get('order-admin',[OrderController::class, 'adminOrder'])->name('order.admin');

Route::get('productDetails', [ProductVarientController::class, 'addProduct'])->name('productDetails');
Route::get('view-product-details', [ProductVarientController::class, 'viewProduct'])->name('view-product-details');

//live-search
Route::get('live-search',[ProductController::class, 'liveSearch'])->name('live-search');
// razorapay route
Route::get('razorpay-payment/{id}',[paymentController::class, 'payment'])->name('razorpay.payment');
Route::post('payment-success',[paymentController::class, 'paymentSuccess'])->name('payment.success');

