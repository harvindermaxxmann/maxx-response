<style>
    .form-control-feedback {
      display: none !important;
    }
    .selectbox {width:100%; padding: 6px 12px;}
</style>
@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
    
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Attendances's Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('admin/attendances') }}">Attendances</a>
            </li>
        </ul>
        @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>{{ $title }}
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="subadminForm" role="form" class="form-horizontal" method="post" action="{{ url('admin/export-attendances') }}" > 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Employees :</label>
                                    <div class="col-md-5 multipleSelectBox">
                                       <select name="user_ids[]" class="selectpicker" multiple data-actions-box="true" data-size="7" data-live-search="true" data-width="100%" required>
                                            @foreach($users as $user)
                                                <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Year :</label>
                                    <div class="col-md-5 multipleSelectBox">
                                       <select name="year" class="selectbox">
                                            <?php for ($i=2019; $i <= date('Y') ; $i++) { ?>
                                                <option value="{{$i}}" @if($i==date('Y')) selected @endif>{{ $i }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Month :</label>
                                    <div  class="col-md-5 multipleSelectBox">
                                        <?php $monthArr = array('1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'May','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sept','10'=>'Oct','11'=>'Nov','12'=>'Dec'); ?>
                                       <select name="month" class="selectbox">
                                            @foreach($monthArr as $key => $month)
                                                <option value="{{ $key}}" @if($key==date('m')) selected @endif>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Include Attendance time in Excel/Csv:</label>
                                    <div class="col-md-5 multipleSelectBox">
                                       <select name="include" class="selectbox">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>            
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Type :</label>
                                    <div class="col-md-5 multipleSelectBox">
                                       <select name="type" class="selectbox">
                                            <option value="xls">Excel</option>
                                            <option value="csv">CSV</option>
                                        </select>
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