@extends('layouts.frontLayout.front-layout')
@section('content')
<style type="text/css">
/* Begin Campaign Styles */
.campaign-box .blocks_div .panel h2 {
    padding: 55px 0;
}
.campaign-accountInfo .note {
    line-height: 1.4;
    padding: 20px 0;
}
.campaign-accountInfo .btn-secondary {
    background-color: #2d2d2d;
    border-color: #2d2d2d;
    color: #fff;
}
.campaign-accountInfo .pT25 {
    padding-top: 25px;
}
.campaign-accountInfo h4 {
    font-family: 'Eczar', serif;
    margin: 15px 0px 25px;
    font-size: 2rem;
}
.create_own_id {
    padding: 0 15px;
}
.create_own_id .form-horizontal .control-label {
    padding-top: 14px;
    text-align: left;
}
/* End Campaign Styles */
</style>
<div id="contents">
    <section class="page-section p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')


    
    
    <div class="right-panel">
    <div class="container-fluid">
    	<div class="pad_top10 mar_bottom20 planline text-center">
	        <span>SMS CAMPAIGN</span>
	    </div>
    <div class=" campaign-accountInfo">
        <form id="SendSmsCampaignForm" action="javascript:;" method="post" enctype='multipart/form-data'>@csrf
            <h4>Set up Account Info</h4>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                	<div class="form-group">
                        <label id="Campaign">Campaign Name<span class="red">*</span></label>
                        <input type="text" name="campaign_name" class="form-control" placeholder="Campaign Name">
                    </div>
                    <div class="form-group">
                        <label id="senderId">Sender's ID<span class="red">*</span></label>
                        <select class="form-control" name="sender_id">
                        	<option value="">Please Select</option>
                        	<option value="MXMCMS">MXMCMS</option>
                        	@if($checksenderid && $checksenderid->status==1)
                        		<option value="{{$checksenderid->sender_id}}">{{$checksenderid->sender_id}}</option>
                        	@endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label id="senderId">Select Landing Page</label>
                        <select class="form-control getlpPage" name="landing_page">
                        	<option value="">Please Select</option>
                        	@foreach($userlandingPages as $lp)
                        		<option value="{{$lp->max_subdomain}}">{{$lp->max_subdomain}}</option>
                        	@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label id="contentText">Content<span class="red">*</span></label>
                        <textarea rows="3" id="content" name="content" maxlength="160" class="form-control" id="contentText" placeholder="Enter upto 160 characters"></textarea>
                    	<div id="textarea_feedback"></div>
                    </div>
                    <div class="form-group">
                        <label id="senderId">Select List<span class="red">*</span></label>
                        <select class="form-control getlist" name="list">
                        	<option value="">Please Select</option>
                    		<option value="add-new">Add new List</option>
                        	@foreach($linkedlists as $linkedlist)
                        		<option value="{{$linkedlist->list_name}}">{{$linkedlist->list_name}} ({{$linkedlist->contacts_count}})</option>
                        	@endforeach
                        </select>
                    </div>
                    <div id="appendAddnewList">
                    	
                    </div>
                    <div class="form-row">
                        <div class="form-group">
						    <div class="form-check">
						      	<input class="form-check-input" name="accept" type="checkbox" id="gridCheck">
						      	<label class="form-check-label" for="gridCheck">
						        By clicking you are accepting our Terms &amp; Conditions
						      	</label>
						    </div>
						</div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-md-offset-2">
                	@if($checksenderid)
                		@if($checksenderid->status==0)
                			<a href="javascript:;" class="btn btn-secondary btn-lg btn-block">Request Received for Sender Id</a>
                			<p class="note"><small class="form-text text-muted">We have received your request please wait for 1 to 3 business days for your Sender Id. We will send you sender id via Email</small></p>
                		@else
                			<a href="javascript:;" class="btn btn-secondary btn-lg btn-block">Your Sender Id ({{$checksenderid->sender_id}})</a>
                		@endif
                	@else
	                    <a href="javascript:;" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="#createIdmodal">Create your own ID</a>
	                    <p class="note"><small class="form-text text-muted">NOTE : Sender's ID will be generated and sent on your registered email id in 24 hours</small></p>
                    @endif
                </div>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="alert alert-success print-success-msg" style="display:none">
	            <ul></ul>
	        </div>
            <p class="text-center pT25"><button type="submit" class="btn btn-lg btn-default">Submit</button></p>
        </form>            
    </div>
    </div>
	</div>
</div>

</section>

