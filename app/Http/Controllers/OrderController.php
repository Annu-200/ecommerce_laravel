<?php

namespace App\Http\Controllers;

use App\Mail\orderemail;
use App\Models\OrderItem;
use App\Models\OrderPlace;
use App\Models\ProductVarient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Pest\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
    }
        public function success($id, Request $request){
            $message = "Your order has been placed successfully. Thank you for shopping with us!";
            $order = OrderPlace::find($id);
            $subject = "Order Confirmation - Order #$order->order_num";

       if(!$order){
            return redirect()->route('error')->with('error', 'Order not found.');
       }
    //    dd(session()->all(), $order->order_num);
        $currentUser = session()->get('order_num', []);
        if($currentUser != $order->order_num){
            return redirect()->route('error')->with('error', 'Unauthorized access. Please check your order number and try again.');
        }
        if($order->payment_mode == "online"){  

                $order->update([
                'payment_status'=>'paid',   
            ]); 
        }
        Mail::to($order->email)->send(new orderemail($message, $subject, $order));
            $orderItem = OrderPlace::with('orderItem.product', 'orderItem.varient')->where(['id'=>$id])->first();
           foreach($orderItem->orderItem as $item){
            $varientId = ProductVarient::find($item['varient_id']); 
                if($varientId){
                    $varientId->decrement('stock_quantity', $item['quantity']);
                }
           }
           
           
            return view('success', compact('order', 'orderItem', 'id'));
        }

    /**
     * Show the form for creating a new resource.
     */
    public function trackOrder()
    {
        return view('track');
    }
    public function trackOrderStatus(Request $request){
        $validationFealid = Validator::make($request->all(), [
            'email'=>'required|email|max:255',
            
        ]);
        if($validationFealid->fails()){
            return redirect()
            ->route('order.track')
            ->withErrors($validationFealid)
            ->withInput();
        }
    $order = OrderPlace::with('orderItem.product')->where(['email'=>$request->email])->latest()->get();
        if(!$order){
            return redirect()->route('error')->with('error', 'Order not found. Please check your email and order number and try again.');
        }
        return view('myorder', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function adminOrder()
    {
        $order = OrderPlace::select('*')->get();
        return view('Dashboards.page.order.view-order', compact('order'));
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
    public function OrderAdminEdit(string $id)
    {
        $order = OrderPlace::findOrFail($id);

        if(!$order){
            return response()->json([
                'message'=>'Order not found',
                "status"=>false
            ],404);
        }
        return  response()->json([
            'message'=>'success',
            'order'=>$order,
            
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function OrderAdminUpdate(Request $request, string $id)
    {
        $order = OrderPlace::findOrFail($id);

            if($request->status == "shipped"){
                $tracking_id = "TRK" . strtoupper(Str::random(10));
               
                $order->update([
                    'status'=>$request->status,
                    "tracking_id"=>$tracking_id
                ]);
             }
            if($request->status == "delivered"){
                    $order->update([
                        'status'=>$request->status,
                    ]);
                }
              if(!$order){
                    return response()->json([
                        'message'=>'Order not found',
                        "status"=>false
                    ],404);
                }
        return response()->json([
            'message'=>'success',
            'order'=>$order,
            "status"=>true
            
        ],200);
    }

     public function orderDestroy(string $id){
        $order = OrderPlace::find($id);

       
        if(!$order){
            return response()->json([
                'message'=>'Order not found',
                "status"=>false
            ],404);
        }
         OrderItem::where('order_id', $id)->delete();
        $order->delete();
        return response()->json([
            'message'=>'Order deleted successfully',
            "status"=>true
        ],200);
        
     }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        
        $order = OrderPlace::findOrFail($id);
          $orderItem = OrderItem::where('order_id', $id)->get();

        foreach( $orderItem  as $item){

            $varientId = ProductVarient::find($item['varient_id']); 
            if($varientId && $order->payment_mode == "cod"){
                $varientId->increment('stock_quantity', $item['quantity']);
            }
        }
        // dd($varientId);
        
        $order->delete();
        return redirect()->route('cart')->with('success', 'Order cancelled successfully.');
    }
}
