<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Invoice Details</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('invoice/bootstrap.min.css')}}" >
        <link rel="stylesheet" href="{{ asset('invoice/customstyle.css')}}">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css' integrity='sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/' crossorigin='anonymous'>
    </head>
    <?php use App\User;
        $currency = User::convertcurrencySymbol($orderDetails['currency']);?>
    <body>
        <!-- main div -->
        <div class="main_div">
            <div class="container">
                <div class="row mob_view">
                    <!-- left side -->
                    <div class="col-xs-12 col-sm-4 col-md-4 leftmb">
                        <p class="text-center"><a href="javascript:;" class="logo"><img src="{{asset('images/logo.png')}}" alt="logo" class="img-fluid" /></a></p>
                        <div class="col-xs-12 col-md-12 p-0">
                            <p class="mb-0 mt-5">Invoice To</p>
                            <h2>{{$orderDetails['company_name']}}</h2>
                            <hr class="divider">
                            <p class="linhei-28">{{$orderDetails['address']}}<br/>
                                {{$orderDetails['country']}},{{$orderDetails['state']}},{{$orderDetails['city']}}<br/>
                                @if(!empty($orderDetails['phone']))
                                    <strong>Phone No: </strong> {{$orderDetails['phone']}}<br/>
                                @endif
                                <strong>Email: </strong>{{Auth::user()->email}}<br/>
                                <!-- <strong>Account ID:</strong> <span class="actid">1245356150030</span><a href="javascript:;" class="shoacc">Show</a> -->
                            </p>
                            <hr class="divider mt-4">
                            <p><strong>Invoice Details</strong></p>
                            <div>
                                <p class="mb-0"><strong>Order Date:</strong></p>
                                <p>{{date('d F Y',strtotime($orderDetails['created_at']))}}</p>
                            </div>
                            <div>
                                <p class="mb-0"><strong>Order No:</strong></p>
                                <p>{{$orderDetails['id']}}</p>
                            </div>
                            <div>
                                <p class="mb-0 mt-3"><strong>Invoice No:</strong></p>
                                <p>{{$orderDetails['invoice_id']}}</p>
                            </div>
                            @if($orderDetails['payment_status'] =="Completed")
                                <div>
                                    <p class="mb-0"><strong>Expiry Date:</strong></p>
                                    <p>{{date('d F Y',strtotime($orderDetails['expiry_date']))}}</p>
                                </div>
                            @endif
                            <div>
                                <p class="mb-0"><strong>Invoice Currency:</strong></p>
                                <p>{{$orderDetails['currency']}}</p>
                            </div>
                        </div>
                        <!-- payment method -->		
                        <div class="col-xs-12 col-md-12 p-0 mt-4">
                            <hr class="divider">
                            <div>
                                <p class="mb-0 mt-4"><strong>Payment Status: {{$orderDetails['payment_status']}}</strong></p>
                            </div>
                            <div>
                                <p class="mb-0 mt-4"><strong>Payment Method: 
                                @if($orderDetails['payment_mode'] =="ccavenue")
                                    CCAvenue
                                @else
                                    {{ucwords($orderDetails['payment_mode'])}}
                                @endif
                                </strong></p>
                            </div>
                        </div>
                        <!-- payment method close-->	
                        <!-- total -->		
                        <div class="col-xs-12 col-md-12 p-0 mt-4">
                            <div>
                                <p class="mb-0"><strong>Grand Total: {{$currency}} {{number_format($orderDetails['grand_total'],2)}}</strong></p>
                                <h4></h4>
                            </div>
                        </div>
                        <!-- total close-->	
                    </div>
                    <!-- left side end-->
                    <!-- right side -->	
                    <div class="col-xs-12 col-sm-8 col-md-8 rightmb">
                        <h1>INVOICE &nbsp;<a id="printInvoice" href="javascript:;" class="btn btn-dark mr-1 float-right mt-3">Print</a></h1>
                        <div class="col-xs-12 col-md-12 p-0 invoictable table-responsive mt-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Package Name</th>
                                        <th>List Size</th>
                                        <th>Subscription</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bord_topnone">{{$orderDetails['company_name']}}</td>
                                        <td class="bord_topnone">{{$orderDetails['package_name']}}</td>
                                        <td class="bord_topnone">{{$orderDetails['list_size']}}</td>
                                        <td class="bord_topnone">
                                        @if($orderDetails['subscription'] ==1)
                                            1 month
                                        @else
                                        {{$orderDetails['subscription']}} {{$orderDetails['subscription_type']}}
                                        @endif</td>
                                        <td class="bord_topnone text-right"><strong>{{$currency}} {{number_format($orderDetails['package_price'],2)}}</strong></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <!-- <tr>
                                        <td colspan="3" class="text-left">HSN/SAC</td>
                                        <td class="text-left">998222</td>
                                        <td class="text-right">&nbsp;</td>
                                    </tr> -->
                                    <tr>
                                        <td colspan="4" class="text-left">
                                            <h4 class="mb-0 mt-1">Sub Total</h4>
                                            <!-- <p class="mb-0 mt-1">Tax (GST) </p> -->
                                        </td>
                                        <!-- <td>
                                            <h4 class="mb-0 mt-1">&nbsp;</h4>
                                            <p class="mb-0 mt-1">18%</p>
                                        </td> -->
                                        <td class="text-right">
                                            <h4 class="mb-0 mt-1">{{$currency}} {{number_format($orderDetails['package_price'],2)}}</h4>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-left">
                                            <h4 class="mb-0 mt-1">Prepaid Discount (-)</h4>
                                        </td>
                                        <td class="text-right">
                                            <h4 class="mb-0 mt-1">{{$currency}}{{number_format($orderDetails['prepaid_discount'],2)}}</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-left">
                                            <h4 class="mb-0 mt-1">Coupon Discount (-)</h4>
                                        </td>
                                        <td class="text-right">
                                            <h4 class="mb-0 mt-1">{{$currency}}{{number_format($orderDetails['coupon_discount'],2)}}</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-left">
                                            <h4 class="mb-0 mt-1">Total</h4>
                                        </td>
                                        <td colspan="2" class="text-right">
                                            <h4 class="mb-0 mt-1">{{$currency}}&nbsp;{{number_format($orderDetails['grand_total'],2)}}</h4>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-md-12 p-0 mt-5">
                        <p>Disclaimer: Invoice was generated digitally and is valid without the signature and seal.</p>
                            <!-- <p class="pt-5 pintx">I confirm I have read and agree the <label>Terms and Conditions of services &nbsp;<input type="checkbox" name="terms" /><span data-toggle="tooltip" data-placement="top" title="Selection will print alongwith invoice">print</span></label> and <label> Data Privacy Policy &nbsp;<input type="checkbox" name="terms" /><span  data-toggle="tooltip" data-placement="top" title="Selection will print alongwith invoice">print</span></label>. </p> -->
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-md-12 p-0 mt-5">
                            <h5 class="mt-5 pt-5">THANK YOU</h5>
                            <p class="mt-3"><strong>Phone Number</strong> : +91 - 99999 88888<br/>
                                <strong>Website</strong> : www.maxxmann.com<br/>
                                <strong>Email </strong>  : sales@maxxmann.com<br/>
                                <strong>Address</strong> : SCO 341-342, Near Helix Institute, Sector 34-A, Chandigarh, 160022
                            </p>
                        </div>
                    </div>
                    <!-- right side end-->	
                </div>
                <!-- row close -->
            </div>
            <!-- container end-->  
        </div>
        <!-- main div end-->
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="{{ asset('invoice/jqueryliberary.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="{{ asset('invoice/bootstrap.min.js')}}" ></script>
        <script>
            $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            })
            $('#printInvoice').click(function(){
                window.print();
            });   
        </script>
    </body>
</html>