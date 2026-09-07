@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    .form-control-feedback {
      top: 9px !important;
    }
    .red{
        color: red;
    }
</style>
<div class="page-content-wrapper">
    @if(Session::has('flash_message_error'))
        <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
    @endif
    @if(Session::has('flash_message_success'))
        <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
    @endif
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Manage Pricing & Plan </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ action('AdminController@dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('PackageController@coupons') }}">Coupons</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>{{ $title }}
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="addCouponForm" @if(!empty($couponData)) action="{{ url('/admin/add-edit-coupon/'.$couponData['id']) }}" @else action="{{ url('/admin/add-edit-coupon') }}"  @endif role="form" class="form-horizontal" method="post"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
                                @if(!empty($couponData))
                                    <div  class="form-group">
                                    <label class="col-md-3 control-label">Coupon Code:</label>
                                    <div class="col-md-5" style="margin-top: 8px;">
                                        <span><b>{{ $couponData['code'] }}</b></span>
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Coupon Code<span class="red">*</span>:</label>
                                    <div  class="col-md-5">
                                        <div class="radio">
                                            <label class="radio-inline" style="padding-top: 0px;">
                                                <input id="Automatic" type="radio" value="Automatic" name="codeoption" checked />Automatic &nbsp;
                                            </label>
                                            <label class="radio-inline" style="padding-top: 0px;">
                                                <input id="Manual" type="radio" value="Manual" name="codeoption" />Manual
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="AppenderManualCode">
                                    <div class="form-group collapse" id="ManualCode">
                                    </div>
                                </div>
                                @endif 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Coupon Type<span class="red">*</span>:</label>
                                    <div class="col-md-5">
                                        @if(!empty($couponData))    
                                            @if($couponData['coupon_type']=="Multiple Times")
                                                <?php  $Mchecked = "checked";
                                                        $Schecked  ="";?>
                                            @else
                                                <?php $Schecked="checked";
                                                      $Mchecked =""; ?>
                                            @endif
                                        @else
                                            <?php $Schecked="checked"; 
                                                  $Mchecked="";?>
                                        @endif
                                        <div class="radio">
                                            <label class="radio-inline" style="padding-top: 0px;">
                                                <input type="radio" name="coupon_type" value="Multiple Times" {{ $Mchecked }}/>Multiple Times &nbsp; 
                                            </label>
                                            <label class="radio-inline" style="padding-top: 0px;">
                                                <input type="radio" name="coupon_type" value="Single Time" {{ $Schecked }} />Single Time
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Amount Type<span class="red">*</span> :</label>
                                    <div class="col-md-5">
                                        @if(!empty($couponData))    
                                            @if($couponData['amount_type']=="Percentage")
                                                <?php  $Perchecked = "checked";
                                                        $dollarchecked  ="";?>
                                            @else
                                                <?php $dollarchecked="checked";
                                                      $Perchecked =""; ?>
                                            @endif
                                        @else
                                            <?php $dollarchecked="checked"; 
                                                  $Perchecked="";?>
                                        @endif
                                        <div class="radio">
                                        <label class="radio-inline" style="padding-top: 0px;">
                                            <input type="radio" name="amount_type" value="Dollar" {{ $dollarchecked }}/>$ &nbsp;
                                        </label>
                                        <label class="radio-inline" style="padding-top: 0px;">
                                            <input type="radio" name="amount_type" value="Percentage" {{ $Perchecked }} />%
                                        </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Amount<span class="red">*</span>:</label>
                                    <div class="col-md-5">
                                        <input type="text" placeholder="Amount" name="amount" style="color:gray" autocomplete="off"  class="form-control" value="{{(!empty($couponData['amount']))?$couponData['amount']: '' }}"/>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Expiry Date<span class="red">*</span>:</label>
                                    <div class="col-md-5">
                                        <input type="text" placeholder="Expiry Date" name="expiry_date" style="color:gray" class="form-control datePicker" autocomplete="off" value="{{(!empty($couponData['expiry_date']))?$couponData['expiry_date']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status:</label>
                                    <div class="col-md-1" style="margin-top: 9px;">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="status" style="margin-left: 2px;" value="1" <?php  if(!empty($couponData['status']) && $couponData['status']=="1") { echo "checked"; } ?> /></label>
                                        </div>
                                    </div>
                                </div>         
                            </div>
                            <div class="form-actions right1 text-center">
                                <button class="btn green" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&layout=button_count&size=small&mobile_iframe=true&width=88&height=20&appId" width="88" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe> -->
<style>
.form-control-feedback{
    top:8px! important;
}
.form-horizontal .form-group {
    margin-left: 0px !important;
}
</style>
@endsection