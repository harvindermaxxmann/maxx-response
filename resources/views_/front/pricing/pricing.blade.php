@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\Discount; ?>
<!-- Intro -->
<section class="page-section padlowtopbot" style="padding-top:40px; padding-bottom:30px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="title-section"><span class="title-regular">Maxxresponse<sup>&trade;</sup> Pricing</span></h1>
                <p class="lead">Choose the plan that's right for your business. Cancel anytime.</p>
            </div>
        </div>
    </div>
</section>
<!-- navigational -->
<section class="page-section monthx">
    <div class="container">
        <div class="row">
            @if(Session::has('flash_message_error'))
                <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
            @endif
            @foreach($errors->all() as $error)
                <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> {!!   $error !!} </div>
            @endforeach
            <div class="col-xs-12 col-md-3 mobvleft text-right tabvcenter">
                <p style="margin:0px; padding-top:13px;">Select Currency</p>
            </div>
            <div class="col-xs-12 col-md-8">
                <div class="form-group col-md-6">
                    <div class="col-lg-4 currency">
                        <?php $currencyimage = asset('images/currencyImages/flag-america.jpg'); ?>
                        <form action="{{url('/change-currency')}}" method="post">@csrf
                            <select class="form-control" name="code" onchange="this.form.submit()">
                                @foreach($currrencies as $currency)
                                    <?php $sel = ""; ?>
                                    @if(Session::has('currency'))
                                        @if(Session::get('currency') ==$currency['code'])
                                            <?php $sel = "selected"; ?>
                                            <?php $currencyimage = asset('images/currencyImages/'.$currency['image']); ?>
                                        @endif
                                    @endif
                                    <option value="{{$currency['code']}}" {{$sel}}>{{$currency['code']}}</option>
                                @endforeach>
                            </select>
                        </form>
                    </div>
                    <div class="col-lg-3 text-center">
                        <img src="{{$currencyimage}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-3 mobvleft text-right tabvcenter">
                <p><span class="glyphicon glyphicon-file"></span>&nbsp;Choose your billing plan</p>
            </div>
            <div class="col-xs-12 col-md-8">
                <?php $plans = Discount::plans(); ?>
                <p class="tabvcenter">
                @foreach($plans as $plan)
                    @if($plan['type']=="Monthly")
                        <?php $class="btn btn-success"; ?>
                    @else
                        <?php $class="btn btn-warning"; ?>
                    @endif
                    <a href="javascript:;" data-reset="yes" data-plan="{{$plan['value']}}" class="{{$class}} getPlan">{{$plan['type']}} @if(!empty($plan['discount'])) -{{$plan['discount']}}% @endif</a>
                @endforeach
                </p>
            </div>
        </div>
    </div>
</section>
<section class="page-section padlowtopbot" id="AppendPackages">
    @include('layouts.frontLayout.pricing-layout')
</section>
<script type="text/javascript">
$(document).on('click','.getPlan',function(){
    $('.loadingDiv').show();
    var plan = $(this).data('plan');
    $('#ActivePlan').val(plan);
    $('.getPlan').filter('[data-reset="yes"]').addClass('btn-warning');
    $('.getPlan').filter('[data-reset="yes"]').removeClass('btn-success');
    $(this).removeClass('btn-warning');
    $(this).addClass('btn-success');
    $.ajax({
        data : {plan: plan},
        url : '/change-plan',
        type : 'post',
        dataType : 'json',
        success:function(resp){
            $('#AppendPackages').html(resp.view);
            $('.loadingDiv').hide();
        },
        error:function(){}
    })
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','#getListsize',function(){
            $('.loadingDiv').show();
            var listsize = $(this).val();
            var plan = $('#ActivePlan').val();
            var packageid= $(this).find(':selected').data('packageid');
            $.ajax({
                data: {packageid:packageid,listsize:listsize,plan:plan},
                url : '/check-listsize-pricing',
                type : 'post',
                success:function(resp){
                    $('#UpdatePrice-'+packageid).text(resp);
                    $('.loadingDiv').hide();
                },
                error:function(){
                    //nothing to do
                }
            })
        })
    })
</script>

@stop