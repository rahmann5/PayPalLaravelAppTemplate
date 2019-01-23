<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Basket;
use DB;

class CheckoutController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    function checkout(){
    	$title = "Checkout";
        $basket = Basket::where('user_id',auth()->user()->id)->get();
        $results = array();
        foreach($basket as $b){
            $results[] = $b->product_id;
        }
    	return view('checkout')
                                ->with("title", $title)
                                ->with('items',Product::find($results))
                                ->with("basket", $basket);
    }
    function removeItem(Request $request, $id){
    	$validator = \Validator::make(array_merge(
            [
              'id'=>$id
            ], 
            $request->all()
        ), [
            "id" => 'required|numeric|exists:products,id'
        ])->validate();
		$basket = Basket::where('user_id',auth()->user()->id)->get();
        $removed = false;
        $newBasket = array();
        foreach($basket as $b){
            if($b->product_id != $id || $removed==true)
                $newBasket[]=array('user_id'=>auth()->user()->id,'product_id'=>$b->product_id);
            else 
                $removed = true;
        }
        Basket::where('user_id',auth()->user()->id)->delete();
        DB::table('basket')->insert($newBasket);
    	return redirect("checkout");
    }
}
