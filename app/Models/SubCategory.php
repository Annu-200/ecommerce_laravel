<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Product;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasApiTokens;
    protected $table = 'subcategories';
    protected $guarded = [];
    protected $primaryKey = 'subcat_id';
   
    public function category(){
        return $this->belongsTo(Category::class,'cat_id', 'id');
    }
    public function product(){
        return $this->hasMany(Product::class, 'subcat_id', 'product_id');
    }
    
}
