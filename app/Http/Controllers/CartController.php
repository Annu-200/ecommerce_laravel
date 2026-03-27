<?php

namespace App\Http\Controllers;

use App\Models\ProductVarient;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart' , []);
        $varientId = collect($cart)->pluck('varient_id')->unique();
        $productVarient = ProductVarient::with('product')->whereIn('id', $varientId)->get()->keyBy('id');
        foreach($cart as $key =>$item){
           if(!isset($productVarient[$item['varient_id']])){
            unset($cart[$key]);
           }
        }
        session()->put('cart', $cart);
        return view('cart', compact('cart', 'productVarient'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id'=>'required|integer',
            'varient_id'=>'required|integer',
            'quantity'=>'required|integer|min:1',
        ]);
        $cart =  session()->get('cart', []);
         $product_id = $request->product_id;
         $varient_id = $request->varient_id;
         $quantity = $request->quantity;
         $varient = ProductVarient::findOrFail($varient_id);

         $key = $product_id . '_' . $varient_id;

         if(isset($cart[$key])){
            $cart[$key]['quantity'] += $quantity;
         }else{
            $cart[$key] =[
                'product_id' => $product_id,
                'varient_id' => $varient_id,
                'quantity'=> $quantity,
                'size'=>$request->size,
                'color'=>$request->color,
                'price'=>$varient->regular_price,
            ];
         }

         
         $cart[$key]['subtotal'] = $cart[$key]['price'] * $cart[$key]['quantity'];
         
         session()->put('cart', $cart);
         $total = array_sum(array_column($cart, 'subtotal'));
        
          return response()->json([
            'status'=>'success',
            'message'=>'Product added to cart successfully',
            'cart_count'=>count($cart), 
            'total'=>$total,
            'cart'=>$cart
          ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function updateCart(Request $request)
    {
        $qty = $request->quantity;
        $pId = $request->product_id;
        $varient_id = $request->varient_id;
        $key = $pId . '_' . $varient_id;

        $cart = session()->get('cart', []);
        if(isset($cart[$key])){
            $cart[$key]['quantity'] = $qty;
            $cart[$key]['subtotal'] = $cart[$key]['price'] * $qty;
            session()->put('cart', $cart);
        }
            $total = array_sum(array_column($cart, 'subtotal'));
            $item_subtotal = $cart[$key]['subtotal'];
            
            return response()->json([
                'status'=>'success',
                'message'=>'Cart updated successfully',
                'cart_count'=>count($cart), 
                'total'=>$total,
                'cart'=>$cart,
                'item_subtotal'=>$item_subtotal
            ]);
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function removeFromCart(string $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
          return response()->json([
            'status'=>'success',
            'message'=>'Product removed from cart successfully',
            'cart_count'=>count($cart), 
            'total'=>array_sum(array_column($cart, 'subtotal')),
            'cart'=>$cart
          ]);
        //
    }
}
