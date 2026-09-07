@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')
    
    <div class="right-panel">
        
        <div class="container-fluid" >

             @if(Session::has('flash_message_error'))
                <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
            @endif
            @if(!empty($expirystring))
                <div class="alert alert-info text-center" role="alert" style="display: none;">
                    <b>{{$expirystring}}</b>
                </div>
            @endif

            <div class="blocks_div">
                    
                    <div class="dashboard-tab">

                      <!-- Nav tabs -->
                      <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#design" aria-controls="design" role="tab" data-toggle="tab"> <img src="{{ asset('images/design-icon.png')}}" alt="DESIGN" class="icon-grey"> <img src="{{ asset('images/design-icon-white.png')}}" alt="DESIGN" class="icon-white">  DESIGN</a></li>
                        <li role="presentation"><a href="#marketing" aria-controls="marketing" role="tab" data-toggle="tab"> <img src="{{ asset('images/social-media-marketing-icon.png')}}" alt="MARKETING" class="icon-grey"> <img src="{{ asset('images/social-media-marketing-icon-white.png')}}" alt="MARKETING" class="icon-white">  CAMPAIGNS</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        
                        <div role="tabpanel" class="tab-pane fade in active" id="design">
                            
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    <div class="subcat-nav">
                                        <ul class="list-unstyled">
                                            <li id="Newsletter_nav" class="active">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/design-newsletter-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">1,245</span> Newsletter</span> </a>
                                            </li>
                                            <li id="LandingPages_nav">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/design-landing-page-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">34</span> Landing Pages </span></a>
                                            </li>
                                            <li id="Surveys_nav">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/design-survey-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">15</span> Surveys </span></a>
                                            </li>
                                            <li id="Polls_nav">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/design-poll-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">2</span> Polls </span></a>
                                            </li>
                                            <li id="Invitations_nav">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/design-invitation-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">30</span> Invitations </span></a>
                                            </li>
                                            <!-- <li id="Ivr_nav">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/ivr-phone-icon.png')}}" alt="" class="pull-left"> <span class="pull-right"> <span class="count">5</span> OBD and IVR </span></a>
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>

                                

                                <div class="col-xs-12 col-md-9">
                                    
                                    <div id="Newsletter_tab" class="subcat_content" style="display: block;">

                                        <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Created</h4>
                                                <div id="justgage_1" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Published</h4>
                                                <div id="justgage_2" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Sent</h4>
                                                <div id="justgage_3" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Draft</h4>
                                                <div id="justgage_4" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">


                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>

                                        <div class="chart">
                                            <canvas id="chart_line_1" height="200" width="1050"></canvas>   
                                        </div>

                                        

                                    </div>


                                    <div id="LandingPages_tab" class="subcat_content">
                                    <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Created</h4>
                                                <div id="justgage_21" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Published</h4>
                                                <div id="justgage_22" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Sent</h4>
                                                <div id="justgage_23" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Draft</h4>
                                                <div id="justgage_24" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">


                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>

                                        <div class="chart">
                                            <canvas id="chart_line_6" height="200" width="1050"></canvas>   
                                        </div>
                                    </div>

                                    <div id="Surveys_tab" class="subcat_content">
                                    <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Created</h4>
                                                <div id="justgage_25" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Published</h4>
                                                <div id="justgage_26" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Sent</h4>
                                                <div id="justgage_27" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Draft</h4>
                                                <div id="justgage_28" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">


                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>

                                        <div class="chart">
                                            <canvas id="chart_line_7" height="200" width="1050"></canvas>   
                                        </div>
                                    </div>

                                    <div id="Polls_tab" class="subcat_content">
                                    <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Created</h4>
                                                <div id="justgage_29" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Published</h4>
                                                <div id="justgage_30" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Sent</h4>
                                                <div id="justgage_31" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Draft</h4>
                                                <div id="justgage_32" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">


                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>

                                        <div class="chart">
                                            <canvas id="chart_line_8" height="200" width="1050"></canvas>   
                                        </div>
                                    </div>

                                     <div id="Invitations_tab" class="subcat_content">
                                     <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Created</h4>
                                                <div id="justgage_33" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Published</h4>
                                                <div id="justgage_34" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Sent</h4>
                                                <div id="justgage_35" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Draft</h4>
                                                <div id="justgage_36" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">


                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>

                                        <div class="chart">
                                            <canvas id="chart_line_9" height="200" width="1050"></canvas>   
                                        </div>
                                    </div>

                                    <!-- <div id="Ivr_tab" class="subcat_content">
                                         OBD and IVR
                                    </div> -->

                                </div>

                            </div>

                        </div>
                        <!-- /#design -->
                        
                        <div role="tabpanel" class="tab-pane fade" id="marketing">
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    <div class="subcat-nav">
                                        <ul class="list-unstyled">
                                            <li id="smsCampaign_nav" class="active">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/message-on-phone-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">1,510</span> Campaigns - SMS Campaigns </span> </a>
                                            </li>

                                            <li id="EmailCampaign_nav">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/email-send-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">3,518</span> Campaigns - Email Campaigns </span></a>
                                            </li>


                                            <li id="IvrCampaign_nav">
                                                <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/ivr-phone-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">5</span> Campaigns - OBD and IVR Campaigns </span></a>

                                            </li>

                                            <li id="GoogleCampaign_nav">
                                            <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/email-send-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">10</span> Campaigns - Google Ads Campaigns </span></a>
                                            </li>

                                            
                                            <li id="FBCampaign_nav">
                                            <a href="javascript:void(0);" class="clearfix"><img src="{{ asset('images/email-send-icon.png')}}" alt="" class="pull-left"> <span class="fl"> <span class="count">15</span> Campaigns - Facebook Ads Campaigns </span></a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-9">
                                    <div id="smsCampaign_tab" class="subcat_content" style="display: block;">
                                        
                                        <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Campaigns</h4>
                                                <div id="justgage_5" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>SMS Sent</h4>
                                                <div id="justgage_6" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Total Delivered</h4>
                                                <div id="justgage_7" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Total Pending</h4>
                                                <div id="justgage_8" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">

                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange2" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>


                                        <div class="chart">
                                            <canvas id="chart_line_2" height="200" width="1050"></canvas>   
                                        </div>

                                        <hr class="divider">

                                        <div class="pad_top15 text-right">
                                            <a href="{{url('/sms')}}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> View Detailed Report</a>
                                        </div>

                                    </div>



                                    <div id="EmailCampaign_tab" class="subcat_content">
                                         
                                         <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Opened</h4>
                                                <div id="justgage_37" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Clicked</h4>
                                                <div id="justgage_38" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Bounced</h4>
                                                <div id="justgage_39" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Spam</h4>
                                                <div id="justgage_40" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">

                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange2" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>


                                        <div class="chart">
                                            <canvas id="chart_line_10" height="200" width="1050"></canvas>   
                                        </div>

                                        <hr class="divider">

                                        <div class="pad_top15 text-right">
                                            <a href="{{url('/email')}}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> View Detailed Report</a>
                                        </div>

                                    </div>


                                    <div id="IvrCampaign_tab" class="subcat_content">
                                         
                                         <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Campaigns</h4>
                                                <div id="justgage_9" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>OBD Sent</h4>
                                                <div id="justgage_10" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Total Delivered</h4>
                                                <div id="justgage_11" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Total Pending</h4>
                                                <div id="justgage_12" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">

                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange2" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>


                                        <div class="chart">
                                            <canvas id="chart_line_3" height="200" width="1050"></canvas>   
                                        </div>

                                        <hr class="divider">

                                        <div class="pad_top15 text-right">
                                            <a href="{{url('/invitations-and-rsvp')}}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> View Detailed Report</a>
                                        </div>

                                    </div>


                                    <div id="GoogleCampaign_tab" class="subcat_content">
                                         
                                         <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Total Campaigns</h4>
                                                <div id="justgage_13" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Impressions</h4>
                                                <div id="justgage_14" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Clicks</h4>
                                                <div id="justgage_15" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Conversions</h4>
                                                <div id="justgage_16" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">

                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange2" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>


                                        <div class="chart">
                                            <canvas id="chart_line_4" height="200" width="1050"></canvas>   
                                        </div>

                                        <hr class="divider">

                                        <div class="pad_top15 text-right">
                                            <a href="{{url('/email')}}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> View Detailed Report</a>
                                        </div>

                                    </div>

                                    <div id="FBCampaign_tab" class="subcat_content">
                                         
                                         <div class="row text-center justgage_section">
                                            <div class="col-md-3">
                                                <h4>Total Campaigns</h4>
                                                <div id="justgage_17" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Impressions</h4>
                                                <div id="justgage_18" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Clicks</h4>
                                                <div id="justgage_19" style="height:150px"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <h4>Conversions</h4>
                                                <div id="justgage_20" style="height:150px"></div>
                                            </div>
                                        </div>

                                        <hr class="divider">

                                        <div class="daterange_parent" class="clearfix">
                                            <div id="reportrange2" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>


                                        <div class="chart">
                                            <canvas id="chart_line_5" height="200" width="1050"></canvas>   
                                        </div>

                                        <hr class="divider">

                                        <div class="pad_top15 text-right">
                                            <a href="{{url('/email')}}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> View Detailed Report</a>
                                        </div>

                                    </div>


                                    

                                </div>
                            </div>
                        </div>
                        <!-- /#marketing -->

                      </div>

                    </div>

            </div>


        </div>

    </div>
