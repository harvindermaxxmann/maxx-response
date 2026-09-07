@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

    <div class="right-panel">
    <div class="container-fluid">
        <div class="col-xs-12 col-md-12" style="padding:0;">

            <h3 style="margin:10px 0 20px;">Message summary for: {{$draftdetails['message_name']}}</h3>
            <!-- block one -->
            <div class="col-xs-12 col-md-12 summry_block">
                <div class="media">
                    <div class="media-left">
                        <a href="#" class="media-object">
                        <i class="fa fa-wrench" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Message subject:</h4>
                        <p>{{$draftdetails['subject']}}</p>
                        <p><small><b>From:</b>{{Auth::user()->name}}&lt;{{$draftdetails['from_email']}}&gt;</small></p>
                        <a href="{{url('newsletter/basic-settings?type='.$draftdetails['draft_type'].'&ref='.$uniqid)}}" class="btn-edit text-uppercase">Edit</a>
                    </div>
                </div>
            </div>
            <!-- block one -->
            <!-- block two -->
            <div class="col-xs-12 col-md-12 summry_block">
                <div class="media">
                    <div class="media-left">
                        <a href="#" class="media-object">
                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Template:</h4>
                        <p>@if(!empty($draftdetails['template'])) {{$draftdetails['template']['name']}} &nbsp; @endif <a target="_blank" href="{{url('/draft/preview/'.$draftdetails['id'])}}"><i class="fa fa-eye"></i></a> </p>
                        @if(!empty($draftdetails['template'])) 
                            <a href="{{url('newsletter-choose-template?ref='.$uniqid)}}" class="btn-edit text-uppercase">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- block two -->	
            <!-- block three -->
            <div class="col-xs-12 col-md-12 summry_block">
                <div class="media">
                    <div class="media-left">
                        <a href="#" class="media-object">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">HTML Message:</h4>
                        <p>Preview your email and make sure it looks great</p>
                        <!-- <p><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; SpamScore(0.10)&nbsp; <a href="javascript:;"><i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>&nbsp; Inbox Preview unrivewed</a>&nbsp; <small>(preview your email on 20+ email browsers and make sure it looks greate)</small>  </p> -->
                        @if($draftdetails['draft_type'] =="editor")
                            <a href="{{url('html/editor?type=newsletter&ref='.$uniqid)}}" class="btn-edit text-uppercase">Edit</a>
                        @else
                            <a href="{{url('create-plain-html?ref='.$uniqid)}}" class="btn-edit text-uppercase">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- block three -->	
            <!-- block four -->
            <div class="col-xs-12 col-md-12 summry_block">
                <div class="media">
                    <div class="media-left">
                        <a href="#" class="media-object">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Recipients:</h4>
                        <p>{{$recipients}}<small>/List {{$listdetails['list_name']}}</small></p>
                        <a href="{{url('newsletter/basic-settings?type='.$draftdetails['draft_type'].'&ref='.$uniqid)}}" class="btn-edit text-uppercase">Edit</a>
                    </div>
                </div>
            </div>
            <!-- block four -->		
        </div>
        <!-- block outer div close -->
        <div class="clearfix"></div>
        <div class="row message_summary_btns" style="margin-top:10px; margin-bottom:30px;">
            <div class="col-xs-12 col-sm-3">
                <a @if($draftdetails['draft_type'] =="editor") href="{{url('html/editor?type=newsletter&ref='.$uniqid)}}" @else href="{{url('create-plain-html?ref='.$uniqid)}}" @endif class="btn btn-default round_btn">Previous step</a>	
            </div>
            <div class="col-xs-12 col-sm-9 text-right">
                <!-- <div class="ad_p">
                    <span>Perfect Timing</span>
                    <div class="btn-group btn-toggle"> 
                        <button class="btn btn-xs btn-default">ON</button>
                        <button class="btn btn-xs btn-primary active">OFF</button>
                    </div>
                </div> -->
                <form action="{{url('/newsletter-campaign')}}" method="post">@csrf
                    <input type="hidden" name="ref" value="{{$_GET['ref']}}"/>
                    <a href="{{url('/drafts')}}" class="btn btn-primary round_btn">Go to Drafts</a>
                    <button type="submit" class="btn btn-primary round_btn">Send Newsletter</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</section>
@stop