<!-- Modal Starts -->
<div class="modal fade" id="createIdmodal" tabindex="-1" role="dialog" aria-labelledby="createIdLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="createIdLabel">Create your own ID</h4>
            </div>
            <form id="CreateSenderId" action="javascript:;" class="form-horizontal">@csrf
	            <div class="modal-body">
	                <div class="create_own_id">
	                    <div class="form-group">
	                        <label for="sample1" class="col-sm-3 control-label">Sample 1</label>
	                        <div class="col-sm-9">
	                            <input type="text" name="sample1" class="form-control" id="sample1" placeholder="Enter Sample 1">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="sample2" class="col-sm-3 control-label">Sample 2</label>
	                        <div class="col-sm-9">
	                            <input type="text" name="sample2" class="form-control" id="sample2" placeholder="Enter Sample 2">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="sample3" class="col-sm-3 control-label">Sample 3</label>
	                        <div class="col-sm-9">
	                            <input type="text" name="sample3"  class="form-control" id="sample3" placeholder="Enter Sample 3">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="businessName" class="col-sm-3 control-label">Business Name</label>
	                        <div class="col-sm-9">
	                            <input type="text" name="business_name" class="form-control" id="businessName" placeholder="Enter Business Name">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="webURL" class="col-sm-3 control-label">Website URL</label>
	                        <div class="col-sm-9">
	                            <input type="text" name="website_url" class="form-control" id="webURL" placeholder="Enter Website URL">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="email" class="col-sm-3 control-label">Email</label>
	                        <div class="col-sm-9">
	                            <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email">
	                        </div>
	                    </div>
	                    <div class="alert alert-danger print-modal-error-msg" style="display:none">
		                    <ul></ul>
		                </div>
	                    <p>
	                        <small class="form-text text-muted">Note : Sender'ID should contain 6 characters only. For ex. MXMCMS <br> To verify your ID, Your Business Name and Website URL is mandatory</small>
	                    </p>
	                </div>
	            </div>
	            
	            <div class="modal-footer">
	                <button type="submit" class="btn btn-primary">Submit</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
<!-- Modal Ends -->
<script type="text/javascript">
	var text_max = 160;
	function getcontentcount(){
		var text_length = $('#content').val().length;
        var text_remaining = text_max - text_length;
        $('#textarea_feedback').html(text_remaining + ' characters remaining');
	}

	$(document).ready(function(){
		$(document).on('change','.getlpPage',function(){
			$('#CheckoutMessage').text('Please wait...');
			$('#checkoutLoader').show();
			var val = $(this).val();
			if(val==""){
				$('#checkoutLoader').hide();
				$('#content').val('');
			}else{
				$.ajax({
					url : '/get-tiny-url',
					data : {url : val},
					type : 'post',
					success:function(resp){
						$('#checkoutLoader').hide();
						$('#content').val(resp);
						getcontentcount();
					},
					error:function(){

					}
				})
			}
		});

	    $('#textarea_feedback').html(text_max + ' characters remaining');
	    $('#content').keyup(function() {
	        getcontentcount();
	    });


		$(document).on('change','.getlist',function(){
			var list = $(this).val();
			if(list=="add-new"){
				$('#appendAddnewList').html('<div class="form-group"><label id="ListName">List Name<span class="red">*</span></label><input type="text" name="list_name" class="form-control" id="ListName" placeholder="Enter List Name"></div><div class="form-group"><label for="uploadCSV">Upload CSV File<span class="red">*</span></label><input name="csv_file" type="file" class="form-control-file" accept=".csv"  id="uploadCSV"></div><p>Note:- We will skip wrong data from csv file.Please add mobile numbers less then 500 in csv file. Download sample format by clicking <a href="/contcat-demo-format.csv">here</a></p>');
			}else{
				$('#appendAddnewList').html('');
			}
		});

		$('#SendSmsCampaignForm').submit(function(e){
			$('#CheckoutMessage').text('Please wait...');
			$('#checkoutLoader').show();
			e.preventDefault();
			$.ajax({
	        	type : 'post',
	        	url : '/sms-campaign',
	        	data : new FormData(this),
	        	dataType:'JSON',
			   	contentType: false,
			   	cache: false,
			   	processData: false,
	        	success:function(resp){
	        		if(!resp.status){
	        			$('#checkoutLoader').hide();
	        			printErrorMsg(resp.error);
                    	$('.print-error-msg').delay(3000).fadeOut('slow');
	        		}else{
	        			$('#CheckoutMessage').text("Please wait... SMS Camgain is in process.. Don't refresh or press back button");
						$('#checkoutLoader').show();
	        			sendSms(resp.smscampaignid);
	        		}
	        	},
	        	error:function(){
	        		//nothing to do
	        	}
	        });

		});

		$('#CreateSenderId').submit(function(e){
			e.preventDefault();
	        $('#CheckoutMessage').text('Please wait...');
			$('#checkoutLoader').show();
	        var formdata = $("#CreateSenderId").serialize();
	        $.ajax({
	        	type : 'post',
	        	url : '/create-sms-sender-id',
	        	data : formdata,
	        	success:function(resp){
	        		if(!resp.status){
	        			printModalErrorMsg(resp.error);
                    	$('.print-modal-error-msg').delay(3000).fadeOut('slow');
	        		}else{
	        			window.location.href = '/sender-thanks';
	        		}
	        		$('#checkoutLoader').hide();
	        	},
	        	error:function(){
	        		//nothing to do
	        	}
	        });
		});
	})

	$("#createIdmodal").on("hidden.bs.modal", function () {
	    $('#CreateSenderId').trigger("reset");
	});

	function sendSms(smscampaignid){
		$.ajax({
        	type : 'post',
        	url : '/send-sms-to-contacts',
        	data : {smscampaignid : smscampaignid},
        	success:function(resp){
        		$('#checkoutLoader').hide();
        		printSuccessMsg(resp.message);
        		$('.print-success-msg').delay(3000).fadeOut('slow');
        		$('#SendSmsCampaignForm').trigger("reset");
        	},
        	error:function(){
        		//nothing to do
        	}
        });
	}

	function printSuccessMsg(msg){
        $(".print-success-msg").find("ul").html('');
        $(".print-success-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-success-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

	function printErrorMsg(msg){
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

    function printModalErrorMsg(msg){
        $(".print-modal-error-msg").find("ul").html('');
        $(".print-modal-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-modal-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
</script>
@stop