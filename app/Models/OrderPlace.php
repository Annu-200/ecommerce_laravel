<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPlace extends Model
{
    //
    protected $guarded = [];

    public function orderItem(){
        return $this->hasMany(OrderItem::class , 'order_id', 'id');
    }
}
