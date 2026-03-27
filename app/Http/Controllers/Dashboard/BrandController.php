<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = DB::table('brands')->paginate(3);
        return response()->json([
            'status'=>true,
            'message'=>'sub category found',
            'data'=> [
                'brand'=>$brands
            ]
        ],200);
    }
    //view data 
    public function brandAdd(){
        return view('Dashboards.page.brand.add-brand');
    }
    // fetch brands
    public function fetchBrand(){
        return view('Dashboards.page.brand.view-brands');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatData = Validator::make($request->all(),
        [
            'brand_name'=>'required|string|max:255',
            'status'=>'required|between:0,1'
        ]);
        if($validatData->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'please enter valid details',
                'error'=>$validatData->errors()->all()
            ], 404);
        }
        $brand = Brand::create([
            'brand_name'=>$request->brand_name,
            'status'=>$request->status
        ]);
        return response()->json([
            'status'=>true,
            'message'=>"Brand Add successfully",
            'brand'=>$brand
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['brand'] = Brand::select('id', 'brand_name', 'status')->where(['id'=>$id])->get();

        return response()->json([
            'status'=>true,
            'message'=>'Brand found successfully',
            'data'=>$data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatData = Validator::make($request->all(),
        [
            'brand_name'=>'nullable|string|max:255',
            'status'=>'nullable|between:0,1'
        ]);
        if($validatData->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'please enter valid details',
                'error'=>$validatData->errors()->all()
            ], 404);
        }
        $brand = Brand::where(['id'=>$id])->update([
            'brand_name'=>$request->brand_name,
            'status'=>$request->status
        ]);
        return response()->json([
            'status'=>true,
            'message'=>"Brand Updated successfully",
            'brand'=>$brand
        ], 200);
    }
    /**
     * Show Brand in Product table.
     */
    public function showBrand(){
        $brand = Brand::with('product')->get();
        return response()->json([
            'status'=>'true',
            'message'=>'brand found',
            'brand'=>$brand
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $brand = Brand::where(['id'=>$id])->delete();
     
        return response()->json([
            'status'=>true,
            'message'=>'brand Delete successfully',
            'brand'=>$brand
        ], 200);
    }
}
