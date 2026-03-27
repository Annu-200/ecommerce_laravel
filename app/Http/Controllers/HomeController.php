<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $category = Category::first();
        $categoryAll = Category::skip(1)->take(4)->get();
        $porduct = DB::table('product_varients')->join('products', 'products.product_id', '=', 'product_varients.product_id')->get();
        $category_data = Category::with('SubCategory')->take(5)->get();
       $hot_trend = Product::with('Subcategory')->where('hot_trend', 1)->get();
       $best_seller = Product::with('varient', 'Subcategory')->where('best_seller', 1)->get();
       $feature = Product::with('Subcategory')->where('feature', 1)->get();
        return view('welcome', compact('category', 'categoryAll', 'porduct', 'category_data', 'hot_trend', 'best_seller', 'feature'));
    }
    public function productDetails($id)
    {
       $product = ProductVarient::with(
        ['product.brandShow',
        'product.subCategory.category',
        'color',
         'size' 
        ])->find($id);
                                                    
        if(!$product){
            return  redirect()->route('error')->with('error', 'Product not found');
        }

      
         $product_data = ProductVarient::with('product.subCategory')->get();
        
         $color = Color::all();
         $size = Size::all();
        //  return dd($product);
        return view('products-details', compact('product', 'product_data', 'color','size'));
    }
    public function filtercategory(Request $request)
    {
        if($request->cat_id == 'all'){
            $category_product = ProductVarient::select('product_varients.*', 'products.*')
            ->join('products', 'products.product_id', '=', 'product_varients.product_id')
            ->get();
        }else{
            $category_product = ProductVarient::join('products', 'products.product_id', '=', 'product_varients.product_id')
            ->join('subcategories', 'subcategories.subcat_id', '=', 'products.subcat_id')
            ->where('subcategories.cat_id', $request->cat_id)
            ->select('product_varients.*', 'subcategories.cat_id', 'products.*')
            ->get();

        }

        return response()->json([
            'status' => true,
            'message'=>'Category Filtered Successfully',
            'category_product' => $category_product,
        ], 200);
    }

    public function CategoryOne($cat_id = null){
        if($cat_id){
         $subcategories = Category::with('SubCategory')->where('categories.id', $cat_id)->first();
        //  dd($subcategories);
        }else{
        $subcategories = Category::with('SubCategory')->get();
        }
        $product_all = Product::with('varient')->get();
         

    //    dd($subcategories);
        return view('category-single', compact('subcategories', 'product_all','cat_id'));
    }
    public function SendCategory(){
        $subcategories = Category::with('SubCategory')->take(2)->get();
        return view('pages.main', compact('subcategories'));
    
    }
    public function shopNow(){
        $product_all = Product::with('varient')->orderby('created_at', 'desc')->paginate(9);
   
         $category = Category::with('SubCategory')->get();
         $color =  Color::all();
         $sizes = Size::all();
          $max_price = ProductVarient::max('regular_price');
           $min_price = ProductVarient::min('regular_price');
        return view('shop', compact('product_all', 'category','sizes','color','max_price','min_price'));
    }
    public function filterProduct(Request $request){
          
        $max = $request->maxprice;
        $min = $request->minprice;
        $sizes = $request->sizes;
        $color = $request->color;
        $subcat = $request->subcat  ;
        $subcatInput =  $request->input('subcat');
        $query = ProductVarient::with(['product', 'size']);
      
        // GET PRODUCT BY Price FILTER
        if($max && $min){
            $query->whereBetween('regular_price', [$min, $max]);
        }
        
        // GET PRODUCT BY SIZE FILTER

        if($sizes && is_array($sizes) && count($sizes) > 0){
            $sizeId = Size::whereIn('size' , $sizes)->pluck('id')->toArray();
            if($sizeId > 0){
                $query->whereIn('size' , $sizeId);
            }
        }
        // FILTER PRODUCT BY COLOR
        if($color && is_array($color) && count($color) > 0){
            $colorId = Color::WhereIn('name', $color)->pluck('id')->toArray();
            if($colorId >  0){
                $query->whereIn('color', $colorId);
            }
        }

        // GET PRODUCT BY SUB-CATEGORY
        if($subcat && is_array($subcat) && count($subcat) > 0){
            // Filter out empty values
                
            $subcat_ids = array_filter($subcat, function($value) {
                return !empty($value);
            });
            
            if(count($subcat_ids) > 0){
                $query->whereHas('product', function($q) use ($subcat_ids){
                    $q->whereIn('subcat_id', $subcat_ids);
                });
            }
        }
        if($subcatInput){
            $subcatInput = is_array($subcatInput) ? $subcatInput : explode(',', $subcatInput);
            $query->whereHas('product', function($q) use ($subcatInput){
                $q->whereIn('subcat_id', $subcatInput);
            });
        }

        $product_all = $query->orderby('created_at', 'desc')->paginate(6);

        return response()->json([
            'status' => true,
            'message'=>'Price fetched Successfully',
            'price' => $product_all,
        ], 200);
    }

    
   
}
