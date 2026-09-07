@extends('layouts.adminLayout.backendLayout')
@section('content')
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
                <a href="{{ action('PackageController@features') }}">Template Types</a>
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
                        <form  role="form" class="form-horizontal" method="post" @if(empty($featuredata)) action="{{ url('admin/add-edit-feature') }}" @else  action="{{ url('admin/add-edit-feature/'.$featuredata['id']) }}" @endif>@csrf
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Feature<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Feature" name="name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($featuredata['name']))?$featuredata['name']: '' }}" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Select Feature Level<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                    <select name="parent_id" class="selectbox" required> 
                                        <option value="">Select</option>
                                        <option value="ROOT" @if(isset($featuredata['parent_id']) && $featuredata['parent_id'] =="ROOT") selected @endif>Main Feature</option>
                                        <?php foreach ($features as $key => $feature) {?>
                                        <option value="{{$feature['id']}}"@if(isset($featuredata['parent_id']) && $featuredata['parent_id'] ==$feature['id']) selected @endif>&#9679;&nbsp;{{$feature['name']}}</option>
                                        <?php if(!empty($feature['subfeatures'])){
                                            foreach ($feature['subfeatures'] as $key => $subfeat) { ?>
                                                <option value="{{$feature['id']}}"@if(isset($featuredata['parent_id']) && $featuredata['parent_id'] ==$subfeat['id']) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subfeat['name']}}</option>
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
                                    <textarea name="description" placeholder="Enter Description" class="form-control">{{(!empty($featuredata['description']))?$featuredata['description']: '' }}</textarea>
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