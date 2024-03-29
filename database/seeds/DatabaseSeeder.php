<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Category;
use App\Product;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // do not work with foriegn keys
    	DB::statement('set FOREIGN_KEY_CHECKS = 0');

    	// truncate reset the table 
    	User::truncate();
    	Category::truncate();
    	Product::truncate();
    	Transaction::truncate();

    	// do not have a model
    	DB::table('category_product')->truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

    	$userQuantity = 1000;
    	$categoriesQuantity = 50;
    	$productsQuantity = 1000;
    	$transactionQuantity = 1000;

    	// run the factories
    	factory(User::class, $userQuantity)->create();
    	factory(Category::class, $categoriesQuantity)->create();

    	// attach every product with a category
    	factory(Product::class, $productsQuantity)->create()->each(function($product) {

    		$categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
    		$product->categories()->attach($categories);
    	
    	});
    	
    	factory(Transaction::class, $transactionQuantity)->create();

    }
}
