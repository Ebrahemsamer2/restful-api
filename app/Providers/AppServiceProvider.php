<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Product;
use App\User;;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);
    
        Product::updated(function($product) {
            
            if($product->quantity == 0 && $product->isAvailable()) {
                $product->status = Product::PRODUCT_UNAVAILABLE;
                $product->save();
            }

        });

        // User::created(function($user) {
        //     retry(5, function () use ($user) {
        //         // Attempt 5 times while resting 100ms in between attempts...
        //         Mail::to($user)->send(new UserCreated($user));
        //     }, 100);
        // });

        // User::updated(function($user) {
        //     if($user->isDirty('email')){
        //         retry(5, function () use ($user) {
        //         // Attempt 5 times while resting 100ms in between attempts...
        //         Mail::to($user)->send(new UserCreated($user));
        //         },100);
        //     }
        // });
    }
}
