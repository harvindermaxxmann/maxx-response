<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
//use App\Order;
class Order extends Model
{
    //
    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }

    public static function availFreePlan($userid){
    	$availFreePlan = "false";
    	// Chcek for ccavenue,paypal
    	$alreadysubscribe = Order::where(['payment_status'=>'Completed'])->where('payment_mode','!=','free')->where('user_id',$userid)->count();
    	if($alreadysubscribe ==0){
    		$availFreePlan = "true";
	    	//check for free plan
	    	$checkfreeplan =  Order::where('payment_mode','free')->where('user_id',$userid)->count();
	    	if($checkfreeplan ==0){
	    		$availFreePlan = "true";
	    	}else{
	    		$availFreePlan = "false";
	    	}
    	}
    	if($availFreePlan =="true"){
    		$freepackage = Package::with('listsize')->where('type','free')->where('status',1)->orderby('id','DESC')->first();
	        if($freepackage && isset($freepackage['listsize'][0]['list_size'])){
	        	if(Order::all()->count() ==0){
		            $countorder = 1000;
		        }else{
		            $countorder = Order::all()->count();
		        }
	        	$order_id = $countorder + 1;
	        	//Create Free Plan below
	            $order = new Order();
	            $order->user_id =$userid;
	            $order->invoice_id = $invoiceid = config('paypal.invoice_prefix').'_'.$order_id;
	            $order->payment_mode = "free";
	            $order->currency = "USD";
	            $order->package_id = $freepackage->id;
	            $order->list_size = $freepackage['listsize'][0]['list_size'];
	            $order->subscription = $freepackage->no_of_days;
	            $order->subscription_type = "days";
	            $order->package_name = $freepackage->package_name;
	            $order->package_price = $freepackage['listsize'][0]['price'];
	            $order->prepaid_discount = 0;
	            $order->coupon_discount = 0;
	            $order->grand_total = $freepackage['listsize'][0]['price'];
	            $order->payment_status = "Completed";
	            $order->order_status = "Active";
	            $addmonths = "+ ".$freepackage->no_of_days." days"; 
	            $order->expiry_date = date('Y-m-d',strtotime($addmonths));
	            $order->save();
	        }
    	}
    	return 'done';
    }
}
