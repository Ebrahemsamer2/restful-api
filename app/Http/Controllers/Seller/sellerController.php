<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Seller;

class sellerController extends ApiController
{
    public function index()
    {
        $sellers = Seller::has('products')->get();
        return $this->showAll($sellers);
    }

    public function show(Seller $seller)
    {
        // $seller = Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
    }
}
