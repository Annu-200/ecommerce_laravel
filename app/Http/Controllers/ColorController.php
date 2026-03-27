<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $colors = Color::all();
            return response()->json(
                [
                    'status'=>true,
                    'message'=>'Color fetched successfully',
                    'data'=>$colors

                ]);
    }
    public function addColor()
    {
       return view('Dashboards.page.brand.color');
    }
    public function fetchColor()
    {
       return view('Dashboards.page.brand.view-color');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatData = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
        ]);
    
        if($validatData->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'please enter valid details',
                'error'=>$validatData->errors()->all()
            ], 404);
        }
        $color = Color::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Color added successfully',
            'color'=>$color
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $color = Color::select('*')->where(['id'=>$id])->first();
        return response()->json([
            'status'=>true,
            'message'=>'Color fetched successfully',
            'color'=>$color
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $validatData = Validator::make($request->all(),[
            'name' => 'sometimes|string|max:255',
            'code' => 'sometimes|string|max:255',
        ]);
    
        if($validatData->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'please enter valid details',
                'error'=>$validatData->errors()->all()
            ], 404);
        }
        $color = Color::where(['id'=>$id])->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Color updated successfully',
            'color'=>$color
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::find($id);
        if($color){
            $color->delete();
            return response()->json([
                'status'=>true,
                'message'=>'color deleted successfully',
                'color'=>$color
            ] , 200);
        }else{
        return response()->json([
            'status'=>false,
            'message'=>'Color not deleted ',
         ], 404);
      }
    }
}
