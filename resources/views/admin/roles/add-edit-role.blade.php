@extends('layouts.adminLayout.backendLayout')
@section('content')
<?php use App\RolePermission; ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Settings </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! action('AdminController@dashboard') !!}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('RolesController@roles')}}">Roles</a>
            </li>
        </ul>
        @if(Session::has('flash_message_success'))
        <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
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
                        <form id="subadminForm" role="form" class="form-horizontal" method="post" action="{{ url('/admin/add-edit-role/'.$roleid) }}">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Role Name :</label>
                                    <div class="col-md-4">
                                        <input type="text" pattern=".*[^ ].*"  placeholder="Role Name" name="role_name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($roledata['role_name']))?$roledata['role_name']: '' }}" required />
                                    </div>
                                </div>
                                @foreach($getModules as $key=> $module)
                                <?php $view ="";$edit ="";$delete ="";?>
                                    @if($roleid)
                                        <?php $details =  RolePermission::roledetails($roleid,$module['id']);
                                            $view = $details['view'];
                                            $edit = $details['edit'];
                                            $delete = $details['delete'];
                                        ?>
                                    @endif
                                <input type="hidden" name="module_id[{{$module['id']}}]" value="{{$module['id']}}">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{$module['name']}}:</label>
                                    <div class="checkbox-list">
                                        <div class="col-md-9">
                                            <label class="checkbox-inline">
                                            <input type="checkbox" rel="{{$module['id']}}" id="view-{{$module['id']}}" data-attr="View" class="getModuleid" name="module_id[{{$module['id']}}][view_access]" value="1" {{$view}}> View Only </label>
                                            <label class="checkbox-inline">
                                            @if($module['edit_route'] !="")
                                            <input type="checkbox" rel="{{$module['id']}}" data-attr="Edit"  id="edit-{{$module['id']}}" class="getModuleid" name="module_id[{{$module['id']}}][edit_access]" value="1" {{$edit}} > View/Edit </label>
                                            @endif
                                            @if($module['delete_route'] !="")
                                            <label class="checkbox-inline">
                                            <input type="checkbox" rel="{{$module['id']}}" data-attr="Delete" id="delete-{{$module['id']}}" class="getModuleid" name="module_id[{{$module['id']}}][delete_access]" value="1" {{$delete}}> View/Edit/Delete</label>
                                            @endif
                                        </div>
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
@endsection