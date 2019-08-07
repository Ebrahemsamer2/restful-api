<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{   
    use SoftDeletes;
    
    protected $fillable = [
    	'quantity',
    	'product_id',
    	'buyer_id',
    ];

    protected $dates = ['deleted_at'];

    public function product() {
    	return $this->belongsTo(Product::class);
    }

	public function buyer() {
    	return $this->belongsTo(Buyer::class);
    }    

}
