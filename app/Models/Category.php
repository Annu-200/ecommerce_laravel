<?php

namespace App\Models;
use App\Models\SubCategory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    //
    use HasApiTokens;

    protected $table = 'categories';
    protected $guarded = [];
     
      
    public function SubCategory(){
        return $this->hasMany(SubCategory::class,'cat_id' , 'id');
       }
    
}