</section>

<script>
    $("#Newsletter_nav").click(function(){
        $("#design .subcat_content").hide();
        $("#design #Newsletter_tab.subcat_content").show();

        $("#design .subcat-nav li").removeClass("active");
        $("#design .subcat-nav li#Newsletter_nav").addClass("active");
    });

    $("#LandingPages_nav").click(function(){
        $("#design .subcat_content").hide();
        $("#design #LandingPages_tab.subcat_content").show();

        $("#design .subcat-nav li").removeClass("active");
        $("#design .subcat-nav li#LandingPages_nav").addClass("active");
    });

    $("#Surveys_nav").click(function(){
        $("#design .subcat_content").hide();
        $("#design #Surveys_tab.subcat_content").show();

        $("#design .subcat-nav li").removeClass("active");
        $("#design .subcat-nav li#Surveys_nav").addClass("active");
    });

    $("#Polls_nav").click(function(){
        $("#design .subcat_content").hide();
        $("#design #Polls_tab.subcat_content").show();

        $("#design .subcat-nav li").removeClass("active");
        $("#design .subcat-nav li#Polls_nav").addClass("active");
    });

    $("#Invitations_nav").click(function(){
        $("#design .subcat_content").hide();
        $("#design #Invitations_tab.subcat_content").show();

        $("#design .subcat-nav li").removeClass("active");
        $("#design .subcat-nav li#Invitations_nav").addClass("active");
    });

    $("#Ivr_nav").click(function(){
        $("#design .subcat_content").hide();
        $("#design #Ivr_tab.subcat_content").show();

        $("#design .subcat-nav li").removeClass("active");
        $("#design .subcat-nav li#Ivr_nav").addClass("active");
    });

    $("#smsCampaign_nav").click(function(){
        $("#marketing .subcat_content").hide();
        $("#marketing #smsCampaign_tab.subcat_content").show();

        $("#marketing .subcat-nav li").removeClass("active");
        $("#marketing .subcat-nav li#smsCampaign_nav").addClass("active");
    });

    $("#EmailCampaign_nav").click(function(){
        $("#marketing .subcat_content").hide();
        $("#marketing #EmailCampaign_tab.subcat_content").show();

        $("#marketing .subcat-nav li").removeClass("active");
        $("#marketing .subcat-nav li#EmailCampaign_nav").addClass("active");
    });


    $("#GoogleCampaign_nav").click(function(){
        $("#marketing .subcat_content").hide();
        $("#marketing #GoogleCampaign_tab.subcat_content").show();

        $("#marketing .subcat-nav li").removeClass("active");
        $("#marketing .subcat-nav li#GoogleCampaign_nav").addClass("active");
    });

    $("#FBCampaign_nav").click(function(){
        $("#marketing .subcat_content").hide();
        $("#marketing #FBCampaign_tab.subcat_content").show();

        $("#marketing .subcat-nav li").removeClass("active");
        $("#marketing .subcat-nav li#FBCampaign_nav").addClass("active");
    });

    $("#IvrCampaign_nav").click(function(){
        $("#marketing .subcat_content").hide();
        $("#marketing #IvrCampaign_tab.subcat_content").show();

        $("#marketing .subcat-nav li").removeClass("active");
        $("#marketing .subcat-nav li#IvrCampaign_nav").addClass("active");
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.3.5/justgage.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
$(document).ready(function () {

    var justgage_1 = new JustGage({
            id: "justgage_1",
            value: 48.9,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "204,512",
            relativeGaugeSize: true,
    });

    var justgage_2 = new JustGage({
            id: "justgage_2",
            value: 22.4,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "93,264",
            relativeGaugeSize: true,
    });

    var justgage_3 = new JustGage({
            id: "justgage_3",
            value: 11.3,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "5,436",
            relativeGaugeSize: true,
    });

    var justgage_4 = new JustGage({
            id: "justgage_4",
            value: 2.7,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "120",
            relativeGaugeSize: true,
    });

    var justgage_5 = new JustGage({
            id: "justgage_5",
            value: 62.4,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "204,512",
            relativeGaugeSize: true,
    });

    var justgage_6 = new JustGage({
            id: "justgage_6",
            value: 45.5,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "93,264",
            relativeGaugeSize: true,
    });

    var justgage_7 = new JustGage({
            id: "justgage_7",
            value: 15.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "5,436",
            relativeGaugeSize: true,
    });

    var justgage_8 = new JustGage({
            id: "justgage_8",
            value: 4.7,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "120",
            relativeGaugeSize: true,
    });

    var justgage_9 = new JustGage({
            id: "justgage_9",
            value: 58.6,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "54,456",
            relativeGaugeSize: true,
    });

    var justgage_10 = new JustGage({
            id: "justgage_10",
            value: 27.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "21,578",
            relativeGaugeSize: true,
    });

    var justgage_11 = new JustGage({
            id: "justgage_11",
            value: 15.8,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "7578",
            relativeGaugeSize: true,
    });

    var justgage_12 = new JustGage({
            id: "justgage_12",
            value: 5.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "1050",
            relativeGaugeSize: true,
    });

    var justgage_13 = new JustGage({
            id: "justgage_13",
            value: 60.5,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "5732",
            relativeGaugeSize: true,
    });

    var justgage_14 = new JustGage({
            id: "justgage_14",
            value: 20.7,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "1132",
            relativeGaugeSize: true,
    });

    var justgage_15 = new JustGage({
            id: "justgage_15",
            value: 16.5,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "845",
            relativeGaugeSize: true,
    });

    var justgage_16 = new JustGage({
            id: "justgage_16",
            value: 3.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_17 = new JustGage({
            id: "justgage_17",
            value: 36.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "126",
            relativeGaugeSize: true,
    });
    var justgage_18 = new JustGage({
            id: "justgage_18",
            value: 60.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "126",
            relativeGaugeSize: true,
    });
    var justgage_19 = new JustGage({
            id: "justgage_19",
            value: 80.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "126",
            relativeGaugeSize: true,
    });
    var justgage_20 = new JustGage({
            id: "justgage_20",
            value: 40.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_21 = new JustGage({
            id: "justgage_21",
            value: 80.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_22 = new JustGage({
            id: "justgage_22",
            value: 60.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_23 = new JustGage({
            id: "justgage_23",
            value: 40.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "126",
            relativeGaugeSize: true,
    });
    var justgage_24 = new JustGage({
            id: "justgage_24",
            value: 20.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_25 = new JustGage({
            id: "justgage_25",
            value: 20.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_26 = new JustGage({
            id: "justgage_26",
            value: 40.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_27 = new JustGage({
            id: "justgage_27",
            value: 60.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_28 = new JustGage({
            id: "justgage_28",
            value: 80.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_29 = new JustGage({
            id: "justgage_29",
            value: 80.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_30 = new JustGage({
            id: "justgage_30",
            value: 60.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_31 = new JustGage({
            id: "justgage_31",
            value: 40.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_32 = new JustGage({
            id: "justgage_32",
            value: 20.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_33 = new JustGage({
            id: "justgage_33",
            value: 80.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_34 = new JustGage({
            id: "justgage_34",
            value: 60.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_35 = new JustGage({
            id: "justgage_35",
            value: 40.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "126",
            relativeGaugeSize: true,
    });
    var justgage_36 = new JustGage({
            id: "justgage_36",
            value: 30.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_37 = new JustGage({
            id: "justgage_37",
            value: 58.6,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f2553f"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_38 = new JustGage({
            id: "justgage_38",
            value: 27.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#768fcb"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_39 = new JustGage({
            id: "justgage_39",
            value: 15.8,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#29bb9c"],
            label: "126",
            relativeGaugeSize: true,
    });

    var justgage_40 = new JustGage({
            id: "justgage_40",
            value: 5.2,
            decimals: 1,
            symbol: '%',
            min: 0,
            max: 100,
            counter: true,
            donut: true,
            gaugeWidthScale: 0.5,
            valueFontColor: ["#2c2c2c"],
            levelColors: ["#f39c11"],
            label: "126",
            relativeGaugeSize: true,
    });


// chart js starts

    if( $('#chart_line_1').length > 0 ){
        var ctx1 = document.getElementById("chart_line_1").getContext("2d");

        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Opened",
                backgroundColor: "#fff",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [0, 0, 2, 0, 0, 1, 0, 0, 1, 1, 0, 2, 0, 5, 1]
            },
            {
                label: "Clicked",
                backgroundColor: "#fff",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5]
            },
            {
                label: "Bounce",
                backgroundColor: "#fff",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10]
            },
            {
                label: "Spam",
                backgroundColor: "#fff",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [10, 8, 10, 10, 8, 10, 8, 8, 8, 10, 10, 10, 10, 10, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }


    if( $('#chart_line_2').length > 0 ){
        var ctx1 = document.getElementById("chart_line_2").getContext("2d");
        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Campaigns",
                backgroundColor: "#c7d6fa",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [3, 0, 2, 0, 2, 1, 0, 1, 4, 1, 0, 2, 0, 2, 1]
            },
            {
                label: "SMS Sent",
                backgroundColor: "#edfdf3",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [4, 5, 5, 4, 5, 5, 4, 5, 5, 5, 5, 4, 5, 5, 5]
            },
            {
                label: "Total Delivered",
                backgroundColor: "#fbe8ca",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [9, 10, 10, 10, 10, 9, 10, 10, 10, 10, 8, 10, 10, 9, 10]
            },
            {
                label: "Total Pending",
                backgroundColor: "#f9e2d1",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [7, 8, 10, 10, 8, 9, 8, 9, 8, 10, 10, 9, 10, 8, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }


    if( $('#chart_line_3').length > 0 ){
        var ctx1 = document.getElementById("chart_line_3").getContext("2d");
        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Campaigns",
                backgroundColor: "#c7d6fa",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [0, 3, 2, 0, 0, 1, 0, 1, 2, 1, 0, 0, 0, 4, 1]
            },
            {
                label: "OBD Sent",
                backgroundColor: "#edfdf3",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [4, 4, 5, 3, 5, 5, 5, 5, 2, 5, 5, 5, 5, 4, 5]
            },
            {
                label: "Total Delivered",
                backgroundColor: "#fbe8ca",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [9, 10, 11, 10, 10, 9, 10, 10, 8, 10, 10, 10, 9, 10, 10]
            },
            {
                label: "Total Pending",
                backgroundColor: "#f9e2d1",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [8, 8, 9, 10, 8, 10, 8, 9, 8, 10, 10, 8, 10, 9, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }

    if( $('#chart_line_4').length > 0 ){
        var ctx1 = document.getElementById("chart_line_4").getContext("2d");
        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Total Campaigns",
                backgroundColor: "#c7d6fa",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [3, 0, 2, 0, 2, 1, 0, 1, 4, 1, 0, 2, 0, 2, 1]
            },
            {
                label: "Impressions",
                backgroundColor: "#edfdf3",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [4, 5, 5, 4, 5, 5, 4, 5, 5, 5, 5, 4, 5, 5, 5]
            },
            {
                label: "Clicks",
                backgroundColor: "#fbe8ca",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [9, 10, 10, 10, 10, 9, 10, 10, 10, 10, 8, 10, 10, 9, 10]
            },
            {
                label: "Conversions",
                backgroundColor: "#f9e2d1",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [7, 8, 10, 10, 8, 9, 8, 9, 8, 10, 10, 9, 10, 8, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }

    if( $('#chart_line_5').length > 0 ){
        var ctx1 = document.getElementById("chart_line_5").getContext("2d");
        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Total Campaigns",
                backgroundColor: "#c7d6fa",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [0, 3, 2, 0, 0, 1, 0, 1, 2, 1, 0, 0, 0, 4, 1]
            },
            {
                label: "Impressions",
                backgroundColor: "#edfdf3",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [4, 4, 5, 3, 5, 5, 5, 5, 2, 5, 5, 5, 5, 4, 5]
            },
            {
                label: "Clicks",
                backgroundColor: "#fbe8ca",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [9, 10, 11, 10, 10, 9, 10, 10, 8, 10, 10, 10, 9, 10, 10]
            },
            {
                label: "Conversions",
                backgroundColor: "#f9e2d1",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [8, 8, 9, 10, 8, 10, 8, 9, 8, 10, 10, 8, 10, 9, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }

    if( $('#chart_line_6').length > 0 ){
        var ctx1 = document.getElementById("chart_line_6").getContext("2d");
        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Opened",
                backgroundColor: "#c7d6fa",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [0, 3, 2, 0, 0, 1, 0, 1, 2, 1, 0, 0, 0, 4, 1]
            },
            {
                label: "Clicked",
                backgroundColor: "#edfdf3",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [4, 4, 5, 3, 5, 5, 5, 5, 2, 5, 5, 5, 5, 4, 5]
            },
            {
                label: "Bounce",
                backgroundColor: "#fbe8ca",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [9, 10, 11, 10, 10, 9, 10, 10, 8, 10, 10, 10, 9, 10, 10]
            },
            {
                label: "Spam",
                backgroundColor: "#f9e2d1",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [8, 8, 9, 10, 8, 10, 8, 9, 8, 10, 10, 8, 10, 9, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }

    if( $('#chart_line_7').length > 0 ){
        var ctx1 = document.getElementById("chart_line_7").getContext("2d");

        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Opened",
                backgroundColor: "#fff",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [0, 0, 2, 0, 0, 1, 0, 0, 1, 1, 0, 2, 0, 5, 1]
            },
            {
                label: "Clicked",
                backgroundColor: "#fff",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5]
            },
            {
                label: "Bounce",
                backgroundColor: "#fff",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10]
            },
            {
                label: "Spam",
                backgroundColor: "#fff",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [10, 8, 10, 10, 8, 10, 8, 8, 8, 10, 10, 10, 10, 10, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }

    if( $('#chart_line_8').length > 0 ){
        var ctx1 = document.getElementById("chart_line_8").getContext("2d");
        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Opened",
                backgroundColor: "#c7d6fa",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [0, 3, 2, 0, 0, 1, 0, 1, 2, 1, 0, 0, 0, 4, 1]
            },
            {
                label: "Clicked",
                backgroundColor: "#edfdf3",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [4, 4, 5, 3, 5, 5, 5, 5, 2, 5, 5, 5, 5, 4, 5]
            },
            {
                label: "Bounce",
                backgroundColor: "#fbe8ca",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [9, 10, 11, 10, 10, 9, 10, 10, 8, 10, 10, 10, 9, 10, 10]
            },
            {
                label: "Spam",
                backgroundColor: "#f9e2d1",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [8, 8, 9, 10, 8, 10, 8, 9, 8, 10, 10, 8, 10, 9, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }

    if( $('#chart_line_9').length > 0 ){
        var ctx1 = document.getElementById("chart_line_9").getContext("2d");

        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Opened",
                backgroundColor: "#fff",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [0, 0, 2, 0, 0, 1, 0, 0, 1, 1, 0, 2, 0, 5, 1]
            },
            {
                label: "Clicked",
                backgroundColor: "#fff",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5]
            },
            {
                label: "Bounce",
                backgroundColor: "#fff",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10]
            },
            {
                label: "Spam",
                backgroundColor: "#fff",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [10, 8, 10, 10, 8, 10, 8, 8, 8, 10, 10, 10, 10, 10, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }


    if( $('#chart_line_10').length > 0 ){
        var ctx1 = document.getElementById("chart_line_10").getContext("2d");
        var data1 = {
            labels: ["Jan 16", "Jan 18", "Jan 20", "Jan 22", "Jan 24", "Jan 26", "Jan 28", "Jan 30", "Feb 01", "Feb 03", "Feb 05", "Feb 07", "Feb 09", "Feb 11", "Feb 13"],
            datasets: [
            {
                label: "Opened",
                backgroundColor: "#c7d6fa",
                borderColor: "#768fcb",
                pointBorderColor: "#768fcb",
                pointBackgroundColor: "#768fcb",
                data: [0, 0, 2, 0, 0, 1, 0, 0, 1, 1, 0, 2, 0, 5, 1]
            },
            {
                label: "Clicked",
                backgroundColor: "#edfdf3",
                borderColor: "#29bb9c",
                pointBorderColor: "#29bb9c",
                pointBackgroundColor: "#29bb9c",
                data: [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5]
            },
            {
                label: "Bounce",
                backgroundColor: "#fbe8ca",
                borderColor: "#f39c11",
                pointBorderColor: "#f39c11",
                pointHighlightStroke: "#f39c11",
                data: [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10]
            },
            {
                label: "Spam",
                backgroundColor: "#f9e2d1",
                borderColor: "#f2553f",
                pointBorderColor: "#f2553f",
                pointHighlightStroke: "#f2553f",
                data: [10, 8, 10, 10, 8, 10, 8, 8, 8, 10, 10, 10, 10, 10, 8]
            }
        ]
        };
        
        var areaChart = new Chart(ctx1, {
            type:"line",
            data:data1,
            
            options: {
                tooltips: {
                    mode:"label"
                },
                elements:{
                    point: {
                        hitRadius:90
                    }
                },
                
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(135,135,135,0)",
                        },
                        ticks: {
                            fontFamily: "Poppins",
                            fontColor:"#878787"
                        }
                    }]
                },
                animation: {
                    duration:   3000
                },
                responsive: false,
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor:'rgba(33,33,33,1)',
                    cornerRadius:0,
                    footerFontFamily:"'Poppins'"
                }
                
            }
        });
    }

    
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        } 

        $('#reportrange').daterangepicker({
            parentEl: '.daterange_parent2',
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);


        function cb2(start, end) {
            $('#reportrange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange2').daterangepicker({
            parentEl: '.daterange_parent2',
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb2);

        cb2(start, end);

    });
                                    
    
});
</script>

@stop



