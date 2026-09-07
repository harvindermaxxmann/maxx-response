@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\PaymentGateway; ?>
<section class="page-section padlowtopbot" style="padding-bottom:30px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="title-section"><span class="title-regular">Order Summary</span></h1>
               <p class="lead">You are just one step away make payment and enjoy MaxxResponse Services.</p>
            </div>
        </div>
        
    </div>
</section>
<section class="page-section padlowtopbot" style="padding-top:0px;">
    <div class="container">		
        <div class="apply_coupon">
            <form action="{{url('/apply-coupon')}}" method="post" autocomplete="off" class="form-inline">@csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="coupon" value="{{Session::get('coupon')}}" placeholder="Apply Coupon">
                    <button type="submit" class="btn btn-primary">Apply Coupon</button>
                </div>
            </form>
        </div>
        <!-- Order summary -->  
        <div class="col-md-12 backg_sec payMoptin">
            @if(Session::has('flash_message_error'))
                <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
            @endif
            <div id="AppendOrderReview">
                @include('layouts.frontLayout.order-summary')
            </div>
        </div>
        <!-- Payment Info-->
        <form id="PaymentForm" action="{{url('/make-payment')}}" method="post">@csrf
            <div class="col-md-12 backg_sec payMoptin">
                <h5>Payment Method:</h5>
                <div class="row mar_top20">
                    <?php $gateways = PaymentGateway::gateways(); ?>
                    @foreach($gateways as $gateway)
                        <div class="col-xs-4 col-sm-3 col-md-2 nopad text-center">
                            <label class="image-radio">
                                <img class="img-responsive" src="{{ asset('images/'.$gateway['image'])}}" />
                                <input type="radio" name="payment" value="{{$gateway['slug']}}"/>
                                <i class="glyphicon glyphicon-ok hidden"></i>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="text-center">
                <button id="PayNow" type="button" class="btn btn-primary">Pay Now</button>
            </p>
        </form>
    </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click','#PayNow',function(){
        if($("input:radio[name='payment']").is(":checked")) {
            $('#checkoutLoader').fadeIn().delay(20000).fadeOut();
            $('#PaymentForm').submit();
        }else{
            alert('Please Select Payment Method');
        }
    })

    // add/remove checked class
    $(".image-radio").each(function(){
        if($(this).find('input[type="radio"]').first().attr("checked")){
            $(this).addClass('image-radio-checked');
        }else{
            $(this).removeClass('image-radio-checked');
        }
    });

    // sync the input state
    $(".image-radio").on("click", function(e){
        $(".image-radio").removeClass('image-radio-checked');
        $(this).addClass('image-radio-checked');
        var $radio = $(this).find('input[type="radio"]');
        $radio.prop("checked",!$radio.prop("checked"));
        if($("input:radio[name='payment']").is(":checked")){
            $('.loadingDiv').show();
            var gateway = $("input[name='payment']:checked").val();
            $.ajax({
                data : {slug: gateway},
                url : '/change-payment-gateway',
                type : 'post',
                success:function(resp){
                    if(resp =="failed"){
                        window.location.href="/pricing";
                    }else{
                        $('#AppendOrderReview').html(resp);
                        $('.loadingDiv').hide();
                    }
                },
                error:function(){ }
            })
        }
        e.preventDefault();
    });
});
</script>
<style type="text/css">
.image-radio {
    cursor: pointer;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    border: 4px solid transparent;
    margin-bottom: 0;
    outline: 0;
}
.image-radio input[type="radio"] {
    display: none;
}
.image-radio-checked {
    border-color: #4783B0;
}
.image-radio .glyphicon {
  position: absolute;
  color: #4A79A3;
  background-color: #fff;
  padding: 10px;
  top: 0;
  right: 0;
}
.image-radio-checked .glyphicon {
  display: block !important;
}
</style>
@stop