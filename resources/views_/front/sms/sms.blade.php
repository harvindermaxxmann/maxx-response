@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\SmsCampaign; ?>


<div id="contents">
    <section class="page-section p-0 d-flex">

         @include('layouts.frontLayout.main-sidebar')

        <div class="right-panel">
        <div class="container-fluid">

            @if(isset($_GET['s']) && $_GET['s'] =='done')
                <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success! </strong> Sms Campaign has been run successfully! </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
            @endif
            
            <div class="planline page-title pad_top10">
                <span>Statistics & Reports</span>
                <ul class="nav navbar-nav navbar-right mar_bottom15">
                    <li>
                        <a class="btn btn-primary" href="{{url('/sms-campaign')}}">Create SMS Campaign</a>
                    </li>
                </ul>
            </div>

            <div class="row">


                <div class="col-lg-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="get" action="{{url('/sms')}}">
                                <div class="row datepicker-form">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Date Range:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input type="date" name="from" class="form-control date" value="{{$fromdate}}">
                                        <small>Select From Date</small>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input type="date" name="to" class="form-control date" value="{{$todate}}">
                                        <small>Select To Date</small>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php $smsSummary = SmsCampaign::getsummary($fromdate,$todate); ?>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="total-boxes-wrap box-1">
                        <div class="media">
                            <div class="media-left">
                                <figure><img class="media-object" src="{{ asset('images/message-icon.svg')}}"></figure>
                            </div>
                            <div class="media-body text-right">
                                <h4 class="media-heading">{{$smsSummary['totalSms']}}</h4>
                                <p>Total Messages</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="total-boxes-wrap box-2">
                        <div class="media">
                            <div class="media-left">
                                <figure><img class="media-object" src="{{ asset('images/menu-icon.svg')}}"></figure>
                            </div>
                            <div class="media-body text-right">
                                <h4 class="media-heading">{{$smsSummary['totalsmsPending']}}</h4>
                                <p>Total Pending</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="total-boxes-wrap box-3">
                        <div class="media">
                            <div class="media-left">
                                <figure><img class="media-object" src="{{ asset('images/dollars.svg')}}"></figure>
                            </div>
                            <div class="media-body text-right">
                                <h4 class="media-heading"> {{$smsSummary['totalsmsSent']}}</h4>
                                <p>Total Delivered</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row chart-summary-row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-pie-chart"></i> SMS Campaigns</h3>
                        </div>
                        <div class="panel-body dash-summary-panel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>Sr No.</th> -->
                                <th>Campaign Name</th>
                                <th>Sender Id</th>
                                <th>Group Name</th>
                                <th width="20%">Message</th>
                                <th>Total Message</th>
                                <th>Submit Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($campaigns)>0)
                            @foreach($campaigns as $ckey=> $campaign)
                            <tr>
                                <!-- <td>{{++$ckey}}</td> -->
                                <td><a href="{{url('campaign-detail/'.$campaign->id)}}">{{$campaign->campaign_name}}</a></td>
                                <td>{{$campaign->sender_id}}</td>
                                <td>{{$campaign->linkedlist->list_name}} <span class="badge">5</span></td>
                                <td>{{$campaign->content}}</td>
                                <td>{{$campaign->totalsms_count}}</td>
                                <td>{{date('M d, Y h:ia',strtotime($campaign->created_at))}}</td>
                                <td>
                                    <a title="Resend Campaign" href="javascript:;" data-campaign="{{$campaign->campaign_name}}" data-content="{{$campaign->content}}" data-campaignid="{{$campaign->id}}" class="btn btn-success resendCampaign"><i class="fa fa fa-repeat"></i></a>
                                    <a title="View Campaign Details" href="{{url('campaign-detail/'.$campaign->id)}}" class="btn btn-primary"><i class="fa fa-file"></i></a>
                                    <a title="Export Campaign Details" href="{{url('export/sms-campaign/'.$campaign->id)}}" class="btn btn-warning"><i class="fa fa-file-excel-o"></i></a>
                                    <a title="Delete Campaign" onclick="return confirm('Are you sure?')" href="{{url('delete-sms-campaign/'.$campaign->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center">
                                    No Campaigns found. 
                                    <a href="{{url('/sms-campaign')}}" class="btn btn-primary btn-sm mar_left15"><i class="fa fa-plus-circle" aria-hidden="true"></i>
 Create New Campaign</a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

</div>



<!-- Modal Starts -->
<div class="modal fade" id="ReSendCampaignModal" tabindex="-1" role="dialog" aria-labelledby="createIdLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="createIdLabel">Re-Send Campaign</h4>
            </div>
            <form id="ResendCampaign" action="javascript:;" class="form-horizontal">@csrf
                <div class="modal-body">
                    <div class="create_own_id">
                        <div class="form-group">
                            <label for="Campaignname" class="col-sm-4 control-label">Campaign Name</label>
                            <div class="col-sm-8">
                            <input type="hidden" name="campaign_id" id="Campaignid">
                                <input type="text" name="campaign_name" class="form-control" id="Campaignname" placeholder="Enter Campaign Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Content" class="col-sm-4 control-label">Content</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="content" class="form-control" id="Content" placeholder="Enter Campaign Content"></textarea>
                            </div>
                        </div>
                        <div class="alert alert-danger print-modal-error-msg" style="display:none">
                            <ul></ul>
                        </div>
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
    var smsurl = '/sms';
    window.history.pushState({path:smsurl},'',smsurl);
    $(document).ready(function(){
        $(document).on('click','.resendCampaign',function(){
            var campaignid = $(this).data('campaignid');
            var campaignname = $(this).data('campaign')
            var content = $(this).data('content')
            $('#Campaignid').val(campaignid);
            $('#Campaignname').val(campaignname);
            $('#Content').val(content);
            $('#ReSendCampaignModal').modal('show');
        })

        $('#ResendCampaign').submit(function(e){
            e.preventDefault();
            $('#CheckoutMessage').text('Please wait...');
            $('#checkoutLoader').show();
            var formdata = $("#ResendCampaign").serialize();
            $.ajax({
                type : 'post',
                url : '/resend-sms-campaign',
                data : formdata,
                success:function(resp){
                    if(!resp.status){
                        printModalErrorMsg(resp.error);
                        $('.print-modal-error-msg').delay(3000).fadeOut('slow');
                    }else{
                        window.location.href = '/sms?s=done';
                    }
                    $('#checkoutLoader').hide();
                },
                error:function(){
                    //nothing to do
                }
            });
        });
    });

    function printModalErrorMsg(msg){
        $(".print-modal-error-msg").find("ul").html('');
        $(".print-modal-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-modal-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
</script>
@stop