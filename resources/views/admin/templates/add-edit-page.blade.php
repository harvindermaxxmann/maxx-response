@extends('layouts.adminLayout.backendLayout')
@section('content')
<?php use App\Package; ?>
<style>
    .form-control-feedback {
    top: 9px !important;
    }
    .red{
        color:red;
    }
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Template Management</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! action('AdminController@dashboard') !!}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('TemplateController@pages') }}">Templates</a>
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
                        <form  role="form" class="form-horizontal" method="post" @if(empty($pagedata)) action="{{ url('admin/add-edit-page') }}" @else  action="{{ url('admin/add-edit-page/'.$pagedata['id']) }}" @endif enctype="multipart/form-data"> @csrf
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Name" name="name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($pagedata['name']))?$pagedata['name']: '' }}" required />
                                </div>
                            </div>
                           <?php $features = Package::packagefeatures();?>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Select Template Type<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                     <select name="feature_id" class="selectbox" required> 
                                        <option value="">Select</option>
                                        <?php foreach ($features as $key => $feature) {?>
                                        <option value="{{$feature['id']}}" @if(isset($pagedata['feature_id']) && $pagedata['feature_id'] ==$feature['id']) selected @endif>&#9679;&nbsp;{{$feature['name']}}</option>
                                        <?php if(!empty($feature['subfeatures'])){
                                            foreach ($feature['subfeatures'] as $key => $subfeature) { ?>
                                                <option value="{{$subfeature['id']}}"@if(isset($pagedata['feature_id']) && $pagedata['feature_id'] ==$subfeature['id']) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subfeature['name']}}</option>
                                            <?php 
                                            }
                                        }
                                    } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-md-3 control-label">Select Image: </label>
                                <div class="col-md-5">
                                    <div data-provides="fileinput" class="fileinput fileinput-new">
                                        <div style="" class="fileinput-new thumbnail">
                                            <?php if(!empty($pagedata['image'])){
                                                $path = "images/PageImages/".$pagedata['image']; 
                                                
                                                if(file_exists($path)) { ?>
                                            <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/PageImages/'.$pagedata['image'])}}">
                                            <?php }else{?>
                                            <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/default.png') }}">
                                            <?php } } else { ?>
                                            <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/default.png') }}">
                                            <?php } ?>
                                        </div>
                                        <div style="max-width: 200px; max-height: 150px; line-height: 10px;" class="fileinput-preview fileinput-exists thumbnail">
                                        </div>
                                        <div>
                                            <div>
                                                <span class="btn default btn-file">
                                                <span class="fileinput-new">
                                                Select Image </span>
                                                <span class="fileinput-exists">
                                                Select Image </span>
                                                <input type="file" name="image">
                                                </span>
                                                <a data-dismiss="fileinput" class="btn default fileinput-exists" href="#">
                                                Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Select Template<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                    <select name="template_id" class="selectbox" required> 
                                        <option value="">Select Template</option>
                                        <?php foreach ($templates as $key => $template) {?>
                                        <option value="{{$template->id}}" @if(isset($pagedata['template_id']) && $pagedata['template_id'] ==$template->id) selected @endif>&#9679;&nbsp;{{$template->name}} (for {{ucwords($template->type)}})</option>
                                        
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Description:</label>
                                <div class="col-md-4">
                                    <textarea name="description" placeholder="Enter Description" class="form-control">{{(!empty($pagedata['description']))?$pagedata['description']: '' }}</textarea>
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