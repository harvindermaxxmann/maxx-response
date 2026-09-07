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
                <h1>User Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! action('AdminController@dashboard') !!}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('UsersController@users') }}">Users</a>
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
                        <form  role="form"  id="addEditUser" class="form-horizontal" method="post" @if(empty($userdata)) action="{{ url('admin/add-edit-user') }}" @else  action="{{ url('admin/add-edit-user/'.$userdata['id']) }}" @endif autocomplete="off"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name<span class="red">*</span>:</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Full Name" name="name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($userdata['name']))?$userdata['name']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Email<span class="red">*</span>:</label>
                                    <div class="col-md-4">
                                        <input type="text" autocomplete="off" placeholder="Email" name="email"  style="color:gray" class="form-control" @if(!empty($userdata['email'])) readonly   value="{{(!empty($userdata['email']))?$userdata['email']: '' }}" @endif/>
                                    </div>
                                </div>
                                @if(empty($userdata))
                                    <div class="form-group ">
                                        <label class="col-md-3 control-label">Password<span class="red">*</span>: </label>
                                        <div class="col-md-4">
                                            <input type="password" placeholder="Password" name="password"  style="color:gray" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                    <label class="col-md-7 control-label"><p>Note : Minimum 8 alphanumeric characters.</p> </label>
                                    </div>
                                @endif           
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