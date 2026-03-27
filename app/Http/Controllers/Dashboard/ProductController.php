<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productAll = Product::with('subcategory','brandShow')->paginate(3);
        $product = Product::select('product_id','product_name')->get();
        return response()->json([
            'status'=> true,
            'massage'=>"all product found ",
            "data"=> $productAll ,
            "product_list"=>$product
        ],200);
        
    }
    public function showCategory(){
        $cat = SubCategory::with('product')->get();
      
        return response()->json([
            'status'=>'true',
            'message'=>'category found',
            'cat'=>$cat
        ], 200);
    }
    
    public function addProduct(){
     return view('Dashboards.page.product.addProduct');
    }
    public function viewProduct(){
     return view('Dashboards.page.product.view-product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatFeailds = Validator::make($request->all(), [
         'product_name'=> 'required|string|max:255',
         'status'=>'required|between:0,1',
         'pro_description'=>'required|max:1000',
         'short_description'=>'required|string|max:255',
         'brand_id'=>'required|integer',
         'hot_trend'=>'sometimes|integer',
         'feature'=>'sometimes|integer',
         'best_seller'=>'sometimes|integer',
         'subcat_id'=>'required|integer',
        ]);
        if($validatFeailds->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'please enter valid details',
                'error'=>$validatFeailds->errors()->all()
            ], 404);
        }
        $product = Product::create([
            'product_name'=>$request->product_name,
            'status'=>$request->status,
            'pro_description'=>$request->pro_description,
            'short_description'=>$request->short_description,
            'slug'=>Str::slug($request->product_name),
            'subcat_id'=>$request->subcat_id,
            'brand_id'=>$request->brand_id,
            'hot_trend'=>$request->hot_trend,
            'best_seller'=>$request->best_seller,
            'feature'=>$request->feature,
        ]);
        
        return response()->json([
            'status'=>true,
            'message'=>'Product add successfully',
            'data'=>$product
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('subcategory', 'brandShow')->select(
            'product_id',
            'product_name',
            'status',
            'pro_description',
            'short_description',
            'brand_id',
            'subcat_id',
            'hot_trend',
            'feature',
            'best_seller',
        )->where(['product_id'=>$id])->get();
        $subcat = SubCategory::all();
        $brand = Brand::all();
        return response()->json([
            'status'=> true,
            'massage'=>"Product found successfully ",
            "data"=>$product, 
            "subcat"=>$subcat, 
            "brand"=>$brand, 
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatFeailds = Validator::make($request->all(), [
            'product_name'=> 'required|string|max:255',
            'status'=>'required|between:0,1',
            'pro_description'=>'required|max:1000',
            'short_description'=>'required|string|max:255',
            'brand_id'=>'required|integer',
            'subcat_id'=>'required|integer',
            'hot_trend'=>'sometimes|integer',
            'feature'=>'sometimes|integer',
            'best_seller'=>'sometimes|integer',
            'subcat_id'=>'required|integer',
           ]);
           if($validatFeailds->fails()){
               return response()->json([
                   'status'=>false,
                   'message'=>'please enter valid details',
                   'error'=>$validatFeailds->errors()->all()
               ], 404);
           }
           $product = Product::where(['product_id'=>$id])->update([
               'product_name'=>$request->product_name,
               'status'=>$request->status,
               'pro_description'=>$request->pro_description,
               'short_description'=>$request->short_description,
               'slug'=>Str::slug($request->product_name),
               'subcat_id'=>$request->subcat_id,
               'brand_id'=>$request->brand_id,
               'hot_trend'=>$request->hot_trend,
               'feature'=>$request->feature,
               'best_seller'=>$request->best_seller,
           ]);
           
           return response()->json([
               'status'=>true,
               'message'=>'Product Update successfully',
               'data'=>$product
           ], 200);
    }
      /**
     * find the specified resource from storage.
     */
    public function liveSearch( Request $request){
      $search = $request->input('query');
      $product = Product::with('varient', 'subCategory')->where('product_name', 'LIKE', "%{$search}%")
      ->orWhereHas('varient', function($q) use ($search){
        $q->where('color', 'LIKE', "%{$search}%");
      })->get();
      $output = " ";
      foreach($product as $productname){
        
            $vaientsize = $productname->varient->size;
            $vaientId = $productname->varient->id;
            $img = $productname->varient->thumbnail;
           $url = route('productdetails',$vaientId);

      $output .= "
<a href='{$url}' class='search-item d-flex align-items-center'>
    <img src='" . asset('/uploads/product/thumbnails/' . $img) . "' 
         width='50' height='50'
         class='search-image me-2' 
         style='object-fit:cover; border-radius:5px;'>

    <span>{$productname->product_name} - {$vaientsize}</span>
</a>
";

         
      }
      return response()->json([
        'status'=>true,
        'message'=>'Product found successfully',
        'data'=>$output
       ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::where(['product_id'=>$id])->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Product Update successfully',
            'data'=>$data
        ], 200);
    }
}
