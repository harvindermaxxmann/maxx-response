@extends('layouts.adminLayout.backendLayout')
@section('content')
<style type="text/css">
    .red{
        color:red;
    }
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Sms Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! action('AdminController@dashboard') !!}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('admin/sender-ids') }}">Sender Ids</a>
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
                        <form  role="form"  id="addEditUser" class="form-horizontal" method="post"  action="{{ url('admin/approve-sender-id/'.$details->id) }}" autocomplete="off"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Sample<span class="red">*</span>:</label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="sender_id">
                                            <option value="">Please Select</option>
                                            @if(!empty($details->sample1))
                                                <option value="{{$details->sample1}}">{{$details->sample1}}</option>
                                            @endif
                                            @if(!empty($details->sample2))
                                                <option value="{{$details->sample2}}">{{$details->sample2}}</option>
                                            @endif
                                            @if(!empty($details->sample3))
                                                <option value="{{$details->sample3}}">{{$details->sample3}}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Email<span class="red">*</span>:</label>
                                    <div class="col-md-4">
                                        <p style="margin-top: 8px;">{{$details->email}}</p>
                                    </div>
                                </div> 
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Description<span class="red">*</span>:</label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" placeholder="Enter Description" name="description"></textarea>
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
@stop