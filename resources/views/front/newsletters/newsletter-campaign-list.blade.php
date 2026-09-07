<?php use App\Helpers\Helper; ?>
@extends('layouts.frontLayout.front-layout')
@section('content')

<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

    <div class="right-panel">
        <div class="container-fluid">
            
            <div class="planline page-title pad_top10">
                <span>Email Campaigns</span>
                <ul class="nav navbar-nav navbar-right mar_bottom15">
                    <li>
                        <a class="btn btn-primary" href="{{url('/newsletter/choose-html-or-plain')}}">Create Email Campaign</a>
                    </li>
                </ul>
            </div>
            
            <div class="row chart-summary-row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-pie-chart"></i> Email Campaigns</h3>
                        </div>
                        <div class="panel-body dash-summary-panel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>Sr No.</th> -->
                                <th>Campaign</th>
                                <th>Recipients</th>
                                <th>Sent</th>
                                <th>Unique Opens</th>
                                <th>Unique Clicks</th>
                                <th>Duplicate</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @isset($campaigns)
                                @foreach ( $campaigns as $campaign )

                                    <?php

                                    //print_r($getBounced);                     
                                    $id = $campaign->id;
                                    $timezone = $campaign->timezone=='' ? '' : stripslashes($campaign->timezone);                                    
                                    $title = $campaign->title=='' ? '' : stripslashes(htmlentities($campaign->title,ENT_QUOTES,"UTF-8"));
                                    $campaign_title = $campaign->label=='' ? $title : stripslashes(htmlentities($campaign->label,ENT_QUOTES,"UTF-8"));
                                    $recipients = $campaign->recipients=='' ? '' : stripslashes($campaign->recipients);
                                    $sent = $campaign->sent=='' ? '' : stripslashes($campaign->sent);
                                    $opens = $campaign->opens=='' ? '' : stripslashes($campaign->opens);
                                    $send_date = $campaign->send_date=='' ? '' : stripslashes($campaign->send_date);
                                    $scheduled_lists = $campaign->lists=='' ? '' : stripslashes($campaign->lists);
                                    $to_send = $campaign->to_send=='' ? '' : stripslashes($campaign->to_send);
                                    $to_send_lists = $campaign->to_send_lists=='' ? '' : stripslashes($campaign->to_send_lists);
                                    $from_name = $campaign->from_name=='' ? '' : stripslashes($campaign->from_name);
                                    $from_email = $campaign->from_email=='' ? '' : stripslashes($campaign->from_email);
                                    $error_stack = $campaign->errors=='' ? '' : stripslashes($campaign->errors);
                                    $error_stack_array = explode(',', $error_stack);
                                    $no_of_errors = count($error_stack_array);
                                    $opens_tracking = $campaign->opens_tracking;
                                    $links_tracking = $campaign->links_tracking;

                                    if($to_send_lists=='')
                                    {
                                        $percentage_opened = 0;
                                        $opens_unique = 0;
                                    }
                                    else
                                    {
                                        if($opens=='')
                                            $opens_unique = 0;
                                        else
                                        {
                                            $opens_array = explode(',', $opens);
                                            $opens_array2 = array();
                                            foreach($opens_array as $oa)
                                            {
                                                $oa = $oa.',';
                                                array_push($opens_array2, $oa);
                                            }
                                            $opens_unique = count(array_unique($opens_array2));
                                        }
                                        
                                        if($recipients==0 || $opens_unique==0) $percentage_opened = 0;
                                        else $percentage_opened = round($opens_unique/($recipients-Helper::get_bounced($campaign->id)) * 100, 2);
                                    }

                                    if($to_send_lists=='')
                                    {
                                        $percentage_opened = 0;
                                        $opens_unique = 0;
                                    }
                                    else
                                    {
                                        if($opens=='')
                                            $opens_unique = 0;
                                        else
                                        {
                                            $opens_array = explode(',', $opens);
                                            $opens_array2 = array();
                                            foreach($opens_array as $oa)
                                            {
                                                $oa = $oa.',';
                                                array_push($opens_array2, $oa);
                                            }
                                            $opens_unique = count(array_unique($opens_array2));
                                        }
                                        
                                        if($recipients==0 || $opens_unique==0) $percentage_opened = 0;
                                        else $percentage_opened = round($opens_unique/($recipients-Helper::get_bounced($campaign->id)) * 100, 2);
                                    }
                                    if($recipients==0 || $recipients=='') $percentage_clicked = round(Helper::get_click_percentage($campaign->id) *100, 2);
                                    else $percentage_clicked = round(Helper::get_click_percentage($campaign->id)/$recipients *100, 2);

                                    ?>

                                    <tr>
                                        <td class="text-center"> {{ $campaign->title }} </td>
                                        <td class="text-center"> {{ $campaign->recipients }}</td>
                                        <td class="text-center"> {{ $campaign->sent }}</td>
                                        <td class="text-center"><span class="label label-success"><?php echo $opens_tracking ? $percentage_opened.'%</span> '.number_format($opens_unique).' '._('opened') : _('Tracking disabled'); ?> </td>
                                        <td class="text-center"><span class="label label-info"><?php echo $links_tracking ? $percentage_clicked.'%</span> '.number_format(Helper::get_click_percentage($campaign->id)).' '._('clicked') : _('Tracking disabled'); ?> </td>
                                        <td class="text-center"><a href="#duplicate-modal" title="" id="duplicate-btn-{{ $campaign->id }}" data-toggle="modal" data-cid="{{ $campaign->id }}" class="duplicate-btn"><i class="icon icon-copy"></i></a></td>
                                        <td class="text-center"><a href="#delete-campaign" title="{{ $campaign->title }}" id="delete-btn-{{ $campaign->id }}" data-toggle="modal"><span class="icon icon-trash"></span></a></td>
                                    </tr>
                                @endforeach
                            @endisset
                             
                            @empty($campaigns)
                                <tr>
                                    <td colspan="8" class="text-center">
                                        No Campaigns found. 
                                        <a href="{{url('/newsletter/choose-html-or-plain')}}" class="btn btn-primary btn-sm mar_left15"><i class="fa fa-plus-circle" aria-hidden="true"></i>Create New Campaign</a>
                                    </td>
                                </tr>
                            @endempty                            
                            
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
@stop