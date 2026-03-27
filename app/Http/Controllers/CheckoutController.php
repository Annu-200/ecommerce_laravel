<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\OrderPlace;
use App\Models\ProductVarient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $varientId = collect($cart)->pluck('varient_id')->unique();
        $productVarient = ProductVarient::with('product')->whereIn('id', $varientId)->get()->keyBy('id');
        $subtotal = 0;
        $total = 0;
        foreach($cart as $item){
            $subtotal += $item['price'] * $item['quantity'];
        }
         $total = array_sum(array_column($cart, 'subtotal'));

         if(empty($cart)){
            return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items to your cart before checking out.');
         }

        return view('checkout-page', compact('cart', 'productVarient', 'subtotal', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validation =  Validator::make($request->all() ,[
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|numeric|digits_between:10,12',
            'address'=>'required|string|max:255',
            'apartment'=>'nullable|string|max:255',
            'city'=>'required|string|max:100',
            'state'=>'required|string|max:100',
            'pin'=>'required|string|max:20',
            'payment_method'=>'required|string|in:cod,online',
            'order_note'=>'nullable|max:500',
            
        ]);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $userId = Auth::check() ? Auth::id() : null;
          $cart = session()->get('cart',[]);
          if(empty($cart)){
            return redirect()->back()->with(
            'error', 'Your cart is empty.
            Please add items to your cart
             before checking out.');
          }
          $subtotal = 0 ;
          foreach($cart as $item){
            $subtotal += $item['price'] * $item['quantity'];

          }
    
          $tax = $subtotal * 0.18; // Assuming a tax rate of 10%
          $total = $subtotal + $tax;
           
             $order = OrderPlace::create([
             'first_name'=>$request->first_name,
             'last_name'=>$request->last_name,
             'email'=>$request->email,
             'phone'=>$request->phone,
             'address'=>$request->address,
             'apartment'=>$request->apartment,
             'city'=>$request->city,
             'state'=>$request->state,
             'pin'=>$request->pin,
             'subtotal'=>$subtotal,
             'total'=>$total,
             'payment_mode'=>$request->payment_method,
              'status'=>'pending',
              'user_id'=>$userId,
              'order_note'=>$request->order_note,
              'taxt'=>$tax,
          ]);
          $orderNum = "ORD-" . date('Ymd') . '-' .str_pad($order->id, 5, 0 , STR_PAD_LEFT);
        
          $order->update([
            'order_num'=>$orderNum
        ]);

        foreach($cart as $item){
         OrderItem::create([
            'order_id'=>$order->id,
            'product_id'=>$item['product_id'],
            'varient_id'=>$item['varient_id'],
            'quantity'=>$item['quantity'],
            'price'=>$item['price'],
            'subtotal'=>$item['subtotal'] * $item['quantity'],
        ]);
        }
         foreach($cart as $item){
            $varientId = ProductVarient::find($item['varient_id']); 
        }

        if($varientId && $order->payment_mode === "cod"){
            $varientId->decrement('stock_quantity', $item['quantity']);
        }

        session()->forget('cart');

        if($order->payment_mode === 'online'){
            
            return redirect()->route('razorpay.payment',['id'=>$order->id])->with('total', $order->total);
        }

      return redirect()->route('order.success',['id'=>$order->id])->with('success', 'Your order has been placed successfully!');


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
