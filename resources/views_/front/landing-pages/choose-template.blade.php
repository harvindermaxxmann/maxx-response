@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\Feature; 
$types = Feature::featureTypes($slug);  ?>
<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

    <div class="right-panel">
    <div class="container-fluid">
        <div class="text-center planline" style="padding-top:10px;"><span>Choose Your Own Template</span> </div>
        <div class="clearfix"></div>
        <div class="row creatimgbox createlandpage">
            @if(Session::has('flash_message_error'))
                <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
            @endif
            <div class="col-xs-12 rpdiv text-right">
                <span>Sort by</span>
                <select name="sort" class="getsort">
                    <?php $sortArray = array('date'=>'Date Added','asc'=>'Name (A-Z)','desc'=>'Name (Z-A)');?>
                    <option value="">Please Select</option>
                    @foreach($sortArray as $skey=> $sort)
                        <option value="{{$skey}}" @if(isset($_GET['sort']) && $_GET['sort']==$skey) selected @endif>{{$sort}}</option>
                    @endforeach
                </select>
                <form action="{{url('landing-page/choose-template')}}" method="get" class="aseform" autocomplete="off">@csrf
                    <input type="search" name="q" required>
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
        <div>
            
            <div>
                <div class="template-nav">
                    <ul class="clearfix">
                        <li @if(isset($_GET['template']) && $_GET['template']=="all-templates") class="active" @endif><a href="javascript:void(0);" data-name="template" data-slug="all-templates" class="psbtn getTemplate">All Templates</a></li>
                        @foreach($types as $subtype)
                            <li @if(isset($_GET['template']) && $_GET['template']==$subtype['slug']) class="active" @endif><a href="javascript:void(0);" data-name="template" data-slug="{{$subtype['slug']}}" class="psbtn getTemplate">{{$subtype['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div>
                <div class="row" id="appendtemplateListing">
                    @include('layouts.frontLayout.landing-layout')
                </div>
                <!-- column row close -->
            </div>
        </div>
    </div>
    <!-- container close -->
    </div>
</section>
<!-- Landing Page Name Modal Starts -->
<div id="LandingPageModal" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="themeDetailsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="LandingPageForm" action="{{url('process-landing-page')}}" method="post" autocomplete="off">@csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-offset-1 col-sm-8">
                                <input type="hidden" name="page_id" id="PageId">
                                <input type="hidden" name="template_id" id="TemplateId">
                                <input id="landingName" name="name" type="text" class="form-control input-lg" placeholder="Enter your landing page name" required>
                            </div>
                            <div class="col-sm-3 next-step">
                                <button type="submit" class="btn btn-default btn-lg">Next Step</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="theme-example">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#landingPage" aria-controls="landingPage" role="tab" data-toggle="tab">Landing page</a></li>
                        <li role="presentation">
                            <a href="#thankyouPage" aria-controls="thankyouPage" role="tab" data-toggle="tab">Thank-you page</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="landingPage">
                            <img id="landingPageImage" class="img-responsive" alt="">
                        </div>
                        <div role="tabpanel" class="tab-pane" id="thankyouPage">
                            <img id="ThankyouPageImage" class="img-responsive" alt="">
                        </div>
                    </div>
                </div>
                <!-- Tab Container -->
            </div>
        </div>
    </div>
</div>
<!-- Landing Page Name Modal Starts -->
<script type="text/javascript">
    $(document).on('click','.processLandingPage',function(){
        $(".loadingDiv").show();
        var pageid = $(this).data('pageid');
        var templateid = $(this).data('templateid');
        var landingpageimg  = $(this).data('landingimage');
        var thankyouimage  = $(this).data('thankyouimage');
        $('#PageId').val(pageid);
        $('#TemplateId').val(templateid);
        $("#landingPageImage").attr("src",landingpageimg);
        $("#ThankyouPageImage").attr("src",thankyouimage);
        $(".loadingDiv").hide();
        $('#LandingPageModal').modal('show');
    });

    $('#LandingPageModal').on('hide.bs.modal', function (e) {
        $('#PageId').val('');
        $('#TemplateId').val('');
        $('#landingName').val('');
    })

	var queryStringObject = {};
    if($('.filtertrue').length > 0) {
        var value = $('.getsort option:selected').val();
        var name= $('.getsort').attr('name');
        queryStringObject[name] = [value];
        if(value==""){
            delete queryStringObject[name];
        }
        var value = $('.getTemplate option:selected').val();
        var name= $('.getTemplate').attr('name');
        queryStringObject[name] = [value];
        if(value==""){
            delete queryStringObject[name];
        }
    }
   
    $(document).on('change','.getsort',function(){
        var value = $(this).val();
        var name= $(this).attr('name');
        queryStringObject[name] = [value];
        if(value==""){
            delete queryStringObject[name];
        }
        filterproducts(queryStringObject);
    });
    $(document).on('click','.getTemplate',function(){
        var value = $(this).data('slug');
        var name= $(this).data('name');
        queryStringObject[name] = [value];
        if(value==""){
            delete queryStringObject[name];
        }
        filterproducts(queryStringObject);
    });

    function filterproducts(queryStringObject){
        $(".loadingDiv").show();
        var queryString = "";
        for (var key in queryStringObject) {
            if(queryString==''){
                queryString +="?"+key+"=";
            }else{
                queryString +="&"+key+"=";
            }
            var queryValue = "";
            for (var i in queryStringObject[key]) {
                if(queryValue==''){
                    queryValue += queryStringObject[key][i];
                } else {
                    queryValue += "~"+queryStringObject[key][i];
                }
            }
            queryString += queryValue;
        }
        if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + queryString;
            window.history.pushState({path:newurl},'',newurl);
        }
        if (newurl.indexOf("?") >= 0) {
            newurl = newurl+"&json=";
        }else{
            newurl = newurl+"?json=";
        }
        $.ajax({
            url : newurl,
            type : 'get',
            dataType:'json',
            success:function(resp){
                $("#appendtemplateListing").html(resp.view);
                $(".loadingDiv").hide();
            },
            error:function(){}
        });
    }
</script>
@stop