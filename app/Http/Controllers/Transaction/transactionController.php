<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Transaction;

class transactionController extends ApiController
{
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction, 200);
    }
}
