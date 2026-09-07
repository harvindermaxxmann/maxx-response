<h5>Order Summary:</h5>
<div class="row mar_top20">
    <div class="col-xs-12 col-md-4 text-left">
        <div class="lftboxx">
            <h5>Package:</h5>
            <h2>{{$packagedetails->package_name}}</h2>
            <h5>{{$cart->list_size}}<br/><small>Contacts</small></h5>
        </div>
    </div>
    <div class="col-xs-12 col-md-8">
        <h5 class="mar_top20">Billed:</h5>
        <div class="row minxt mar_top20">
            <div class="col-xs-6 col-md-6">
                <p>{{$getdiscount['description']}}</p>
            </div>
            <div class="col-xs-6 col-md-6 text-right">
                <p>{{$pricing['symbol']}}{{number_format($pricing['mrp'],2)}}</p>
            </div>
        </div>
        <div class="row minxt mar_top20">
            <div class="col-xs-6 col-md-6">
                <p>Prepaid Discount (-)</p>
            </div>
            <div class="col-xs-6 col-md-6 text-right">
                <p>{{$pricing['symbol']}}{{number_format($pricing['prepaid'],2)}}</p>
            </div>
        </div>
        <div class="row minxt mar_top20">
            <div class="col-xs-6 col-md-6">
                <p>Coupon Discount (-)</p>
            </div>
            <div class="col-xs-6 col-md-6 text-right">
                <p>{{$pricing['symbol']}}{{number_format($pricing['coupondiscount'],2)}}</p>
            </div>
        </div>
        <div class="row totalx mar_top20">
            <div class="col-xs-6 col-md-6">
                <p>Total</p>
            </div>
            <div class="col-xs-6 col-md-6 text-right">
                <p>{{$pricing['symbol']}}{{number_format($pricing['orderprice'],2)}}</p>
            </div>
        </div>
    </div>
</div>