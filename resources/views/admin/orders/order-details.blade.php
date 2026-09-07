@extends('layouts.adminLayout.backendLayout')
@section('content')
<?php use App\Product; ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Orders Management</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! url('admin/dashboard') !!}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{!! url('admin/orders') !!}">Orders</a>
            </li>
        </ul>
         @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-basket font-green-sharp"></i>
                            <span class="caption-subject font-green-sharp bold uppercase">
                            Order #{{$orderdetails['id']}} </span>
                            <span class="caption-helper">{{ date('d F Y h:ia',strtotime($orderdetails['created_at'])) }}</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet blue-hoki box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Order Details
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        @if(!empty($orderdetails['invoice_id']))
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                     Invoice No.:
                                                </div>
                                                <div class="col-md-7 value">
                                                     {{$orderdetails['invoice_id']}}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Order Id #:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['id']}}
                                            </div>
                                        </div>
                                        @if(!empty($orderdetails['transaction_id']))
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                    Transaction Id #:
                                                </div>
                                                <div class="col-md-7 value">
                                                     {{$orderdetails['transaction_id']}} ({{$orderdetails['payment_mode']}})
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Order Date & Time:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ date('d F Y h:ia',strtotime($orderdetails['created_at'])) }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Order Status:
                                            </div>
                                            <div class="col-md-7 value">
                                                <span class="label label-success">
                                                {{$orderdetails['order_status']}} </span>
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Payment Method:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['payment_mode']}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Coupon Code:
                                            </div>
                                            <div class="col-md-7 value">
                                                @if(!empty($orderdetails['coupon_code']))
                                                    <span class="label label-success">
                                                    {{$orderdetails['coupon_code']}} 
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Payment Status:
                                            </div>
                                            <div class="col-md-7 value">
                                                 <span class="label label-success">
                                                {{$orderdetails['payment_status']}} </span>
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Grand Total:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$orderdetails['currency']}}{{number_format($orderdetails['grand_total'],2)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet blue-hoki box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Billing Address
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Name:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$orderdetails['user']['name']}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Email:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['user']['email']}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Company Name:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['company_name']}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Address:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['address']}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Country:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['country']}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                State
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['state']}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                City:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['city']}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Zip:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$orderdetails['zip']}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="portlet blue-hoki box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Package Details
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>
                                                    Package Name
                                                </th>
                                                <th>
                                                    List Size
                                                </th>
                                                <th>
                                                    Plan
                                                </th>
                                                <th>
                                                    Total
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {{$orderdetails['package_name']}}
                                                    </td>
                                                    <td>
                                                        {{$orderdetails['list_size']}}
                                                    </td>
                                                    <td>
                                                        {{$orderdetails['subscription']}} {{$orderdetails['subscription_type']}}
                                                    </td>
                                                    <td>
                                                        {{$orderdetails['currency']}}{{number_format($orderdetails['package_price'],2)}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                
                            </div>
                            <div class="col-md-7">
                                <div class="well">
                                    @if(!empty($orderdetails['coupon_code']))
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name">
                                                Coupon Code:
                                            </div>
                                            <div class="col-md-3 value">
                                                <span class="label label-success">
                                               {{number_format($orderdetails['coupon_code'],2)}}</span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name">
                                            Sub Total:
                                        </div>
                                        <div class="col-md-3 value">
                                            {{$orderdetails['currency']}}{{number_format($orderdetails['package_price'],2)}}
                                        </div>
                                    </div>
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name">
                                            Prepaid Discount (-):
                                        </div>
                                        <div class="col-md-3 value">
                                           {{$orderdetails['currency']}}{{number_format($orderdetails['prepaid_discount'],2)}}
                                        </div>
                                    </div>
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name">
                                            Coupon Discount (-):
                                        </div>
                                        <div class="col-md-3 value">
                                           {{$orderdetails['currency']}}{{number_format($orderdetails['coupon_discount'],2)}}
                                        </div>
                                    </div>
                                    <div class="row static-info align-reverse">
                                        <div class="col-md-8 name">
                                             Grand Total:
                                        </div>
                                        <div class="col-md-3 value">
                                            {{$orderdetails['currency']}}{{number_format($orderdetails['grand_total'],2)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop