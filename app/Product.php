<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\ProductTransformer;
class Product extends Model
{

    use SoftDeletes;

	const PRODUCT_AVAILABLE = 'available'; 
	const PRODUCT_UNAVAILABLE = 'unavailable'; 

    public $transformer = ProductTransformer::class;
    protected $fillable = [
    	'name',
    	'description',
    	'quantity',
    	'status',
    	'image',
    	'seller_id',
    ];

    protected $dates = ['deleted_at'];


    protected $hidden = ['pivot'];

    // return true if the product is available
    public function isAvailable() {
    	return $this->status == Product::PRODUCT_AVAILABLE;
    }

    // many to many relationship
    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    // product has many transaction
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function seller() {
        return $this->belongsTo(Seller::class);
    }


}
