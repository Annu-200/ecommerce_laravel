<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVarient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Constraint\FileExists;

use function PHPUnit\Framework\fileExists;

class ProductVarientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product['pro'] = DB::table('product_varients')
        ->join('products', 'product_varients.product_id', '=',  'products.product_id')
        ->join('sizes', 'product_varients.size', '=', 'sizes.id')
        ->select('product_varients.*', 'product_name as product_title', 'sizes.size as size')
        ->paginate(3);
        return response()->json([
            'status'=>true,
            'massage'=>"product details found successfully",
            'product'=>$product
        ]);
    }
    //View ADD Products
    public function addProduct(){
        return view('Dashboards.page.product.product-variant');
    }
    // View All products
    public function viewProduct(){
        return view('Dashboards.page.product.view-product-details');
    }
    public function showSize(){
        $size = DB::table('sizes')->get();
        return response()->json([
            'status'=>true,
            'massage'=>"product size found successfully",
            'size'=>$size
        ],200);
    }

    public function showColor(){
        $color = DB::table('colors')->get();
        return response()->json([
            'status'=>true,
            'massage'=>"product size found successfully",
            'data'=>$color
        ],200);
    }
    public function productDisplay(){
        $size = ProductVarient::with('product')->get();
        return response()->json([
            'status'=>true,
            'massage'=>"product size found successfully",
            'size'=>$size
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateFildes = Validator::make($request->all(),[
            
            'price'=>'decimal:2',
            'regular_price'=>'decimal:2',
            'stock_quantity'=>'required|numeric',
            'size'=>'required|integer',
            'color'=>'required|integer',
            'product_id'=>'required|integer',
              'thumbnail'=>'required|mimes:jpg,jpeg,png,gif',
              'gallery'=>'required|array',
              'gallery.*'=>'mimes:jpg,jpeg,png,gif|max:2048',
             'status'=>'required|between:0,1'
        ]);
        if($validateFildes->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'please enter valid details',
                'error'=>$validateFildes->errors()->all()
            ], 404);
        }
        //thumbnail
      

        $thumbnail = $request->thumbnail ;
        $ext = $thumbnail->getClientOriginalExtension();
        $thumbnailName =  time() . "." . $ext; 
        $thumbnail->move(public_path(). '/uploads/product/thumbnails' ,$thumbnailName);
      //gallery
      $filenames = [];
            if ($request->hasFile('gallery')) {
        foreach ($request->file('gallery') as $file) {
            $filename = time() . '-' . uniqid() .  '.' . $file->getClientOriginalExtension();
            $file->move(public_path(). '/uploads/product/gallery', $filename); 
            $filenames[] = $filename;
        } 
    }

      
        $sku = 'SKU'. '-' . $request->product_id . '-' . $request->size . '-' . strtoupper(Str::random(4));
        $product = ProductVarient::create([
            'product_id'=>$request->product_id,
            'sku'=>$sku,
            'price'=>$request->price,
            'regular_price'=>$request->regular_price,
            'stock_quantity'=>$request->stock_quantity,
            'size'=>$request->size,
            'color'=>$request->color,
            'thumbnail'=>$thumbnailName,
            'status'=>$request->status,
            'gallery'=>$filenames,

        ]);
        

        return response()->json([
            'status'=>true,
            'massage'=>"product created  successfully",
            'product'=>$product
        ],200);
    }  

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product['pro'] = DB::table('product_varients')
        ->join('products', 'product_varients.product_id', '=',  'products.product_id')
        ->join("sizes", "product_varients.size", "=" , "sizes.id")
        ->select("product_varients.*", "product_name as product_title", "sizes.id as size_id", "sizes.size as size_name")
        ->where(['product_varients.id'=> $id])->get();

        return response()->json([
            'status'=>true,
            'message'=>"Single Product Details found successfully",
            'product'=>$product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = ProductVarient::find($id);
        $validateFildes = Validator::make($request->all(),[
            'price' => 'decimal:2',
            'regular_price' => 'decimal:2',
            'stock_quantity' => 'numeric',
            'size' => 'integer',
            'color' => 'integer',
            'product_id' => 'integer',
            'thumbnail' => 'sometimes|mimes:jpg,jpeg,png,gif,JPG,PNG,JPEG,GIF',
            // accept either a single file in `gallery` OR an array `gallery.*`
            'gallery' => 'sometimes|mimes:jpg,jpeg,png,gif,JPG,PNG,JPEG,GIF|max:2048',
            'gallery.*' => 'sometimes|mimes:jpg,jpeg,png,gif,JPG,PNG,JPEG,GIF|max:2048',
            'status' => 'between:0,1'
        ]);
        if($validateFildes->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'please enter valid details',
                'error'=>$validateFildes->errors()->all()
            ], 404);
        }
        // Keep current values by default
        $thumbnailName = $product->thumbnail;
        $gallery_img = is_array($product->gallery) ? $product->gallery : json_decode($product->gallery, true);
        $index = (int) $request->input('image_index');

        // Optional thumbnail update
        if ($request->hasFile('thumbnail')) {
            $oldThumbPath = public_path() . '/uploads/product/thumbnails/' . $thumbnailName;
            if (File::exists($oldThumbPath)) {
                @unlink($oldThumbPath);
            }
            $thumbnail = $request->file('thumbnail');
            $ext = $thumbnail->getClientOriginalExtension();
            $thumbnailName = time() . "." . $ext;
            $thumbnail->move(public_path(). '/uploads/product/thumbnails', $thumbnailName);
        }

        // Optional single gallery image replacement
        if ($request->hasFile('gallery') && isset($gallery_img[$index])) {
            $oldPath = public_path() . '/uploads/product/gallery/' . $gallery_img[$index];
            if (File::exists($oldPath)) {
                @unlink($oldPath);
            }
            // support both single file in `gallery` and array `gallery[]`
            $uploaded = $request->file('gallery');
            if (is_array($uploaded)) {
                $uploaded = $uploaded[0];
            }
            $filename = uniqid() . '.' . $uploaded->getClientOriginalExtension();
            $uploaded->move(public_path(). '/uploads/product/gallery', $filename);
            $gallery_img[$index] = $filename;
        }
        $sku = 'SKU'. '-' . $product->product_id . '-' . $request->size . '-' . strtoupper(Str::random(4));
        $data =  ProductVarient::where(['id' => $id])->update([
            'sku'=>$sku,
            'price'=>$request->price ?? $product->price,
            'regular_price'=>$request->regular_price ?? $product->regular_price,
            'stock_quantity'=>$request->stock_quantity ?? $product->stock_quantity,
            'size'=>$request->size ?? $product->size,
            'thumbnail'=>$thumbnailName ?? $product->thumbnail,
            'status'=>$request->status ?? $product->status,
            'color'=>$request->color ?? $product->color,
            'gallery'=>$gallery_img ?? $product->gallery,
        
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Product Update successfully',
            'data'=>$data
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,string $id)
    {
        $product = ProductVarient::find($id);
        if($product){
            // Delete Gallery Img
            $gallery = is_array($product->gallery) ?  $product->gallery : json_decode($product->gallery , true);
            $index = (int) $request->input('image_index');
           // single array index
         if(!empty($gallery) && isset($gallery[$index])){
            $path = public_path() . '/uploads/product/gallery' . $gallery[$index];
            if(file_exists($path)){
                unlink($path);
            }
         }
        // unlink all images 
        if(!empty($gallery) && is_array($gallery)){
           foreach( $gallery as $img){
               $file = public_path() . '/uploads/product/gallery/' . $img ;
             if(file_exists($file)){
                @unlink($file);
             }
           }
        }
        //unlink image thumbnail
        $thumbnail = $product->thumbnail;
        if(!empty($thumbnail)){
            $thumfile = public_path() . '/uploads/product/thumbnail/' . $thumbnail ;
            if(file_exists($thumfile)){
                @unlink($thumfile);
            }
        }
    }
        
        $data = ProductVarient::where(['id'=>$id])->delete();
        return response()->json([
            'status'=>true,
            'message'=>'product delete successfully',
            'data'=>$data
        ]);

    }
}
