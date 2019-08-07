<?php

namespace App;

use App\Scopes\SellerScope;

class Seller extends User
{

	public static function boot() {
		parent::boot();
		static::addGlobalScope(new SellerScope);
	}

	// seller sells many products
	public function products() {
		return $this->hasMany(Product::class);
	}
}
