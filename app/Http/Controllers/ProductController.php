<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ProductController extends Controller
{
    public function index(){
       $products= Product::orderBy('datetime_submitted','desc')->get();
        return view('product.index' ,compact('products'));
    }

    public function add(){
        return view('product.add');
    }

    public function store(Request $request){
        $input=$request->all();
        // echo "<pre>";print_r($input);exit;
        $request->validate([
            'productName' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $products= new Product;
        $products->product_name=ucfirst($input['productName']);
        $products->quantity=$input['quantity'];
        $products->price=$input['price'];
        $products->datetime_submitted=Carbon::now();
        $products->save();
        return response()->json(['status' => 'success']);

    }
    
    public function getDataForTable() {
        $products = Product::orderBy('datetime_submitted', 'desc')->get();
        return response()->json(['products' => $products]);
    }
}
