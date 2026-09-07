@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\SmsCampaign; ?>


<div id="contents">
    <section class="page-section p-0 d-flex">

         @include('layouts.frontLayout.main-sidebar')

        <div class="right-panel">
        <div class="container-fluid">
            
            <div class="planline page-title pad_top10">
                <span>SMS Campaigns</span>
                <ul class="nav navbar-nav navbar-right mar_bottom15">
                    <li>
                        <a class="btn btn-primary" href="{{url('/sms-campaign')}}">Create SMS Campaign</a>
                    </li>
                </ul>
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
                                <th>List Name</th>
                                <th width="20%">Message</th>
                                <th>Total Message</th>
                                <th>Submit Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            
                            <tr>
                                <td colspan="8" class="text-center">
                                    No Campaigns found. 
                                    <a href="{{url('/sms-campaign')}}" class="btn btn-primary btn-sm mar_left15"><i class="fa fa-plus-circle" aria-hidden="true"></i>
 Create New Campaign</a>
                                </td>
                            </tr>
                            
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