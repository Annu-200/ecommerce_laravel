<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVarient;

class Size extends Model
{
    //
    protected $guarded = [];
    public function varient(){
        return $this->hasMany(ProductVarient::class,'size','id');
    } 
}
