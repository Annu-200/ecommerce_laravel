<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return  view('Dashboards.page.addcategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validData =  Validator::make($request->all(), [
            'cat_title' => 'required|string|max:255',
            'cat_description' => 'nullable|string|max:1000',
            'cat_images'=> 'requried|mimes:jpg,jpeg,png,gif',
            'status'=>'required|between:0,1',
        ]);   
      
        if ($validData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please Enter Valid details',
                'errors' => $validData->errors()->all(),
            ], 404);
        }
        $catImg = $request->cat_images;
        $ext = $catImg->getClientOriginalExtension();
        $catImgName = time(). '.' . $ext;
        $catImg->move(public_path(). '/uploads/category', $catImgName);

        $catData = Category::create([
            'cat_title' => $request->cat_title,
            'cat_description' => $request->cat_description,
            'cat_images' => $catImgName,
            'status' => $request->status,
            'slug' => Str::slug($request->cat_title)
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Category Created Successfully',
            'data'=> $catData
        ],200);        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
