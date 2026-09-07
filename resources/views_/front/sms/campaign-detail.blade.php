@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\SmsCampaign; ?>
<div id="contents">
    
    <section class="page-section p-0 d-flex">
        @include('layouts.frontLayout.main-sidebar')

        <div class="right-panel">
        <div class="container-fluid">
            
                <div class="planline page-title pad_top10 mar_bottom20">
                    <span>{{$campaignDetails->campaign_name}}</span>
                </div>
            

            <?php $smsSummary = SmsCampaign::getCampaignnSummary($campaignDetails->id); ?>
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
                            <h3 class="panel-title"><i class="fa fa-pie-chart"></i> Campaign Details</h3>
                        </div>
                        <div class="panel-body dash-summary-panel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Mobile No.</th>
                                <th>Message</th>
                                <th>Length</th>
                                <th>MsgParts</th>
                                <th>Sender</th>
                                <th>Country</th>
                                <th>Operator</th>
                                <th>DLR Status</th>
                                <th>Submit Date</th>
                                <th>Submit Time</th>
                                <th>Done Date</th>
                                <th>Done Time</th>
                                <th>Status Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($campaignDetails->totalsms)>0)
                            @foreach($campaignDetails->totalsms as $ckey=> $campaign)
                            <tr>
                                <td>{{$campaign->mobile}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$campaign->sStatus}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="13" class="text-center">
                                    No Campaigns found.
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
@stop