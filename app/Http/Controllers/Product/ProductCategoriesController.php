<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoriesController extends ApiController
{
    public function index(Product $product)
    {   
        $categories = $product->categories;
        return $this->showAll($categories);
    }


    public function update(Request $request, Product $product, Category $category) {

    	// to insert in pivot tables we use attach or sync or ( syncWothoutDetach )

    	// attach category with a product
    	$product->categories()->syncWithoutDetaching([$category->id]);
    	return $this->showAll($product->categories);

    }


    public function destroy(Product $product, Category $category) {

    	if(! $product->categories()->find($category->id)) {
    		return $this->errorResponse("This Product does not have this category" ,404);
    	}

    	$product->categories()->detach($category->id);
    	return $this->showAll($product->categories);
    }

}

