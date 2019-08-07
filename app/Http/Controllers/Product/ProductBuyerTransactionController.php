<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Facades\DB;

use App\Transaction;
use App\User;
use App\Product;

class ProductBuyerTransactionController extends ApiController
{

    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1',
        ];

        $this->validate($request, $rules);

        // check if the seller is the buyer
        if($buyer->id == $product->seller_id) {
            return $this->errorResponse("The buyer Can't be the seller", 409);
        }

        // check if both are verified
        if(! $buyer->isVerified() ) {
            return $this->errorResponse("Sorry, This Buyer is not Verified", 409)
        }

        if(! $product->seller->isVerified() ) {
            return $this->errorResponse("Sorry, This Seller is not Verified", 409)
        }
        // check if product is available
        if(! $product->isAvailable()) {
            return $this->errorResponse("Sorry, This Product is not Available", 409);
        }

        // check for the quantity
        if($product->quantity < $request->quantity) {
            return $this->errorResponse("Sorry, This Product has not enough quantity for this transaction", 409);
        }

        
        return DB::transaction(function() use ($request, $product, $buyer) {

            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);
        });


    }
}