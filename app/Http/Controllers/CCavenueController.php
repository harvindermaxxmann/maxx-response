<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Softon\Indipay\Facades\Indipay;  
class CCavenueController extends Controller
{
    //

    public function ccavenue(){
    	$parameters = [
      
        'tid' => '1233dd221223322',
        
        'order_id' => '123221244525',
        
        'amount' => '1200.00',
        
      ];
      // gateway = CCAvenue / PayUMoney / EBS / Citrus / InstaMojo / ZapakPay / Mocker
      $order = Indipay::gateway('CCAvenue')->prepare($parameters);
      //echo "<pre>"; print_r($order); die;
      return Indipay::process($order);
    }

    public function indipayresponse(Request $request){
        // For default Gateway
        $response = Indipay::response($request);
        // For Otherthan Default Gateway
        $response = Indipay::gateway('CCAvenue')->response($request);

        echo '<pre>'; print_r($response); die;
    
    } 
}
