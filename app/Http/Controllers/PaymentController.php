<?php

namespace App\Http\Controllers;

use App\Models\OrderPlace;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class paymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function payment(int $id ,Request $request){
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = OrderPlace::findOrFail($id);
        // dd($order);
        $razorpay =  $api->order->create([
            'receipt'=> $order->order_num,
            'amount'=>(int) ($order->total * 100),
            'currency'=>'INR'
         ]);
            $order->update([
                'razorpay_order_id'=> $razorpay->id,
                'payment_mode'=>'online',
                'payment_status'=>'pending'
            ]);
        return view('razorpay',[
            'order'=>$razorpay->id,
            "orderId"=>$order->id,
            'amount'=>(int)($order->total*100),
            "key"=>env('RAZORPAY_KEY')
        ], );

    }   
    public function paymentSuccess(int $id, Request $request){
        $order = OrderPlace::findOrFail($id);
        // $api->utility->verifyPaymentSignature([
        //'razorpay_order_id' => $request->order_id,
        //'razorpay_payment_id' => $request->payment_id,
        //'razorpay_signature' => $request->signature

        $order->update([
            'payment_status'=>'paid',   
            'razorpay_payment_id'=>$request->payment_id
        ]); 
        
        return view('order.success', compact(['id'=>$order->id]));
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
