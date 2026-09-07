@extends('layouts.frontLayout.front-layout')
@section('content')

<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

    <div class="right-panel">
        <div class="container-fluid">
            
            <div class="planline page-title pad_top10">
                <span>Statistics & Reports</span>
                <ul class="nav navbar-nav navbar-right mar_bottom15">
                    <li>
                        <a class="btn btn-primary" href="#">Create Invitations and RSVP's</a>
                    </li>
                </ul>
            </div>

            <div class="row">


                <div class="col-lg-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="get" action="">
                                <div class="row datepicker-form">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Select Date Range:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input type="date" name="from" class="form-control date" >
                                        <small>Select From Date</small>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input type="date" name="to" class="form-control date" >
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
            
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="total-boxes-wrap box-1">
                        <div class="media">
                            <div class="media-left">
                               
                                <figure><img class="media-object" src="{{ asset('images/design-newsletter-icon.png')}}"></figure>
                            </div>
                            <div class="media-body text-right">
                                <h4 class="media-heading">25</h4>
                                <p>Total Invitations and RSVP's</p>
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
                                <h4 class="media-heading">25</h4>
                                <p>Total Sent</p>
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
                                <h4 class="media-heading"> 18</h4>
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
                            <h3 class="panel-title"><i class="fa fa-pie-chart"></i> Invitations and RSVP's</h3>
                        </div>
                        <div class="panel-body dash-summary-panel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>Sr No.</th> -->
                                <th>Name</th>
                                <th>Sender Id</th>
                                <th>List Name</th>
                                <th>Total Invitations and RSVP's</th>
                                <th>Submit Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td colspan="6" class="text-center">
                                    No Result found. 
                                    <a href="#" class="btn btn-primary btn-sm mar_left15"><i class="fa fa-plus-circle" aria-hidden="true"></i>
 Create New Invitations and RSVP's</a>
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
@stop