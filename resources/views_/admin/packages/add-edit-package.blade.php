@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    .form-control-feedback {
    top: 9px !important;
    }
    .red{
        color :red;
    }
</style>
<?php use App\Package;  use App\PackageFeature;?>
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
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('PackageController@packages') }}">Packages</a>
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
                        <form  role="form"  class="form-horizontal" method="post" @if(empty($packagedata)) action="{{ url('admin/add-edit-package') }}" @else  action="{{ url('admin/add-edit-package/'.$packagedata['id']) }}" @endif>@csrf
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Package Name<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                    <input type="text" pattern="[a-zA-Z\s]+" oninvalid="setCustomValidity('Please enter alphabets only. ')" placeholder="Package Name" name="package_name" style="color:gray" autocomplete="off" class="form-control" value="{{(!empty($packagedata['package_name']))?$packagedata['package_name']: '' }}" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Description<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                    <textarea type="text" placeholder="Package Description" name="description" style="color:gray" autocomplete="off" class="form-control" required>{{(!empty($packagedata['description']))?$packagedata['description']: '' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Package Type<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="type" required id="getType">
                                        <option value="">Select</option>
                                        <?php $types = array('free'=>'Free Trial','paid'=>'Paid'); ?>
                                        @foreach($types as $tkey=> $type)
                                            <option value="{{$tkey}}" {{(!empty($packagedata['type'])&& $packagedata['type'] ==$tkey)? 'selected': ''}}>{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="NoOfDays" @if(empty($packagedata) || (!empty($packagedata['type']) && $packagedata['type']=="paid") ) style="display: none;" @endif>
                                <label class="col-md-3 control-label">Number of Days:</label>
                                <div class="col-md-4">
                                    <input type="number" min="1" max="365" placeholder="Enter Number of Days" name="no_of_days" style="color:gray" autocomplete="off" class="form-control noOfdays" value="{{(!empty($packagedata['no_of_days']))?$packagedata['no_of_days']: '' }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">List Size Details:</label>
                                <div class="col-md-6">
                                    @if(!empty($packagedata['listsize']))
                                        <table id="dynamicTable1" class="table table-hover table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th>List Size</th>
                                                    <th>Price ($)</th>
                                                    <th>Actions</th>
                                                </tr>
                                                @foreach($packagedata['listsize'] as $lkey => $list)
                                                    <input type="hidden" name="list_ids[]" value="{{$list['id']}}">
                                                    <tr class="blockIdWrap">
                                                        <td class="blockId" style="vertical-align: middle;">
                                                            {{++$lkey}}
                                                        </td>
                                                        <td>
                                                            <input type="number" min="0" placeholder="Enter List Size" name="list_size[]" style="color:gray" autocomplete="off" class="form-control" required value="{{$list['list_size']}}"/>
                                                        </td>
                                                        <td>
                                                            <input min="0" type="number" placeholder="Enter Price" name="price[]" style="color:gray" autocomplete="off" class="form-control" required value="{{$list['price']}}"/>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                 @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <table id="dynamicTable1" class="table table-hover table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th>List Size</th>
                                                    <th>Price ($)</th>
                                                    <th>Actions</th>
                                                </tr>
                                                <tr class="blockIdWrap">
                                                    <td class="blockId" style="vertical-align: middle;">
                                                        1
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" placeholder="Enter List Size" name="list_size[]" style="color:gray" autocomplete="off" class="form-control" required/>
                                                    </td>
                                                    <td>
                                                        <input min="0" type="number" placeholder="Enter Price" name="price[]" style="color:gray" autocomplete="off" class="form-control" required/>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    <input type="button" id="addrow" value="Add More">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Number of Users<span class="red">*</span>:</label>
                                <div class="col-md-4">
                                    <select name="number_of_users" class="form-control" required="">
                                        <option value="">Select</option>
                                        @for($i=1; $i<=5;$i++)
                                            <option value="{{$i}}" @if(!empty($packagedata) && $packagedata['number_of_users'] == $i) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <?php $features = Package::packagefeatures();?>
                            @foreach($features as $feature)
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{$feature['name']}}:</label>
                                    @foreach($feature['subfeatures'] as $subfeature)
                                        
                                        <?php
                                        $details = array();
                                        if(!empty($packagedata)){
                                            $details = PackageFeature::selectedFeatures($packagedata['id'],$subfeature['id']); ?>
                                       <?php }?>
                                        <?php $checked =""; $qty="";?>
                                        @if(!empty($details))
                                            <?php $checked ="checked"; $qty = $details['qty'] ?>
                                        @endif
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="features[{{$subfeature['id']}}]" value="{{$subfeature['id']}}" {{$checked}}>&nbsp;{{$subfeature['name']}}
                                                </span>
                                                <input type="number" name="value[{{$subfeature['id']}}]" placeholder="Enter Number of {{$subfeature['name']}}" class="form-control"  value="{{$qty}}">
                                            </div>
                                        </div>
                                        <label class="col-md-3 control-label"></label>
                                    @endforeach
                                     <!-- <div class="col-md-4">
                                        @foreach($feature['subfeatures'] as $subfeature)
                                            <?php $checked =""; ?>
                                            @if(in_array($subfeature['id'],$selFeatures))
                                                <?php $checked ="checked"; ?>
                                            @endif
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="features[]" value="{{$subfeature['id']}}" {{$checked}}>{{$subfeature['name']}}
                                            </label>
                                        @endforeach
                                    </div> -->
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
<!-- Hidden Table -->
<table class="table table-hover table-bordered table-striped samplerow" style="display:none;">
    <tbody>
        <tr class="appenderTr blockIdWrap">
            <td class="blockId" style="vertical-align: middle;">
            </td>
            <td>
                <input type="number" placeholder="Enter List Size" name="list_size[]" style="color:gray" autocomplete="off" class="form-control" required/>
            </td>
            <td>
                <input type="number" placeholder="Enter Price" name="price[]" style="color:gray" autocomplete="off" class="form-control" required/>
            </td>
            <td class="text-center" style="vertical-align: middle;">
                <a title="Remove" class="btn btn-xs red remove" href="javascript:;" style="padding: 1px 8px 3px;"> <i class="fa fa-times"></i></a>
            </td>
        </tr>
    </tbody>
</table>
<!-- Hidden Table -->
<script type="text/javascript">
    $(document).ready(function(){
        jQuery("#addrow").click(function() {        
            var row = jQuery('.samplerow tr').clone(true);
            row.appendTo('#dynamicTable1');        
            $('.blockIdWrap').each(function (key) {
                var k = key;                
                var $this = $(this);
                $this.find('.blockId').html(k+1);
            });
        });
        // blockIdWrap
        $('.remove').on("click", function() {
            $(this).parents("tr").remove();
            $('.blockIdWrap').each(function (key) {
                var k = key;                
                var $this = $(this);
                $this.find('.blockId').html(k+1);
            });
        });

        $(document).on('change','#getType',function(){
            var type = $(this).val();
            if(type=="free"){
                $('#NoOfDays').show();
                $(".noOfdays").prop('required',true);
            }else{
                $('#NoOfDays').hide();
                 $(".noOfdays").prop('required',false);
            }
        })

    })
</script>

@stop