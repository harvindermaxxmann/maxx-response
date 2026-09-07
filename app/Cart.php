<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Cart;
use App\Discount;
use App\Pricing;
use App\Package;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    //
    public static function cartdetails(){
    	$response = array('status'=>'failed');
    	$cart = Cart::where('user_id',Auth::user()->id)->orderBy('id','DESC')->first();
        if($cart){
            $discount = Discount::where('value',$cart->plan)->first();
            $pricing = Pricing::calculatePrice($cart->package_id,$cart->list_size,$discount);
            if(empty($pricing['orderprice'])){
                Cart::where('user_id',Auth::user()->id)->delete();
                return $response;
            }
            $packagedetails = Package::where('id',$cart->package_id)->first();
        	$response = array('status'=>'success','cart'=>$cart,'discount'=>$discount,'pricing'=>$pricing,'packagedetails'=>$packagedetails);
        	return $response;
        }else{
        	return $response;
        }
    }
}
