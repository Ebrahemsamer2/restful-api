<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryProductsController extends ApiController
{

    public function index(Category $category)
    {
        $products = $category->products;
        return $this->showAll($products);
    }
}