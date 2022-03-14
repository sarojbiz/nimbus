<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cart;
use App\Category;
use App\Helpers\MenuHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
        if( request()->getHttpHost() != "localhost" ){
            $this->app->bind('path.public', function() {
                return base_path().'/../html';
            });
        }
        */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'layouts.master',
            function ($view) {
                $view->with([
                            'wishlistTotalQty' => app('wishlist')->getTotalQuantity(),         
                            'cartCollection' => Cart::getContent(),         
                            'cartTotalQuantity' => Cart::getTotalQuantity(),
                            'cartTotal' => Cart::getTotal(),
                            'categories' => MenuHelper::getMenu()
                            ]);
            }
        );
    }
}
