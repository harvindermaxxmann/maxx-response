<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\PackageListSize;
class Pricing extends Model
{
    //
    public static function  calculatePrice($packageid,$listsize,$discount){
        $details = PackageListSize::where(['package_id'=>$packageid,'list_size'=>$listsize])->first();
        if($details){
            if(Session::has('currency')){
                if(Session::get('currency') =="USD"){ //Base currency is USD
                    $basecurrency = "yes";
                }else{
                    $basecurrency = "no";
                }
            }else{
                $basecurrency = "yes";
            }
            if($basecurrency =="yes"){
                $coupondetails = Pricing::calculateCouponValue();
                $mrpprice = $details->price * $discount['value'];
                $monthlyprice = $details->price - ($details->price * $discount['discount']/100);
                if($coupondetails['type']=="percentage"){
                    $coupondiscount = ($mrpprice * $coupondetails['couponvalue']/100);
                    $orderprice = $mrpprice - ($mrpprice * $discount['discount']/100) - $coupondiscount;
                }else{
                    $coupondiscount = $coupondetails['couponvalue'];
                    $orderprice = $mrpprice - ($mrpprice * $discount['discount']/100) - $coupondiscount;
                }
                $orderPrepaidDiscount = (($mrpprice  * $discount['discount'])/100);
                $priceArray = array('mrp'=>$mrpprice,'monthprice'=>$monthlyprice,'orderprice'=> $orderprice,'prepaid'=>$orderPrepaidDiscount,'coupondiscount'=>$coupondiscount,'symbol'=>'$');
            }else{
                $exchangeRate = DB::table('exchange_rates')->where(['currency_code_to'=>Session::get('currency')])->first();
                if($exchangeRate){
                    $coupondetails = Pricing::calculateCouponValue();
                    $currencysymbol = DB::table('currency_codes')->where('code',Session::get('currency'))->first();
                    $convertbaseprice =  $details->price * $exchangeRate->rate;
                    $mrpprice = $convertbaseprice * $discount['value'];
                    $monthlyprice = ($convertbaseprice) - ($convertbaseprice * $discount['discount']/100);
                    if($coupondetails['type']=="percentage"){
                        $coupondiscount = ($mrpprice * $coupondetails['couponvalue']/100);
                        $orderprice = $mrpprice - ($mrpprice * $discount['discount']/100) - $coupondiscount;
                    }else{
                        $coupondiscount = $coupondetails['couponvalue'];
                        $orderprice = $mrpprice - ($mrpprice * $discount['discount']/100) - $coupondiscount;
                    }
                    $orderPrepaidDiscount = (($mrpprice   * $discount['discount'])/100);
                    $priceArray = array('mrp'=>$mrpprice,'monthprice'=>$monthlyprice,'orderprice'=> $orderprice,'prepaid'=>$orderPrepaidDiscount,'coupondiscount'=>$coupondiscount,'symbol'=>$currencysymbol->symbol);
                }else{
                    $priceArray = array('monthprice'=>'','symbol'=>'','prepaid' =>'');
                }
            }
        }else{
            $priceArray = array('monthprice'=>'','symbol'=>'','prepaid' =>'');
        }
        return $priceArray;
    } 

    public static function calculateCouponValue(){
        if(Session::has('coupon')){
            $couponexits = CouponCode::where('code',Session::get('coupon'))->first();
            if($couponexits){
                if($couponexits->amount_type=="Percentage"){
                    $type="percentage";
                    $couponvalue = $couponexits->amount;
                }else{
                    $type="normal";
                    if(Session::has('currency')){
                        if(Session::get('currency') =="USD"){ //Base currency is USD
                            $basecurrency = "yes";
                        }else{
                            $basecurrency = "no";
                        }
                    }else{
                        $basecurrency = "yes";
                    }
                    if($basecurrency=="yes"){
                        $couponvalue = $couponexits->amount;
                    }else{
                        $exchangeRate = DB::table('exchange_rates')->where(['currency_code_to'=>Session::get('currency')])->first();
                        if($exchangeRate){
                            $currencysymbol = DB::table('currency_codes')->where('code',Session::get('currency'))->first();
                            $couponvalue =  $couponexits->amount * $exchangeRate->rate;
                        }
                    }
                }
            }else{
                Session::forget('coupon');
                $type="normal";
                $couponvalue = 0;
            }
        }else{
            Session::forget('coupon');
            $type="normal";
            $couponvalue = 0;
        }
        return array('type'=>$type,'couponvalue'=>$couponvalue);
    } 
}
