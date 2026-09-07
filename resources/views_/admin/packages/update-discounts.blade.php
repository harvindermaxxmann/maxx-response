@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    .form-control-feedback {
    top: 9px !important;
    }
</style>
<?php use App\Package; ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Manage Pricing Plan</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! action('AdminController@dashboard') !!}">Dashboard</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 ">
                @if(Session::has('flash_message_success'))
                    <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
                @endif
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>{{ $title }}
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form  role="form" class="form-horizontal" method="post" action="{{url('/admin/update-discounts')}}">@csrf
                        <div class="form-body">
                            @foreach($discounts as $discount)
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{$discount['small_description']}} :</label>
                                    <div class="col-md-4">
                                        <input type="number" placeholder="Enter Discount" name="discounts[{{$discount['id']}}]" style="color:gray" autocomplete="off" class="form-control" value="{{$discount['discount']}}" required />
                                    </div>
                                </div>
                            @endforeach     
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
@stop