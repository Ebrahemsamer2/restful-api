<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Product;

class ProductTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        //
    ];
    
    protected $availableIncludes = [
        //
    ];
    
    public function transform(Product $product)
    {
       return [
            'id' => (int) $product->id,
            'title' => (string) $product->name,
            'details' => (string) $product->description,
            'stock' => (int) $product->quantity,
            'situation' => (string) $product->status,
            'picture' => url("images/". $product->image),
            'seller' => (int) $product->seller_id,
            'CreationDate' => $product->created_at->diffForHumans(),
            'LastChange' => $product->updated_at->diffForHumans(),
            'DeletionDate' => isset($product->deleted_at) ? $product->deleted_at->diffForHumans() : null,
        ];
    }

    public static function originalAttribute($index) {

        $attributes = [
            'id' => 'id',
            'title' => 'name',
            'details' => 'description',
            'stock' => 'quantity',
            'situation' => 'status',
            'picture' => 'image',
            'seller' => 'seller_id',
            'CreationDate' => 'created_at',
            'LastChange' => 'updated_at',
            'DeletionDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
