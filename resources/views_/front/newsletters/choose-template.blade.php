@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\Feature; 
$types = Feature::featureTypes($slug);  ?>
<section class="page-section dasboard  p-0 d-flex @if(isset($_GET)) filtertrue @endif">

    @include('layouts.frontLayout.main-sidebar')
    
    <div class="right-panel">
    <div class="container-fluid">
        <div class="text-center planline" style="padding:10px 0;"><span>Choose Newsletter Template</span> </div>
        <div class="clearfix"></div>
        <div class="row creatimgbox createlandpage">
            <div class="col-xs-12 col-md-2">
                <select class="btn btn-block btn-primary psbtn getTemplate" name="template">
                    <option value="all-templates" @if(isset($_GET['template']) && $_GET['template']=='all-templates') selected @endif>All Template</option>
                    @foreach($types as $subtype)
                    	<option value="{{$subtype['slug']}}" @if(isset($_GET['template']) && $_GET['template']==$subtype['slug']) selected @endif>{{$subtype['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xs-12 col-md-2">
            </div>
            <div class="col-xs-12 col-md-6 rpdiv text-right">
                <span>Sort by</span>
                <select name="sort" class="getsort">
                	<?php $sortArray = array('date'=>'Date Added','asc'=>'Name (A-Z)','desc'=>'Name (Z-A)');?>
                	<option value="">Please Select</option>
                	@foreach($sortArray as $skey=> $sort)
                    	<option value="{{$skey}}" @if(isset($_GET['sort']) && $_GET['sort']==$skey) selected @endif>{{$sort}}</option>
                    @endforeach
                </select>
                <form action="{{url('/create/landing-page')}}" method="get" class="aseform" autocomplete="off">@csrf
                    <input type="search" name="q" required>
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        
        <div class="clearfix"></div>
        
        <div class="row" id="appendtemplateListing">
        	@include('layouts.frontLayout.newsletter-layout')
        </div>
        <!-- column row close -->

    </div>
    <!-- container close -->
    </div>


</section>
<script type="text/javascript">
	var queryStringObject = {};
    var ref = "<?php echo $uniqid; ?>";
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
    
    $(document).on('change','.getTemplate',function(){
        var value = $(this).val();
        var name= $(this).attr('name');
        queryStringObject[name] = [value];
        if(value==""){
            delete queryStringObject[name];
        }
        filterproducts(queryStringObject);
    });

    function filterproducts(queryStringObject){
        $(".loadingDiv").show();
        var queryString = "?ref="+ref;
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