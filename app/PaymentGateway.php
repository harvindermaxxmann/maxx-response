<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
class PaymentGateway extends Model
{
    //
    public static function gateways(){
    	$gateways = DB::table('payment_gateways')->where('status',1)->get();
    	$gateways = json_decode(json_encode($gateways),true);
    	return $gateways;
    }

    public static function existingGateways(){
    	if(Session::has('currency')){
            if(Session::get('currency') =="USD"){ //Base currency is USD
                $currency = "USD";
            }else{
                $currency = Session::get('currency');
            }
        }else{
            $currency = "USD";
        }
    	$gateways = DB::table('payment_gateways')->select('slug')->where('currencies',$currency)->where('status',1)->get();
    	$gateways = Arr::flatten(json_decode(json_encode($gateways),true));
    	return $gateways;
    }
}
