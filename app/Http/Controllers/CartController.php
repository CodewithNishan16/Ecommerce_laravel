<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request){
        $data= $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);
        $data['user_id'] = auth()->id();
        
        $existingCart = Cart::where('user_id', $data['user_id'])
            ->where('product_id', $data['product_id'])
            ->first();
            if ($existingCart) {
                $existingCart->quantity = $data['quantity'];
                $existingCart->save();
                return back()->with('success', ' cart updated successfully!');
            } else {
                cart::create($data);
                return back()->with('success', 'Product added to cart successfully!');
            }
    }
    public function mycart(){
        $carts = cart::where('user_id', auth()->id())->get();
        foreach($carts as $cart){
            if($cart->quantity > $cart->product->stock){
                $cart->quantity = $cart->product->stock;
                $cart->save();
            }
        }
        return view('mycart', compact('carts'));
    }
    public function destroy(Request $request, $id){
        $cart = cart::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();
        if($cart){
            $cart->delete();
            return back()->with('success', 'Cart item deleted successfully!');
        } else {
            return back()->with('success', 'Cart item not found!');
        }
    }
}
