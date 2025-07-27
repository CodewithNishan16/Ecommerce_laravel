<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderContoller extends Controller
{
    public function store(Request $request)
    {
        $cartid= $request->cartid;
        $cart=cart::find($cartid);
        $data=[
            'user_id'=>auth()->id(),
            'product_id'=>$cart->product_id,
            'price'=>$cart->product->discounted_price!=null?$cart->product->discounted_price:$cart->product->price,
            'quantity'=>$cart->quantity,
            'name'=>$cart->user->name,
            'address'=>'Chitwam',
            'phone'=>'0348345',
        ];
        $order=Order::create($data);
        $cart->delete();
         $this->sendNewOrderEmail($order->id);
        return redirect()->route('mycart')->with('success', 'Order placed successfully');
    }
    public function storeEsewa(Request $request,$cartid)
    {
        $data=$request->data;
        $data=base64_decode($data);
        $data=json_decode($data,true);
        if($data['status']=='COMPLETE'){
            $cart=cart::find($cartid);
            $orderData=[
                'user_id'=>auth()->id(),
                'product_id'=>$cart->product_id,
                'price'=>$cart->product->discounted_price!=null?$cart->product->discounted_price:$cart->product->price,
                'quantity'=>$cart->quantity,
                'name'=>$cart->user->name,
                'address'=>'Chitwam',
                'phone'=>'0348345',
                'payment_method'=>'esewa',
                'payment_status'=>'paid',
            ];
            $order=Order::create($orderData);
            $cart->delete();
            $this->sendNewOrderEmail($order->id);
            return redirect()->route('mycart')->with('success', 'Order placed successfully via Esewa');
        }
        else
        {
            return redirect()->route('mycart')->with('error', 'Order failed via Esewa');
        }

    }
    public function index(){
        $orders= Order::latest()->get();
        return view('orders.index', compact('orders'));
    }
    public function updateStatus($orderid,$status){
        $order=Order::find($orderid);
        $order->payment_status=$status=='Delivered'?'paid':'Pending';
        //update the stock
        if(($order->order_status=='Pending' || $order->order_status=='Cancelled')&&($status=='Processing'||$status=='Delivered')){
            $order->product->stock-=$order->quantity; //decrease stock
            $order->product->save();
        }
        //if it is back to pending or cancelled, increase the stock
        if(($order->order_status=='Processing'||$order->order_status=='Delivered')&&($status=='Pending'||$status=='Cancelled')){
            $order->product->stock+=$order->quantity; //increase stock
            $order->product->save();
        }
            $order->order_status=$status;
            $order->save();
            //send email notification
            $this->sendEmail($orderid);
            return back()->with('success', 'Order status updated successfully');
    }
    public function sendEmail($orderid){
        $order=Order::find($orderid);
        $data=[
            'name'=>$order->name,
            'status' => $order->order_status,

        ];
        Mail::send('emails.orderstatus', $data, function($message) use ($order) {
            $message->to($order->user->email)
                    ->subject('Order Status Update Nortification');
        });
    }
    public function sendNewOrderEmail($orderid){
        $order=Order::find($orderid);
        $data=[
            'name'=>$order->name,
        
        ];
        Mail::send('emails.neworder', $data, function($message) use ($order) {
            $message->to($order->user->email)
                    ->subject('New Order Placed');
        });
    }
    public function cancelorder(Request $request, $orderid){
        $order=Order::where('id',$orderid)
        ->where('user_id', auth()->id())
        ->firstOrFail();
        $order->order_status='Cancelled';
        $order->save();
        return redirect()->route('myorders')->with('success', 'Order cancelled successfully');
    }

}
