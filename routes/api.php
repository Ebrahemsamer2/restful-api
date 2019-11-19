<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Buyer Route

Route::resource('buyers', 'Buyer\buyerController', ['only' => ['index', 'show']]);

Route::resource('buyers.transactions', 'Buyer\buyerTransactionController', ['only' => ['index']]);

Route::resource('buyers.products', 'Buyer\buyerProductsController', ['only' => ['index']]);

Route::resource('buyers.sellers', 'Buyer\buyerSellersController', ['only' => ['index']]);

Route::resource('buyers.categories', 'Buyer\buyerCategoriesController', ['only' => ['index']]);


// Seller Route

Route::resource('sellers', 'Seller\sellerController', ['only' => ['index', 'show']]);

Route::resource('sellers.transactions', 'Seller\SellerTransactionsController', ['only' => ['index']]);

Route::resource('sellers.categories', 'Seller\SellerCategoriesController', ['only' => ['index']]);

Route::resource('sellers.buyers', 'Seller\SellerBuyersController', ['only' => ['index']]);

Route::resource('sellers.products', 'Seller\SellerProductsController', ['except' => ['create', 'edit','show']]);


// Transaction Route

Route::resource('transactions', 'Transaction\transactionController', ['only' => ['index', 'show']]);

Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);

Route::resource('transactions.seller', 'Transaction\TransactionSellerController', ['only' => ['index']]);


// Product Route

Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);

Route::resource('products.transactions', 'Product\ProductTransactionsController', ['only' => ['index']]);

Route::resource('products.buyers', 'Product\ProductBuyersController', ['only' => ['index']]);

Route::resource('products.categories', 'Product\ProductCategoriesController', ['only' => ['index', 'update','destroy']]);

Route::resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only' => ['store']]);


// Category Route

Route::resource('categories', 'Category\categoryController', ['except' => ['create', 'edit']]);

Route::resource('categories.products', 'Category\CategoryProductsController', ['only' => ['index']]);

Route::resource('categories.sellers', 'Category\CategorySellersController', ['only' => ['index']]);

Route::resource('categories.buyers', 'Category\CategoryBuyersController', ['only' => ['index']]);

Route::resource('categories.transactions', 'Category\CategoryTransactionsController', ['only' => ['index']]);


// User Route

Route::resource('users', 'User\userController', ['except' => ['create', 'edit']]);