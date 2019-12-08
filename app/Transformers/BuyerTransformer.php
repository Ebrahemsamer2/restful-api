<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Buyer;

class BuyerTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        //
    ];
    
    protected $availableIncludes = [
        //
    ];
    
    public function transform(Buyer $buyer)
    {
        return [
            'id' => (int) $buyer->id,
            'name' => (string) $buyer->name,
            'email' => (string) $buyer->email,
            'isVerified' => (int) $buyer->verified,
            'CreationDate' => $buyer->created_at->diffForHumans(),
            'LastChange' => $buyer->updated_at->diffForHumans(),
            'DeletionDate' => isset($buyer->deleted_at) ? $buyer->deleted_at->diffForHumans() : null,
        ];
    }

    public static function originalAttribute($index) {

        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'CreationDate' => 'created_at',
            'LastChange' => 'updated_at',
            'DeletionDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
