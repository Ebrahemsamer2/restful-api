<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;

use App\Product;
use App\User;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;

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

        User::created(function($user) {
            Mail::to($user)->send(new UserCreated($user));
        });

        User::updated(function($user) {
            if($user->isDirty('email')){
                Mail::to($user)->send(new UserMailChanged($user));
            }
        });
    }
}
