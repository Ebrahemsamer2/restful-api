<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionSellerController extends ApiController
{

    public function index(Transaction $transaction)
    {
        $seller = $transaction->product->seller;
        return $this->showOne($seller, 200);
    }
}
