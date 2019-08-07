<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Buyer;

class buyerController extends ApiController
{
    public function index()
    {   
        $buyers = Buyer::has('transactions')->get();
        return $this->showAll($buyers);
    }

    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer);
    }

}
