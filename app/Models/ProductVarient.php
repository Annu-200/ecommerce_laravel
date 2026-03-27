<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;

class ProductVarient extends Model
{
    use HasApiTokens;
    protected $guarded = []; 
    protected $casts = [
    'gallery' => 'array',
];
        
    public function product(){
        return $this->belongsTo(Product::class,'product_id', 'product_id');  
    }
    public function color(){
        return $this->belongsTo(Color::class,'color','id');
    }
    public function size(){
        return $this->belongsTo(Size::class,'size','id');
    }
   
}
