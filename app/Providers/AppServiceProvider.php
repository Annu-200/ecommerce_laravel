<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // Paginator::useBootstrapFour();
        Gate::define('isValidUser', function($user){
            return Auth::check();
        });
         view()->composer("pages.main" , function($view){
            //Subcategory
            $subcategories = Category::with('SubCategory')->take(2)->get();

             $cart = session()->get('cart', []);
             $cartCount = 0;
             
             foreach($cart as $item){
                $cartCount += $item['quantity'];
             }
              $view->with([
                'subcategories'=> $subcategories,
                'cartCount' => $cartCount
                ]);
        });
        
    }
}

