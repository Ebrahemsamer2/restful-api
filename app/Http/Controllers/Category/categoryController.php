<?php

namespace App\Http\Controllers\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Category;

class categoryController extends ApiController
{

    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:20',
            'description' => 'required|min:10' ,
        ];

        $this->validate($request, $rules);

        $category = Category::create($request->all());

        return $this->showOne($category, 201);
    }

    public function show(Category $category)
    {
        return $this->showOne($category, 200);
    }

    public function update(Request $request, Category $category)
    {
            
        if($request->has('name')) {
            $category->name = $request->name;
        }
 
        if($request->has('description')) {
            $category->description = $request->description;
        }

        if(! $category->isDirty()) {
            return $this->errorResponse('This Category has not Changed', 422);
        }

        $category->save();
        return $this->showOne($category);

    }
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
