<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductVarient;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $guarded = [];
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    public function varient(){
        return $this->belongsTo(ProductVarient::class, 'varient_id', 'id');
    }
}
