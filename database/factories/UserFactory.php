<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Seller;
use App\Category;
use App\Product;
use App\Transaction;

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'admin'	=> $faker->randomElement([User::REGULAR_USER, User::ADMIN_USER]),
        'remember_token' => Str::random(1, 10),
        'verified' => $faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        'verification_token' => User::generateVerificationCode(),
    ];
});


$factory->define(Category::class, function(Faker $faker){
	return [
		'name' => $faker->word,
		'description' => $faker->paragraph,
	];
});

$factory->define(Product::class, function(Faker $faker) {
	return [
		'name' => $faker->word,
		'description' => $faker->paragraph,
		'quantity' => $faker->numberBetween(1, 10),
		'status' => $faker->randomElement([Product::PRODUCT_AVAILABLE, Product::PRODUCT_UNAVAILABLE]),
		'image' => $faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
		'seller_id'	=> User::all()->random()->id,
	];
});

$factory->define(Transaction::class, function(Faker $faker) {

	$seller = Seller::has('products')->get()->random();
	$buyer = User::all()->except($seller->id)->random();

	return [
		'quantity' => $faker->numberBetween(1, 3),
		'product_id' => $seller->products->random()->id,
		'buyer_id'	=> $buyer->id,
	];

});