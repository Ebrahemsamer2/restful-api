<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transaction;

class TransactionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        //
    ];

    protected $availableIncludes = [
        //
    ];
    
    public function transform(Transaction $transaction)
    {
        return [
            'id' => (int) $transaction->id,
            'quantity' => (string) $transaction->quantity,
            'buyer' => (string) $transaction->buyer_id,
            'product' => (string) $transaction->product_id,
            'CreationDate' => $transaction->created_at->diffForHumans(),
            'LastChange' => $transaction->updated_at->diffForHumans(),
            'DeletionDate' => isset($transaction->deleted_at) ? $transaction->deleted_at->diffForHumans() : null,
        ];
    }
    public static function originalAttribute($index) {

        $attributes = [
            'id' => 'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
            'CreationDate' => 'created_at',
            'LastChange' => 'updated_at',
            'DeletionDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
