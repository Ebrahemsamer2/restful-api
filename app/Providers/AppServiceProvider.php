<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;

use App\Mail\usercreated;
use App\Mail\userupdated;
use App\Product;
use App\User;

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
            retry(5, function() use ($user) {
                Mail::to($user)->send(new usercreated($user));
            }, 100);
        });

        User::updated(function($user) {
            if($user->isDirty('email')) {
                retry(5, function() use ($user) {
                    Mail::to($user)->send(new userupdated($user));
                }, 100);
            }
        });
    }
}
