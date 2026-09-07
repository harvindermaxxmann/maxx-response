@extends('layouts.frontLayout.front-layout')
@section('content')

<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

    <div class="right-panel">
        <div class="container-fluid">

                <div class="planline page-title pad_top10 mar_bottom15">
                    <span>Campaigns Overview</span>
                    <ul class="nav navbar-nav navbar-right mar_bottom15">
                        <li>
                            <a class="btn btn-primary" href="{{url('/newsletter/choose-html-or-plain')}}">Create Email Campaign</a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Recent Campaigns</h3></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-8">
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option value="Credence Medicare Test">Credence Medicare Test</option>
                                                <option value="Credence Medicare Test1">Credence Medicare Test1</option>
                                                <option value="Credence Medicare Test2">Credence Medicare Test2</option>
                                            </select>
                                            <p><span class="text-success"><i class="fa fa-square" aria-hidden="true"></i></span>&nbsp;&nbsp;<small>Sent On 12/13/2018 06:40PM IST</small></p>
                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-md-4 text-right">
                                        <a href="{{url('/email-campaign-details')}}" class="btn btn-success mar_top10">View Reports</a>
                                    </div>
                                </div>
                                <!-- end of row -->
                                <div class="clearfix"></div>
                                <p class="text-center">4 Messages Sent</p>
                                <div class="progress multiprog">
                                    <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="row indic">
                                    <div class="col-xs-12 col-md-4">
                                        <p><span class="text-warning"><i class="fa fa-square" aria-hidden="true"></i></span>&nbsp;&nbsp;<small>50.0% - Opened</small></p>
                                    </div>
                                    <div class="col-xs-12 col-md-4 text-center">
                                        <p><span class="text-success"><i class="fa fa-square" aria-hidden="true"></i></span>&nbsp;&nbsp;<small>20.0% - Opened</small></p>
                                    </div>
                                    <div class="col-xs-12 col-md-4 text-right">
                                        <p><span class="text-primary"><i class="fa fa-square" aria-hidden="true"></i></span>&nbsp;&nbsp;<small>30.0% - Unopened</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix"><h3 class="panel-title pull-left">Regular Campaigns</h3> <a href="javascript:;" class="pull-right"><i class="fa fa-plus"></i></a></div>
                            <div class="panel-body">

                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-4 text-center">
                                                    <h1>52</h1>
                                                    <p><small>Sent</small></p>
                                                </div>
                                                <div class="col-xs-12 col-md-4 text-center">
                                                    <h1>30</h1>
                                                    <p><small>Scheduled</small></p>
                                                </div>
                                                <div class="col-xs-12 col-md-4 text-center">
                                                    <h1>29</h1>
                                                    <p><small>Drafts</small></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-4 text-center">
                                                    <h1>5</h1>
                                                    <p>Sent</p>
                                                </div>
                                                <div class="col-xs-12 col-md-4 text-center">
                                                    <h1>0</h1>
                                                    <p>Scheduled</p>
                                                </div>
                                                <div class="col-xs-12 col-md-4 text-center">
                                                    <h1>9</h1>
                                                    <p>Drafts</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Indicators -->
                                    <ol class="carousel-indicators" style="bottom:-17px;">
                                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>

                                    </ol>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- row close -->

                <div class="col-xs-12 col-md-12 p-0">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left">Contacts </h3>
                            <a href="{{url('/add-contact/single')}}" class="pull-right btn btn-link p-0"><i class="fa fa-plus"></i> Add Contact</a></div>
                        <div class="panel-body">

                            <div class="form-group col-xs-12 col-md-2 p-0" style="margin-bottom: 0px;">
                                <select class="form-control">
                                    <option value="Last 30 days">Last 30 days</option>
                                    <option value="Last 35 days">Last 35 days</option>
                                </select>
                            </div>

                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-xs-12 col-md-8">
                                    <h3 class="text-center mar_top50">No Data Available</h3>
                                </div>
                                <div class="col-xs-12 col-md-4 text-center" style="border-left:solid 1px #ddd;">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6 mar_top15">
                                            <h3>690</h3>
                                            <p>Total Contact</p>
                                        </div>

                                        <div class="col-xs-12 col-md-6 mar_top15">
                                            <h3>236</h3>
                                            <p>Recently Added</p>
                                        </div>

                                        <div class="col-xs-12 col-md-6 mar_top15">
                                            <h3>5</h3>
                                            <p>Unsubscribes</p>
                                        </div>

                                        <div class="col-xs-12 col-md-6 mar_top15">
                                            <h3>2</h3>
                                            <p>Bounces</p>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>

                                    <p><a href="{{url('/contact-lists')}}" class="btn btn-success mar_top20">View Mailing Group</a></p>

                                </div>
                                <!-- col-md-4 -->
                            </div>

                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 emaildelv">
                        <ul>
                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-md-8">
                                        <div class="media">
                                            <div class="media-left">
                                                <span class="media-object"><a href="{{url('/email-campaign-details')}}"><i class="fa fa-envelope-square fa-4x"></i></a></span>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="{{url('/email-campaign-details')}}">Credence Medicure Corporation</a></h4>
                                                <p><span class="text-success"><i class="fa fa-square" aria-hidden="true"></i></span>&nbsp;&nbsp;<small>Sent On 05/13/2018 16:40PM IST</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4 text-center">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>80%</h4>
                                                    <p><small>Delivered</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
                                                            80%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>100%</h4>
                                                    <p><small>Opened</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                            100%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>60%</h4>
                                                    <p><small>Clicked</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            60%
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- row close -->

                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-md-8">
                                        <div class="media">
                                            <div class="media-left">
                                                <span class="media-object"><a href="{{url('/email-campaign-details')}}"><i class="fa fa-envelope-square fa-4x"></i></a></span>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="{{url('/email-campaign-details')}}">Riverpool Holidays</a></h4>
                                                <p><span class="text-success"><i class="fa fa-square" aria-hidden="true"></i></span>&nbsp;&nbsp;<small>Sent On 09/13/2019 09:30AM IST</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4 text-center">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>80%</h4>
                                                    <p><small>Delivered</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
                                                            80%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>100%</h4>
                                                    <p><small>Opened</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                            100%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>60%</h4>
                                                    <p><small>Clicked</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            60%
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- row close -->

                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-md-8">
                                        <div class="media">
                                            <div class="media-left">
                                                <span class="media-object"><a href="{{url('/email-campaign-details')}}"><i class="fa fa-envelope-square fa-4x"></i></a></span>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="{{url('/email-campaign-details')}}">Maxxmann Communications</a></h4>
                                                <p><span class="text-success"><i class="fa fa-square" aria-hidden="true"></i></span>&nbsp;&nbsp;<small>Sent On 12/10/2019 13:29PM IST</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4 text-center">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>80%</h4>
                                                    <p><small>Delivered</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
                                                            80%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>100%</h4>
                                                    <p><small>Opened</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                            100%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>60%</h4>
                                                    <p><small>Clicked</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            60%
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- row close -->

                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-md-8">
                                        <div class="media">
                                            <div class="media-left">
                                                <span class="media-object"><a href="{{url('/email-campaign-details')}}"><i class="fa fa-envelope-square fa-4x"></i></a></span>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="{{url('/email-campaign-details')}}">NoContactKey</a></h4>
                                                <p><span class="text-success"><i class="fa fa-square" aria-hidden="true"></i></span>&nbsp;&nbsp;<small>Sent On 11/15/2020 08:50AM IST</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4 text-center">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>80%</h4>
                                                    <p><small>Delivered</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
                                                            80%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>100%</h4>
                                                    <p><small>Opened</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                            100%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <div class="deliverybox">
                                                    <h4>60%</h4>
                                                    <p><small>Clicked</small></p>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                            60%
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- row close -->
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- pick this section close dashboard-->
            </div>
    </div>

</section>
@stop