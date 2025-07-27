<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $latestproducts = Product::latest()->take(4)->get();
        return view('welcome', compact('latestproducts'));
    }

public function viewProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('viewproduct', compact('product'));
    }
    public function categoryproducts($catid){
        $category= Category::findOrFail($catid);
        $products = Product::where('category_id', $catid)->get();
        return view('categoryproducts', compact('products','category'));
    }
    public function checkout($cartid){
        $cart=Cart::findOrFail($cartid);
        return view('checkout', compact('cart'));
    }

    public function myorder(){
        $orders=Order::where('user_id', auth()->id())->latest()->get();
        return view('myorders', compact('orders'));
    }
    public function search(Request $request){
        
        $search=$request->input('search');
        $products = Product::where('name', 'like', '%' . $search . '%')->get();
        return view('search', compact('products'));
    }
}