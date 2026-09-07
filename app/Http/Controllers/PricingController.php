<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\DB;
use Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Package;
use App\Feature;
use App\Pricing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Discount;
use App\Cart;
use App\BillingDetail;
use App\Order;
use App\PaymentGateway;
use Exception;
use Srmklive\PayPal\Services\AdaptivePayments;
use Srmklive\PayPal\Services\ExpressCheckout;
use Softon\Indipay\Facades\Indipay;  
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Support\Arr;
class PricingController extends Controller
{
    //
    public function pricing(){
    	Session::put('menuactive','pricing');
    	$packages = Package::with(['listsize'])->where('status',1)->where('type','paid')->get();
    	$packages = json_decode(json_encode($packages),true);
    	$features = Feature::features();
    	$title="Pricing";
        $discount = Discount::where('value',1)->first();
        $currrencies = DB::table('currency_codes')->where('status',1)->get();
        $currrencies = json_decode(json_encode($currrencies),true);
        Session::forget('coupon');
    	return view('front.pricing.pricing')->with(compact('title','packages','features','discount','currrencies'));
    }

    public function checkListSizePricing(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $discount = Discount::where('value',$data['plan'])->first();
            $pricingdetails = Pricing::calculatePrice($data['packageid'],$data['listsize'],$discount);
            $price = $pricingdetails['symbol']." ".number_format($pricingdetails['monthprice'],2);
            return $price;
        }
    }

    public function changePlan(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $packages = Package::with(['listsize'])->where('status',1)->where('type','paid')->get();
            $packages = json_decode(json_encode($packages),true);
            $features = Feature::features();
            $discount = Discount::where('value',$data['plan'])->first();
            return response()->json([
                'view' => (String)View::make('layouts.frontLayout.pricing-layout')->with(compact('packages','features','discount')),
            ]);
        }
    }

    public function changeCurrency(Request $request){
        if($request->isMethod('post')){
            Session::forget('coupon');
            $data = $request->all();
            if(isset($data['code'])){
                $currrencies = DB::table('currency_codes')->select('code')->where('status',1)->get();
                $currrencies = Arr::flatten(json_decode(json_encode($currrencies),true));
                if(in_array($data['code'],$currrencies)){
                    Session::put('currency',$data['code']);
                    return Redirect()->back()->with('flash_message_success','Currency has been successfully changed to '.$data['code'].".");
                }else{
                    return Redirect()->back()->with('flash_message_error','We are Sorry we have not supported this currency yet');
                }
            }else{
                return Redirect()->back();
            }
        }
    }

    public function applycoupon(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(isset($data['coupon'])){
                Session::forget('coupon');
                $coupondetails = DB::table('coupon_codes')->where('code',$data['coupon'])->where('expiry_date','>=',date('Y-m-d'))->first();
                if($coupondetails){
                    if($coupondetails->coupon_type=="Single Time"){
                        $checkuserApplied = Order::where('user_id',Auth::user()->id)->where('coupon_code',$data['coupon'])->where('payment_status','Completed')->count();
                        if($checkuserApplied ==0){
                            $apply = "yes";
                        }else{
                            $apply = "no";
                        }
                    }else{
                        $apply = "yes";
                    }
                    if($apply =="yes"){
                        $response = Cart::cartdetails();
                        Session::put('coupon',$data['coupon']);
                        $couponvalue=Pricing::calculateCouponValue();
                        if($response['status']=="success"){
                           $price =  $response['pricing']['orderprice'];
                           if($couponvalue['type']=="normal"){
                                if($price <= $couponvalue['couponvalue']){
                                    Session::forget('coupon');
                                    return redirect()->back()->with('flash_message_error','Sorry but this coupon not valid for this package.');
                                }
                           }
                        }
                    }else{
                        return redirect()->back()->with('flash_message_error','We are Sorry but you have already used this coupon code on previous transaction.');
                    }
                    return redirect()->back()->with('flash_message_success','Coupon Applied successfully. You are now availing discount');
                }else{
                    return redirect()->back()->with('flash_message_error','Invalid Coupon Code. Please try with some other coupon code');
                }
            }
        }
    }

    public function buyPackage(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'plan' => 'bail|required',
                'package' => 'bail|required',
                'listsize' => 'bail|required',
            ];
            $customMessages = [
                //Add custom messages
            ];
            $this->validate($request, $rules, $customMessages);
            $response = Package::checkValidPacakge($data);
            if($response){
                if(Session::has('cartsessionId')){
                    //Delete All cart items
                    Cart::where('session_id',Session::get('cartsessionId'))->delete();
                }else{
                    if(Auth::check()){
                        Cart::where('user_id',Auth::user()->id)->delete();
                    }else{
                        $session_id = Session::getId();
                        Session::put('cartsessionId',$session_id);
                    }
                }
                $todayDate = date('Y-m-d');
                $expiry_date = date('Y-m-d', strtotime("+7 days", strtotime($todayDate)));
                $cart = new Cart;
                $cart->session_id = (Auth::check()) ? '' : Session::get('cartsessionId');
                $cart->plan = $data['plan'];
                $cart->package_id = $data['package'];
                $cart->list_size = $data['listsize'];
                $cart->expiry_date = $expiry_date;
                if(Auth::check()){
                    $cart->user_id = Auth::user()->id;
                }
                $cart->save();
                return redirect::to('/billing');
            }else{
                return Redirect::to('/pricing')->with('flash_message_error','This package may not exists. Please choose another Package');
            }
        }
    }

    public function billing(Request $request){
        $billingDetails =array();
        $states = array();
        $cities = array();
        if(!Auth::check()){
            if(Session::has('cartsessionId')){
                $cartitems = Cart::where('session_id',Session::get('cartsessionId'));
            }else{
                return redirect::to('/pricing')->with('flash_message_error','Please select Package');
            }
        }else{
            $billingDetails = User::where('id',Auth::user()->id)->first();
            $billingDetails = json_decode(json_encode($billingDetails),true);
            if(!empty($billingDetails) && !empty($billingDetails['country'])){
                $countryid = DB::table('countries')->where('country_name',$billingDetails['country'])->select('id')->first();
                $states = DB::table('states')->where('country_id',$countryid->id)->get();
                $stateid = DB::table('states')->where('state_name',$billingDetails['state'])->first();
                $cities = DB::table('cities')->where('state_id',$stateid->id)->get();
            }
            $cartitems = Cart::where('user_id',Auth::user()->id);
        }
        $cartitems = $cartitems->count();
        if($cartitems == 0){
            return redirect::to('/pricing')->with('flash_message_error','Please select Package2');
        }
        $title = "Billing Details";
        if($request->isMethod('post')){
            $rules = [
                'company_name' => 'bail|required|string|max:255',
                'country' => 'bail|required',
                'state' => 'bail|required|string|max:50',
                'city' => 'bail|required|string|max:50',
                'zip' => 'bail|required|string|max:6',
            ];
            if(!Auth::check()){
                $rules['name'] = 'bail|required|string|max:255';
                $rules['email'] = 'bail|required|string|max:255|unique:users';
                $rules['password'] = 'bail|required|min:6|confirmed';
                $rules['password_confirmation'] = 'bail|required|min:6';
            }
            $customMessages = [
                //Add custom messages
            ];
            $this->validate($request, $rules, $customMessages);
            $data = $request->all();
           /* echo "<pre>"; print_r($data); die;*/
            if(!Auth::check()){
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;
                $user->save();
                $userid = DB::getPdo()->lastInsertId();
                if($this->mode =="live"){
                    $email = $data['email'];
                    $userdetails = $data;
                    $messageData = [
                        'userdetails' => $userdetails,
                    ];
                    Mail::send('emails.signup-email', $messageData, function($message) use ($email){
                        $message->to($email)->subject('Registration with maxx Response');
                    });
                }
            }else{
                $userid = Auth::user()->id;
            }
            $billing = User::find($userid);
            $billing->company_name = $data['company_name'];
            $billing->country = $data['country'];
            $billing->state = $data['state'];
            $billing->zip = $data['zip'];
            $billing->city = $data['city'];
            $billing->address = $data['address'];
            $billing->save();
            if(!Auth::check()){
                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    Cart::where('session_id',Session::get('cartsessionId'))->update(['user_id'=> Auth::user()->id,'session_id'=>'']);
                    Session::forget('cartsessionId');
                }
            }
            return redirect()->action([PricingController::class, 'orderReview']);
        }
        $countries = DB::table('countries')->where('status',1)->get();
        return view('front.pricing.billing')->with(compact('title','countries','billingDetails','states','cities'));
    }

    public function orderReview(){
        $response = Cart::cartdetails();
        if($response['status']=='failed'){
            return redirect::to('/pricing')->with('flash_message_error','Please select Package');
        }else{
            $pricing = $response['pricing'];
            $cart = $response['cart'];
            $packagedetails = $response['packagedetails'];
            $getdiscount = $response['discount'];
        }
        $title = "Review Order";
        return view('front.pricing.order-review')->with(compact('title','packagedetails','pricing','cart','getdiscount'));
    }

    public function changePaymentgateway(Request $request){
        if($request->ajax()){
            $data = $request->all();
            Session::forget('currency');
            $gatewaydetails = PaymentGateway::where('slug',$data['slug'])->first();
            Session::put('currency',$gatewaydetails->currencies);
            $response = Cart::cartdetails();
            if($response['status']=='failed'){
                return 'failed';
            }else{
                $pricing = $response['pricing'];
                $cart = $response['cart'];
                $packagedetails = $response['packagedetails'];
                $getdiscount = $response['discount'];
            }
            $title="Order Summary";
            return view('layouts.frontLayout.order-summary')->with(compact('title','packagedetails','pricing','cart','getdiscount'));
        }
    }

    public function makePayment(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $cartresponse = Cart::cartdetails();
            if($cartresponse['status']=='failed'){
                return redirect::to('/pricing')->with('flash_message_error','Please select Package');
            }else{
                $price = $cartresponse['pricing']['orderprice'];
                $packagename = $cartresponse['packagedetails']['package_name'];
                if(isset($data['payment'])){
                    $availableGateways = PaymentGateway::existingGateways();
                    if(in_array($data['payment'],$availableGateways)){
                        if($data['payment'] =="paypal"){
                            //Redirect to Paypal Gateway
                            $cart = $this->getCheckoutData('paypal',$price,$packagename);
                            $recurring = ($request->get('mode') === 'recurring') ? true : false;
                            $response = $this->provider->setExpressCheckout($cart, $recurring);
                            return redirect($response['paypal_link']);
                        }elseif($data['payment'] =="authorize.net"){
                            $parameters = $this->getCheckoutData('authorize.net',$price,$packagename);
                            if(Session::has('currency')){
                                $currency = Session::get('currency');
                            }else{
                                $currency = 'USD';
                            }
                            $cart =$parameters['cart']; 
                            $order = $this->createOrder($currency,'authorize.net',$cart,'Cancelled',$cartresponse);
                            return redirect::to('complete-purchase?orderId='.$order->id);
                        }elseif ($data['payment'] =="ccavenue") {
                            //Redirect to CCavenue Gateway
                            $parameters = $this->getCheckoutData('ccavenue',$price,$packagename);
                            $order = Indipay::gateway('CCAvenue')->prepare($parameters['parameters']);
                            if(Session::has('currency')){
                                $currency = Session::get('currency');
                            }else{
                                $currency = 'USD';
                            }
                            $cart =$parameters['cart']; 
                            $this->createOrder($currency,'ccavenue',$cart,'Cancelled',$cartresponse);
                            return Indipay::process($order);
                        }else{
                            return redirect()->back()->with('flash_message_error','This Payment gateway will be cming soon. Please chhoose another one');
                        }
                    }else{
                        return redirect()->back()->with('flash_message_error','We are Sorry!. We have not supported this Payment gateway yet.');
                    }
                }else{
                    return redirect()->back()->with('flash_message_error','Please Select Payment Method');
                }
            }
        }
    }

    protected function getCheckoutData($type,$price,$packagename){
        $data = [];
        if(Order::all()->count() ==0){
            $countorder = 1000;
        }else{
            $countorder = Order::all()->count();
        }
        $order_id = $countorder + 1;
        if($type=="paypal"){
            $data['items'] = [
                [
                    'name'  => "$packagename",
                    'price' => $price,
                    'qty'   => 1,
                ],
            ];
            $data['return_url'] = url('/checkout-success');
            $data['invoice_id'] = config('paypal.invoice_prefix').'_'.$order_id;
            $data['invoice_description'] = "Order #$order_id Invoice";
            $data['cancel_url'] = url('/cancel-order');

            $total = 0;
            foreach ($data['items'] as $item) {
                $total += $item['price'] * $item['qty'];
            }
            $data['total'] = $total;
            return $data;
        }elseif($type=="ccavenue" || $type=="authorize.net" ){
            $transactionid = rand(9999,10000).time();
            $invoiceid = config('paypal.invoice_prefix').'_'.$order_id;
            $billingdetails = User::where('id',Auth::user()->id)->first();
            $billingdetails = json_decode(json_encode($billingdetails),true);
            $parameters = [
                'tid' => $transactionid,
                'order_id' => $invoiceid,
                'amount' => $price,
                'billing_name'=>$billingdetails['company_name'],
                'billing_address' =>$billingdetails['address'],
                'billing_state' =>$billingdetails['state'],
                'billing_country' =>$billingdetails['country'],
                'billing_city' =>$billingdetails['city'],
                'billing_zip' =>$billingdetails['zip'],
                'billing_email' => Auth::user()->email
            ];
            $cart = array();
            $cart['invoice_id'] = $invoiceid;
            $cart['total'] = $price;
            $data = array('parameters'=>$parameters,'cart'=>$cart);
            return $data;
        }
    }

    public function ccavenueresponse(Request $request){
        $response = Indipay::response($request);
        $response = Indipay::gateway('CCAvenue')->response($request);
        /*if($this->mode=="live"){
            $status = "Results: " . print_r($response,true);
            mail('mkanum786@gmail.com','Test',$status,'From: smtpmail@maxxmannsupport.com');
        }*/
        if($response['order_status'] =="Success"){
            Session::put('invoiceid',$response['order_id']);
            $orderdetails = Order::where('invoice_id',$response['order_id'])->select('id','subscription')->first();
            $addmonths = "+ ".$orderdetails->subscription." months";
            $updateorder = Order::find($orderdetails->id);
            $updateorder->transaction_id =$response['tracking_id'];
            $updateorder->order_status = 'Active';
            $updateorder->payment_status ='Completed';
            $updateorder->expiry_date =date('Y-m-d',strtotime($addmonths));
            $updateorder->company_name =$response['billing_name'];
            $updateorder->address =$response['billing_address'];
            $updateorder->city =$response['billing_city'];
            $updateorder->state =$response['billing_state'];
            $updateorder->zip =$response['billing_zip'];
            $updateorder->country =$response['billing_country'];
            $updateorder->phone =$response['billing_tel'];
            $updateorder->save();
            $this->sendOrderEmail($response['order_id']);
            return redirect('/thanks');
        }else{
            return redirect('/cancel-order');
        }
    } 

    public function getExpressCheckoutSuccess(Request $request){
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');
        $cartresponse = Cart::cartdetails();
        if($cartresponse['status']=='failed'){
            return redirect::to('/pricing')->with('flash_message_error','Please select Package');
        }else{
            $price = $cartresponse['pricing']['orderprice'];
            $packagename = $cartresponse['packagedetails']['package_name'];
        }
        $cart = $this->getCheckoutData('paypal',$price,$packagename);
        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            // Perform transaction on PayPal
            $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
            $transactionid = $payment_status['PAYMENTINFO_0_TRANSACTIONID'];
            if(Session::has('currency')){
                $currency = Session::get('currency');
            }else{
                $currency = 'USD';
            }
            $order = $this->createOrder($currency,'paypal',$cart, $status,$cartresponse,$transactionid);
            if($order->payment_status =="Completed") {
                Cart::where('user_id',Auth::user()->id)->delete();
                Session::forget('coupon');
                Session::put('invoiceid',$order->invoice_id);
                return redirect('/thanks');
            }else{
                return redirect('/cancel-order');
            }
        }
    }

    protected function createOrder($currency,$type,$cart, $status,$cartresponse,$transactionid=null){
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->invoice_id = $cart['invoice_id'];
        $order->payment_mode = $type;
        if(!empty($transactionid)){
            $order->transaction_id = $transactionid;
        }
        $order->currency = $currency;
        $order->package_id = $cartresponse['cart']['package_id'];
        $order->list_size = $cartresponse['cart']['list_size'];
        $order->subscription = $cartresponse['cart']['plan'];
        $order->subscription_type = "months";
        $order->package_name = $cartresponse['packagedetails']['package_name'];
        $order->package_price = $cartresponse['pricing']['mrp'];
        $order->prepaid_discount = $cartresponse['pricing']['prepaid'];
        $order->coupon_discount = $cartresponse['pricing']['coupondiscount'];
        $order->grand_total = $cart['total'];
        if(Session::has('coupon')){
            $order->coupon_code = Session::get('coupon');
        }
        if(!strcasecmp($status, 'Completed') || !strcasecmp($status, 'Processed')) {
            $order->payment_status = "Completed";
            $order->order_status = "Active";
            $addmonths = "+ ".$cartresponse['discount']['value']." months"; 
            $order->expiry_date = date('Y-m-d',strtotime($addmonths));
        } else {
            $order->payment_status = "Cancelled";
            $order->order_status = "Inactive";
        }
        $billingdetails = User::where('id',Auth::user()->id)->first();
        $billingdetails = json_decode(json_encode($billingdetails),true);
        if($billingdetails){
            $order->company_name = $billingdetails['company_name'];
            $order->country = $billingdetails['country'];
            $order->state = $billingdetails['state'];
            $order->zip = $billingdetails['zip'];
            $order->city = $billingdetails['city'];
            $order->address = $billingdetails['address'];
        }
        $order->save();
        if($type=="paypal"){
            $this->sendOrderEmail($order->invoice_id);
        }
        return $order;
    }

    Public function completeauthorizeNet(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $next10years = date('Y')+10;
            $yearsString ="";
            for ($year=date('Y'); $year<=$next10years; $year++){
                $yearsString .= $year.",";
            }
            $availableYears = rtrim($yearsString, ',');
            $rules = [
                'order_id' => 'bail|required',
                'card_number' => 'bail|required|digits_between:13,16',
                'card_expiry_month' => 'bail|required|in:1,2,3,4,5,6,7,8,9,10,11,12',
                'card_expiry_year' => 'bail|required|in:'.$availableYears,
                'cvv' => 'bail|required|digits:3',
            ];
            $customMessages = [
                //Add custom messages
            ];
            $this->validate($request, $rules, $customMessages);
            //Check Valid Orderid for logged in user
            $orderDetails = Order::where(['user_id'=>Auth::user()->id,'id'=>$data['order_id']])->where('payment_status','Cancelled')->first();
            if($orderDetails){
                //Merchant Authenticaion
                $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                $merchantAuthentication->setName(config('services.authorize.login'));
                $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
                // Set the transaction's refId
                $refId = 'ref'.time();
                // Create the payment data for a credit card
                $creditCard = new AnetAPI\CreditCardType();
                $creditCard->setCardNumber($request->card_number);
                // $creditCard->setExpirationDate( "2038-12");
                $expiry = $request->card_expiry_year . '-' . $request->card_expiry_month;
                $creditCard->setExpirationDate($expiry);
                $creditCard->setCardCode($request->cvv);
                $paymentOne = new AnetAPI\PaymentType();
                $paymentOne->setCreditCard($creditCard);

                // Create order information
                $order = new AnetAPI\OrderType();
                $order->setInvoiceNumber($orderDetails->id);
                $order->setDescription($orderDetails->package_name);
                // Set the customer's Bill To address
                $customerAddress = new AnetAPI\CustomerAddressType();
                $customerAddress->setFirstName(Auth::user()->name);
                $customerAddress->setCompany($orderDetails->company_name);
                $customerAddress->setAddress($orderDetails->address);
                $customerAddress->setCity($orderDetails->city);
                $customerAddress->setState($orderDetails->state);
                $customerAddress->setZip($orderDetails->zip);
                $customerAddress->setCountry($orderDetails->country);

                // Set the customer's identifying information
                $customerData = new AnetAPI\CustomerDataType();
                $customerData->setType("individual");
                $customerData->setId($orderDetails->user_id);
                $customerData->setEmail(Auth::user()->email);

                // Add values for transaction settings
                $duplicateWindowSetting = new AnetAPI\SettingType();
                $duplicateWindowSetting->setSettingName("duplicateWindow");
                $duplicateWindowSetting->setSettingValue("60");

                // Create a TransactionRequestType object and add the previous objects to it
                $transactionRequestType = new AnetAPI\TransactionRequestType();
                $transactionRequestType->setTransactionType("authCaptureTransaction");
                $transactionRequestType->setAmount(round($orderDetails->grand_total));
                $transactionRequestType->setOrder($order);
                $transactionRequestType->setPayment($paymentOne);
                $transactionRequestType->setBillTo($customerAddress);
                $transactionRequestType->setCustomer($customerData);
                $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);

                // Assemble the complete transaction request
                $request = new AnetAPI\CreateTransactionRequest();
                $request->setMerchantAuthentication($merchantAuthentication);
                $request->setRefId($refId);
                $request->setTransactionRequest($transactionRequestType);
                // Create the controller and get the response
                $controller = new AnetController\CreateTransactionController($request);
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                if ($response != null){
                    $tresponse = $response->getTransactionResponse();
                    if (($tresponse != null) && ($tresponse->getResponseCode()=="1")){
                        Session::put('invoiceid',$orderDetails->invoice_id);
                        $addmonths = "+ ".$orderDetails->subscription." months";
                        $updateorder = Order::find($orderDetails->id);
                        $updateorder->transaction_id = $tresponse->getTransId();
                        $updateorder->order_status = 'Active';
                        $updateorder->payment_status ='Completed';
                        $updateorder->auth_code =$tresponse->getAuthCode();
                        $updateorder->message_code =$tresponse->getMessages()[0]->getCode();
                        $updateorder->transaction_description =$tresponse->getMessages()[0]->getDescription();
                        $updateorder->expiry_date =date('Y-m-d',strtotime($addmonths));
                        $updateorder->save();
                        $this->sendOrderEmail($orderDetails->invoice_id);
                        return redirect('/thanks');
                    }else{
                        $updateorder = Order::find($orderDetails->id);
                        $updateorder->message_code =$tresponse->getErrors()[0]->getErrorCode();
                        $updateorder->transaction_description =$tresponse->getErrors()[0]->getErrorText();
                        $updateorder->save();
                        return redirect('/cancel-order');
                    }     
                }else{
                    return redirect('/cancel-order');
                }
            }else{
                return redirect::to('/');
            }
        }
        $title="Complete Purchase";
        return view('front.pricing.complete-purchase')->with(compact('title'));
    }


    public function sendOrderEmail($invoiceid){
        $orderdetails = Order::with('user')->where('invoice_id',$invoiceid)->first();
        $orderdetails =json_decode(json_encode($orderdetails),true);
        $email = $orderdetails['user']['email'];
        if($this->mode =="live"){
            $messageData = [
                'orderdetails' => $orderdetails,
            ];
            Mail::send('emails.order-success-email', $messageData, function($message) use ($email){
                $message->to($email)->subject('Order Placed Successfully');
            });
        }
    }

    public function thanks(){
        if(Session::has('invoiceid')){
            Cart::where('user_id',Auth::user()->id)->delete();
            $title="Thank You";
            return view('front.pricing.thanks')->with(compact('title'));
        }else{
            return redirect('/');
        }
    }

    public function cancelOrder(Request $request){
        $title="Order Cancelled";
        return view('front.pricing.cancel')->with(compact('title'));
    }

    public function notify(Request $request){
        if (!($this->provider instanceof ExpressCheckout)) {
            $this->provider = new ExpressCheckout();
        }

        $post = [
            'cmd' => '_notify-validate',
        ];
        $data = $request->all();
        foreach ($data as $key => $value) {
            $post[$key] = $value;
        }

        $response = (string) $this->provider->verifyIPN($post);

        $ipn = new IPNStatus();
        $ipn->payload = json_encode($post);
        $ipn->status = $response;
        $ipn->save();
    }

    public function getstates(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $countryid = DB::table('countries')->where('country_name',$data['country'])->select('id')->first();
            $states = DB::table('states')->where('country_id',$countryid->id)->get();
            $appendstates ='<option value="">Select State</option>';
            foreach($states as $state){
                $appendstates .= '<option value="'.$state->state_name.'">'.$state->state_name.'</option>';
            }
            return $appendstates;
        }
    }

    public function getcities(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $stateid = DB::table('states')->where('state_name',$data['state'])->select('id')->first();
            $cities = DB::table('cities')->where('state_id',$stateid->id)->get();
            $appendcities ='<option value="">Select City</option>';
            foreach($cities as $city){
                $appendcities .= '<option value="'.$city->city_name.'">'.$city->city_name.'</option>';
            }
            return $appendcities;
        }
    }

    public function updateExchangeRates(){
        $req_url = 'http://www.apilayer.net/api/live?access_key=b90d7a81feca7532d931bfeb1d80dbc9&format=1';
        $response_json = file_get_contents($req_url);
        // Continuing if we got a result
        if(false !== $response_json) {
            // Try/catch for json_decode operation
            try {
                // Decoding
                $response_object = json_decode($response_json);

                $exchangeRates = DB::table('exchange_rates')->get();
                foreach($exchangeRates as $currencycode){
                    $key = "USD".$currencycode->currency_code_to;
                    $rate = round($response_object->quotes->$key,2);
                    DB::table('exchange_rates')->where('id',$currencycode->id)->update(['rate'=>$rate]);
                }
            }
            catch(Exception $e) {
                // Handle JSON parse error...
            }
        }
        echo "rates updated successfully"; die;
    }
}
