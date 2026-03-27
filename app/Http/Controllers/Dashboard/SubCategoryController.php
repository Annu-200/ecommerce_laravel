<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function PHPUnit\Framework\fileExists;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       

        $subcategory = SubCategory::with('category')->paginate(3);
        return response()->json([
            'status'=>true,
            'message'=>'sub category found',
            'data'=> [
                'subcat'=>$subcategory
            ]
        ],200);
    }
    public function SubCategory(){
       return view('Dashboards.page.sub-category.subcategory');
    }
    public function ViewfetchCategory(){
       return view('Dashboards.page.sub-category.view-subcategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateFiled = Validator::make($request->all(),[
            'subcat_title'=>'required|string|max:255',
            'subcat_description'=>'required|string|max:1000',
            'subcat_status'=>'required|between:0,1',
            'subcat_images'=>'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'cat_id'=>'required|integer'
        ]);

        if($validateFiled->fails()){
            return response()->json([
                'status'=>false,
                'message'=>"Please insert Valid details",
                'error'=>$validateFiled->errors()->all(),
            ], 404);
        }

       
            $img = $request->subcat_images;
            $ext = $img->getClientOriginalExtension();
            $imgName = time() . '.' . $ext;
            $img->move(public_path(). '/uploads/subcategory', $imgName);

        //insert data
        $data = SubCategory::create([
            'subcat_title'=>$request->subcat_title,
            'subcat_description'=>$request->subcat_description,
            'subcat_status'=>$request->subcat_status,
            'cat_id'=>$request->cat_id,
            'subcat_images'=>$imgName
        ]);
        
        return response()->json([
            'status'=>true,
            'message'=>"Subcategory created successfully",
            'data'=>$data
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subcat = SubCategory::with('category')->where(['subcat_id'=>$id])->get();
        return response()->json([
            'status'=>true,
            'message'=>"single subcategory found successfully",
            'data'=>[
            'subcat'=>$subcat
            ]
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateFiled = Validator::make($request->all(),[
            'subcat_title'=>'required|string',
            'subcat_description'=>'required|string',
            'subcat_status'=>'required|between:0,1',
            'subcat_images'=>'nullable|mimes:jpg,png,jpeg,gif',
            'cat_id'=>'required|integer'
        ]);

        if($validateFiled->fails()){
            return response()->json([
                'status'=>false,
                'message'=>"Please insert Valid details",
                'error'=>$validateFiled->errors()->all(),
            ], 404);
        }

       $image_subcat = SubCategory::select('subcat_id','subcat_images')->where(['subcat_id'=>$id])->get();
       
       if($request->subcat_images != ''){
        $path = public_path() . '/uploads/subcategory/';
        if($image_subcat[0]->subcat_images != ""  &&  $image_subcat[0]->subcat_images != null){
          $img_old =  $path . $image_subcat[0]->subcat_images;
          if(fileExists($img_old)){
              unlink($img_old);
          }
        }

        $img = $request->subcat_images;
        $ext = $img->getClientOriginalExtension();
        $imgName = time() . '.' . $ext;
        $img->move(public_path() . "/uploads/subcategory", $imgName);

       }else{
        $imgName = $image_subcat[0]->subcat_images;
       }
       

        //insert data
        $data = SubCategory::where(['subcat_id'=>$id])->update([
            'subcat_title'=>$request->subcat_title,
            'subcat_description'=>$request->subcat_description,
            'subcat_status'=>$request->subcat_status,
            'cat_id'=>$request->cat_id,
            'subcat_images'=>$imgName
        ]);
        
        return response()->json([
            'status'=>true,
            'message'=>"Subcategory updated successfully",
            'data'=>$data
        ],200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcatImg = SubCategory::select('subcat_images')->where(['subcat_id'=>$id])->get();

        $path = public_path() . '/uploads/subcategory/' . $subcatImg[0]['subcat_images'] ;
      
        unlink($path);
        $subCat  = SubCategory::where(['subcat_id'=> $id])->delete();
        return response()->json([
            'status'=>true,
            'message'=>'subcategory delete successfully',
            'data'=>$subCat,
        ],200); 
    }
}
