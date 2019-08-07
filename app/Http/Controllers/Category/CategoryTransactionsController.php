<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionsController extends ApiController
{
    public function index(Category $category)
    {
        
        $transactions = $category->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->unique()
            ->values();

        return $this->showAll($transactions);    

    }
}