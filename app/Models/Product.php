<?php

namespace App\Models;

use App\Models\SubCategory;
use App\Models\Brand;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasApiTokens;
    protected $guarded = [];
    protected $primaryKey = 'product_id';

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'subcat_id','subcat_id');
    }
    public function brandShow()
    {
        return $this->belongsTo(Brand::class, 'brand_id','id');
    }
    public function varient()
    {
        return $this->belongsTo(ProductVarient::class, 'product_id','product_id');
    }
   
}
