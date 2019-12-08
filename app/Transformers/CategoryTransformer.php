<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Category;

class CategoryTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        //
    ];
    
    protected $availableIncludes = [
        //
    ];
    
    public function transform(Category $category)
    {
        return [
            'id' => (int) $category->id,
            'title' => (string) $category->name,
            'details' => (string) $category->description,
            'CreationDate' => $category->created_at->diffForHumans(),
            'LastChange' => $category->updated_at->diffForHumans(),
            'DeletionDate' => isset($category->deleted_at) ? $category->deleted_at->diffForHumans() : null,
        ];
    }

    public static function originalAttribute($index) {

        $attributes = [
            'id' => 'id',
            'title' => 'name',
            'details' => 'description',
            'CreationDate' => 'created_at',
            'LastChange' => 'updated_at',
            'DeletionDate' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
