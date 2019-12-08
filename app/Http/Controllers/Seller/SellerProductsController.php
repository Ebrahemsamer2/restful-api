<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\Product;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Facades\Storage;

class SellerProductsController extends ApiController
{
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    public function store(Request $request, User $seller) {

        $rules = [
    		'name' => 'required',
    		'description' => 'required',
    		'image' => 'required|image',
    		'quantity'	=> 'required|integer|min:1',
    	];

    	$this->validate($request, $rules);

    	$data = $request->all();

    	$data['status'] = Product::PRODUCT_UNAVAILABLE;
    	$data['seller_id'] = $seller->id;

        // storing image in the server store('path', 'foldername(images)')

        $data['image'] = $request->image->store('');

    	$product = Product::create($data);
    	return $this->showOne($product);
    }


    public function update(Request $request, Seller $seller, Product $product) {

    	$rules = [
    		'quantity' => 'integer|min:1',
    		'status'	=> 'in: ' . Product::PRODUCT_AVAILABLE . ', ' . Product::PRODUCT_UNAVAILABLE
    	];

    	$this->validate($request, $rules);
    	$this->checkSeller($seller, $product);

    	$product->fill($request->intersect([
    		'name',
    		'description',
    		'quantity'
    	]));

    	if($request->has('status')) {
    		$product->status = $request->status;

    		if($product->isAvailable() && $product->categories()->count() == 0) {
    			return $this->errorResponse("Product must have at least one Category", 409);
    		}
    	}

        if($request->has('image')) {
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }

    	if($product->isClean()) {
    		return $this->errorResponse("Nothing changed", 409); 
    	}

    	$product->save();
    	return $this->showOne($product);

    }


    public function destroy(Seller $seller, Product $product) {
    	$this->checkSeller($seller, $product);
        
        // you can use unlink()
        Storage::delete($product->image);

    	$product->delete();
    	return $this->showOne($product);
    }


    // check if the seller already has this product before edit it 
    public function checkSeller(Seller $seller, Product $product) {
    	if($seller->id != $product->seller_id) {
    		throw new HttpException(422, "This Product is not related to this Seller");
    	}
    }
}
