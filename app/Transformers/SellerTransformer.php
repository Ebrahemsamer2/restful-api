<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Seller;

class SellerTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        //
    ];

    protected $availableIncludes = [
        //
    ];
    
    public function transform(Seller $seller)
    {
        return [
            'id' => (int) $seller->id,
            'name' => (string) $seller->name,
            'email' => (string) $seller->email,
            'isVerified' => (int) $seller->verified,
            'CreationDate' => $seller->created_at->diffForHumans(),
            'LastChange' => $seller->updated_at->diffForHumans(),
            'DeletionDate' => isset($seller->deleted_at) ? $seller->deleted_at->diffForHumans() : null,
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
