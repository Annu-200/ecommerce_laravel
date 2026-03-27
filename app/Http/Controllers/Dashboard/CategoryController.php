<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function PHPUnit\Framework\fileExists;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catData['cat'] = DB::table('categories')->paginate(3);
        return response()->json([
            'status'=> true,
            'message'=>'All category Found',
            'data'=>$catData,
        ],200);
      
    }
     public function AllCategory()
    {
        $catData['cat'] = DB::table('categories')->get();
        return response()->json([
            'status'=> true,
            'message'=>'All category Found',
            'data'=>$catData,
        ],200);
      
    }
     /**
      *  view category
      */
      public function ViewCategory(){
      return view('Dashboards.page.category.addcategory'); 
    }
    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validate the request data
        $validData =  Validator::make($request->all(), [
            'cat_title' => 'required|string|max:255',
            'cat_description' => 'required|string|max:1000',
            'cat_images'=> 'required|mimes:jpg,jpeg,png,gif',
            'status'=>'required|between:0,1',
        ]);   
      // error handdling
        if ($validData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please Enter Valid details',
                'errors' => $validData->errors()->all(),
            ], 404);
        }
        // cooking Images for Uploads
        $catImg = $request->cat_images;
        $ext = $catImg->getClientOriginalExtension();
        $catImgName = time(). '.' . $ext;
        $catImg->move(public_path(). '/uploads/category', $catImgName);
        // Create a new category
        $catData = Category::create([
            'cat_title' => $request->cat_title,
            'cat_description' => $request->cat_description,
            'cat_images' => $catImgName,
            'status' => $request->status,
            'slug' => Str::slug($request->cat_title)
        ]);
        // return success message
        return response()->json([
            'status'=>true,
            'message'=>'Category Created Successfully',
            'data'=> $catData
        ],200);        
    }

    /**
     * Display the specified resource.
     */
     public function fetchCategory(){
        return view('Dashboards.page.category.view-category');
     }
 
    /**     
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['cat'] = Category::select('id', 'cat_title', 'cat_description','cat_images', 'status')->where(['id'=>$id])->get();

        return response()->json([
            'status'=>true,
            'message'=>'category find successfully',
            'data'=>$data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
     // Validate the request data
           $validData =  Validator::make($request->all(), [
            'cat_title' => 'required',
            'cat_description' => 'required',
            'cat_images'=> 'nullable|mimes:jpg,jpeg,png,gif',
            'status'=>'required'
        ]);   
      // error handdling
        if ($validData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please Enter Valid details',
                'errors' => $validData->errors()->all(),
            ], 404);
        }
        // cooking Images for Uploads
        $img_cat = Category::select('id','cat_images')->where(['id'=>$id])->get();

        if($request->cat_images != ''){
         $path = public_path() . "/uploads/category/";
         //check if id allready image exists then 
         if($img_cat[0]->cat_images != '' &&  $img_cat[0]->cat_images != null){
                $old_path = $path . $img_cat[0]->cat_images ;
                if(fileExists($old_path)){
                    unlink($old_path);
                }
            }
        
       $catImg = $request->cat_images;
        $ext = $catImg->getClientOriginalExtension();
        $catImgName = time(). '.' . $ext;
        $catImg->move(public_path() . '/uploads/category', $catImgName);
         
        }else{
            $catImgName = $img_cat[0]->cat_images;
        }
              $catData = Category::where(['id'=>$id])->update([
            'cat_title' => $request->cat_title,
            'cat_description' => $request->cat_description,
            'cat_images' => $catImgName,
            'status' => $request->status,
            'slug' => Str::slug($request->cat_title)
        ]);
        // return success message
        return response()->json([
            'status'=>true,
            'message'=>'Category Update Successfully',
            'data'=> $catData
        ],200);  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fileName = Category::select('cat_images')->where(['id'=>$id])->get();
        $path = public_path() . '/uploads/category/' . $fileName[0]['cat_images'];
        unlink($path);
       $catData = Category::where(['id'=>$id])->delete();

        return response()->json([
        'status' => true,
         'message'=> "category Delte successfully",
         'data'=>$catData
         ] ,200);
        

    }
}
