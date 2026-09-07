@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    .form-control-feedback {
    top: 9px !important;
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
                <a href="{{ action('TemplateController@categories') }}">Template Types</a>
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
                        <form  role="form" class="form-horizontal" method="post" @if(empty($categorydata)) action="{{ url('admin/add-edit-category') }}" @else  action="{{ url('admin/add-edit-category/'.$categorydata['id']) }}" @endif>@csrf
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Type Name:</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Name" name="name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($categorydata['name']))?$categorydata['name']: '' }}" required />
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-md-3 control-label">Select Level:</label>
                                <div class="col-md-4">
                                     <select name="parent_id" class="selectbox" required> 
                                        <option value="">Select</option>
                                        <option value="ROOT" @if(isset($categorydata['parent_id']) && $categorydata['parent_id'] =="ROOT") selected @endif>Main Type</option>
                                        <?php foreach ($categories as $key => $category) {?>
                                        <option value="{{$category['id']}}"@if(isset($categorydata['parent_id']) && $categorydata['parent_id'] ==$category['id']) selected @endif>&#9679;&nbsp;{{$category['name']}}</option>
                                        <?php if(!empty($category['subcats'])){
                                            foreach ($category['subcats'] as $key => $subcat) { ?>
                                                <option value="{{$category['id']}}"@if(isset($categorydata['parent_id']) && $categorydata['parent_id'] ==$subcat['id']) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['name']}}</option>
                                            <?php 
                                            }
                                        }
                                    } ?>
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-md-3 control-label">Description:</label>
                                <div class="col-md-4">
                                    <textarea name="description" placeholder="Enter Description" class="form-control">{{(!empty($categorydata['description']))?$categorydata['description']: '' }}</textarea>
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