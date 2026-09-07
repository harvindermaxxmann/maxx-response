@extends('layouts.frontLayout.front-layout')
@section('content')

<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

    <div id="email_campaign_detail" class="right-panel">
        <div class="container-fluid">

                <div class="planline page-title pad_top10 text-center">
                    <span>Credence Medicure Corporation</span>
                </div>

                <div class="mngacount">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#Report">Report Summary</a></li>
                        <li><a data-toggle="tab" href="#List_based_Summary">Analysis Summary</a></li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div id="Report" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-xs-12 col-md-7">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Real-Time Campaign Data</h3></div>
                                    <div class="panel-body">
                                        <h3 class="text-center mar_top20">4 <span style="color: inherit; font-size: 0.7em;">Total Email Sent</span></h3>
                                        <p class="text-center">
                                            <small>12/13/2018  06:40 PM IST</small></p>
                                        <p class="text-right margin-0">100.00% + 0.00% + 0.00%</p>
                                        <div class="progress" style="height:30px;">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                <span class="sr-only">100% Complete</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="media-object text-success mar_top10"><i class="fa fa-square"></i></span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading mar_top10" style="font-weight:500;">Delivered&nbsp;&nbsp;100.00%</h5>
                                                        <p>4 Contacts</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-4 close -->
                                            <div class="col-xs-12 col-md-4">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="media-object text-danger mar_top10"><i class="fa fa-square"></i></span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading mar_top10" style="font-weight:500;">Bounces&nbsp;&nbsp;0.00%</h5>
                                                        <p>0 Contacts</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-4 close -->
                                            <div class="col-xs-12 col-md-4">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="media-object text-warning mar_top10"><i class="fa fa-square"></i></span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading mar_top10" style="font-weight:500;">Unsent&nbsp;&nbsp;0.00%</h5>
                                                        <p>0 Contacts</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- row close -->

                                        <p class="text-right margin-0">50.00% + 50.00%</p>

                                        <div class="xbar">
                                            <div class="progress" style="height:30px;">
                                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    <span class="sr-only">80% Complete</span>
                                                </div>
                                            </div>
                                            <div class="progress" style="height:12px;">
                                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    <span class="sr-only">50% Complete</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="media-object text-warning mar_top10"><i class="fa fa-square"></i></span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading mar_top10" style="font-weight:500;">Unique Opens&nbsp;&nbsp;50.00%</h5>
                                                        <p>2 Contacts</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-4 close -->
                                            <div class="col-xs-12 col-md-4">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="media-object text-info mar_top10"><i class="fa fa-square"></i></span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading mar_top10" style="font-weight:500;">Unique Clicks&nbsp;&nbsp;50.00%</h5>
                                                        <p>2 Contacts</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-4 close -->
                                            <div class="col-xs-12 col-md-4">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="media-object text-default mar_top10"><i class="fa fa-square"></i></span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading mar_top10" style="font-weight:500;">Unopened&nbsp;&nbsp;50.00%</h5>
                                                        <p>2 Contacts</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- row close  -->

                                            <div class="col-xs-12 col-md-4">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="media-object text-warning mar_top10"><i class="fa fa-squaremul"></i></span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading mar_top10" style="font-weight:500;">Clicks / Opens Rate&nbsp;&nbsp;100.00%</h5>
                                                        <!--p>2 Contacts</p-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-4 close -->
                                            <div class="col-xs-12 col-md-4">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="media-object text-info mar_top10"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading mar_top10" style="font-weight:500;">Unsubscribe&nbsp;&nbsp;0.00%</h5>
                                                        <p>2 Contacts</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-4 close -->
                                           
                                        </div>
                                        <!-- row close -->
                                    </div>
                                </div>
                                <!-- panel close -->
                            </div>
                            <!-- col-md-6 close -->
                            <div class="col-xs-12 col-md-5">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Campaign Reach</h3></div>
                                    <div class="panel-body text-center">
                                        <div class="wrapper">
                                            <canvas id="chart-1"></canvas>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="well col-xs-12 col-md-12 mar_top15">
                                            <span class="pull-left" style="color:#333;"><i class="fa fa-square" style="color:#ff9900;"></i>&nbsp;&nbsp; Email</span>
                                            <a href="javascript:;" class="pull-right" style="color:#333;">236 Views</a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <p>sharing this campaign on social media cam help you increase your reach.
                                            <br/><a href="javascript:;">Share now</a></p>

                                    </div>
                                </div>

                            </div>
                            <!-- col-md-6 close -->
                        </div>
                        <!-- row close -->

                        <div class="clearfix"></div>

                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Opens by Time</h3></div>
                            <div class="panel-body">
                                <canvas id="canvas"></canvas>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Opens by Locations</h3></div>
                            <div class="panel-body">
                                <div id="worldmap1" style="width: 1000px; height: 400px; margin:0 auto;"></div>
                                <div class="clearfix"></div>
                                <div style="width: 1000px; height: auto; margin:0 auto;">
                                    <div class="my-js-slider"></div>
                                    <div class="clearfix"></div>
                                    <ul class="xstep1">
                                        <li>0</li>
                                        <li>4</li>
                                        <li>8</li>
                                        <li>12</li>
                                        <li>16</li>
                                        <li>20</li>
                                        <li>14</li>
                                        <li>18</li>
                                        <li>22</li>
                                        <li>26</li>
                                        <li>28</li>
                                        <li>32</li>
                                        <li>36</li>
                                        <li>40</li>

                                    </ul>

                                    <div class="clearfix"></div>
                                    <p class="text-center">Scale Percentage for Open Location</p>
                                    <p class="text-center margin-0">Email opens from unknown location - 1</p>

                                </div>
                            </div>
                        </div>
                        

                        <div class="clearfix"></div>

                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Subject and Sender Details</h3></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-3 imgxn">
                                        <img src="{{url('images/crd.jpg')}}" alt="imgnp" class="img-responsive" />
                                    </div>

                                    <div class="col-xs-12 col-md-9">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td width="400">Subject:</td>
                                                        <td>Good News! Credence is now open for Doctor’s Registration</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sender Name:</td>
                                                        <td>Credence Medicare Corporation</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sender Address:</td>
                                                        <td>digital@credencemedicure.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Reply-to Address:</td>
                                                        <td>digital@credencemedicure.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Content Type:</td>
                                                        <td>HTML and Plain Text</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Created On:</td>
                                                        <td>12/13/2018&nbsp;&nbsp;06:36 PM </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                    <!-- report  -->

                    <!-- list based summary -->
                    <div id="List_based_Summary" class="tab-pane fade">

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h3 class="panel-title">Audience Overview</h3>
                            </div>

                            <div class="panel-body dash-summary-panel">

                                <div class="line-chart-wrap">
                                    <div class="graph-boxes">
                                        <p>Users</p>
                                        <h5>150</h5>
                                        <div class="wrapper">
                                            <span class="line-1">2,5,9,6,5,3,7,9</span>
                                        </div>
                                    </div>

                                    <div class="graph-boxes">
                                        <p>New Users</p>
                                        <h5>45</h5>
                                        <div class="wrapper">
                                            <span class="line-1">2,5,9,6,5,3,7,9</span>
                                        </div>
                                    </div>

                                    <div class="graph-boxes">
                                        <p>Sessions</p>
                                        <h5>212</h5>
                                        <div class="wrapper">
                                            <span class="line-1">2,5,9,6,5,3,7,9</span>
                                        </div>
                                    </div>

                                    <div class="graph-boxes">
                                        <p>Bounce Rate</p>
                                        <h5>15.91%</h5>
                                        <div class="wrapper">
                                            <span class="line-1">2,5,9,6,5,3,7,9</span>
                                        </div>
                                    </div>

                                    <div class="graph-boxes">
                                        <p>Conversions</p>
                                        <h5>115</h5>
                                        <div class="wrapper">
                                            <span class="line-1">2,5,9,6,5,3,7,9</span>
                                        </div>
                                    </div>

                                    <div class="graph-boxes">
                                        <p>Conversions Rate</p>
                                        <h5>4.54%</h5>
                                        <div class="wrapper">
                                            <span class="line-1">2,5,9,6,5,3,7,9</span>
                                        </div>
                                    </div>

                                    
                                </div>

                            </div>

                        </div>


                        <div class="mar_top20">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Geo Location</h3>
                                </div>
                            
                            <div class="panel-body dash-summary-panel">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Country</th>
                                                <th>Users</th>
                                                <th>New Users</th>
                                                <th>Sessions</th>
                                                <th>Bounce Rate</th>
                                                <th>Conversions</th>
                                                <th>Conversions Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>Canada</td>
                                                <td>10</td>
                                                <td>8</td>
                                                <td>11</td>
                                                <td>10.91%</td>
                                                <td>30</td>
                                                <td>22.75%</td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>India</td>
                                                <td>45</td>
                                                <td>22</td>
                                                <td>52</td>
                                                <td>12.53%</td>
                                                <td>70</td>
                                                <td>65.12%</td>
                                            </tr>
                                            <tr>
                                                <td>3.</td>
                                                <td>United States</td>
                                                <td>15</td>
                                                <td>7</td>
                                                <td>18</td>
                                                <td>8.58%</td>
                                                <td>15</td>
                                                <td>27.49%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row pad_top20">

                            <div class="col-xs-12 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Age Group</h3></div>
                                    <div class="panel-body">
                                        <div class="wrapper">
                                            <canvas id="chart-3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Gender</h3></div>
                                    <div class="panel-body">
                                        <div class="wrapper">
                                            <canvas id="chart-4"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Devices</h3></div>
                                    <div class="panel-body">
                                        <div class="wrapper">
                                            <canvas id="chart-0"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Operating System</h3></div>
                                    <div class="panel-body">
                                        <div class="wrapper">
                                            <canvas id="chart-5"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Browser</h3></div>
                                    <div class="panel-body">
                                        <div class="wrapper">
                                            <canvas id="chart-2"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Email Clients</h3></div>
                                    <div class="panel-body">
                                        <div class="wrapper">
                                            <canvas id="chart-1-1"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                        </div>
                        <!-- end row -->

                        

                        <div class="clearfix mar_bottom20">
                            <a class="btn btn-primary pull-right" href="#">Export Report</a>
                        </div>

                    </div>
                    <!-- list based summary close -->

                    

                </div>

                <!-- pick this section close dashboard-->
            </div>
    </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">

<script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/topojson/1.6.9/topojson.min.js"></script>

<script src="{{url('/js/front_js/datamaps.world.min.js')}}"></script>

<link rel="stylesheet" href="{{url('/css/front_css/wrunner-default-theme.css')}}">
<script src="{{url('/js/front_js/wrunner-native.js')}}"></script>

<script src="{{url('/js/front_js/jquery.peity.min.js')}}"></script>

<script>
    $("span.pie").peity("pie");

    $(".line-1").peity("line", {
        "height": 80,
        "width": 210
    });
</script>

<script>
    window.chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
};

(function(global) {
    var MONTHS = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    var COLORS = [
        '#4dc9f6',
        '#f67019',
        '#f53794',
        '#537bc4',
        '#acc236',
        '#166a8f',
        '#00a950',
        '#58595b',
        '#8549ba'
    ];

    var Samples = global.Samples || (global.Samples = {});
    var Color = global.Color;

    Samples.utils = {
        // Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
        srand: function(seed) {
            this._seed = seed;
        },

        rand: function(min, max) {
            var seed = this._seed;
            min = min === undefined ? 0 : min;
            max = max === undefined ? 1 : max;
            this._seed = (seed * 9301 + 49297) % 233280;
            return min + (this._seed / 233280) * (max - min);
        },

        numbers: function(config) {
            var cfg = config || {};
            var min = cfg.min || 0;
            var max = cfg.max || 1;
            var from = cfg.from || [];
            var count = cfg.count || 8;
            var decimals = cfg.decimals || 8;
            var continuity = cfg.continuity || 1;
            var dfactor = Math.pow(10, decimals) || 0;
            var data = [];
            var i, value;

            for (i = 0; i < count; ++i) {
                value = (from[i] || 0) + this.rand(min, max);
                if (this.rand() <= continuity) {
                    data.push(Math.round(dfactor * value) / dfactor);
                } else {
                    data.push(null);
                }
            }

            return data;
        },

        labels: function(config) {
            var cfg = config || {};
            var min = cfg.min || 0;
            var max = cfg.max || 100;
            var count = cfg.count || 8;
            var step = (max - min) / count;
            var decimals = cfg.decimals || 8;
            var dfactor = Math.pow(10, decimals) || 0;
            var prefix = cfg.prefix || '';
            var values = [];
            var i;

            for (i = min; i < max; i += step) {
                values.push(prefix + Math.round(dfactor * i) / dfactor);
            }

            return values;
        },

        months: function(config) {
            var cfg = config || {};
            var count = cfg.count || 12;
            var section = cfg.section;
            var values = [];
            var i, value;

            for (i = 0; i < count; ++i) {
                value = MONTHS[Math.ceil(i) % 12];
                values.push(value.substring(0, section));
            }

            return values;
        },

        color: function(index) {
            return COLORS[index % COLORS.length];
        },

        transparentize: function(color, opacity) {
            var alpha = opacity === undefined ? 0.5 : 1 - opacity;
            return Color(color).alpha(alpha).rgbString();
        }
    };

    // DEPRECATED
    window.randomScalingFactor = function() {
        return Math.round(Samples.utils.rand(-100, 100));
    };

    // INITIALIZATION

    Samples.utils.srand(Date.now());

    
    /* eslint-enable */

}(this));
</script>

<script>
        var ctx = document.getElementById('chart-1');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Total Reach'],
                datasets: [{
                    label: '# of Votes',
                    data: [236],
                    backgroundColor: [
                        'rgba(255, 153, 0, 1)'
                    ]
                }]
            },
            options: {
                legend: {
                    position: 'right'
                },

                title: {
                    display: true,
                    text: 'Total Reach 236'
                }

            }
        });

        // line

        function newDate(days) {
            return moment().add(days, 'd').toDate();
        }

        function newDateString(days) {
            return moment().add(days, 'd').format();
        }

        var color = Chart.helpers.color;
        var config = {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Opens',
                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.red,
                    fill: false,
                    data: [{
                        x: newDateString(0),
                        y: 0
                    }, {
                        x: newDateString(2),
                        y: 1
                    }, {
                        x: newDateString(4),
                        y: 2
                    }, {
                        x: newDateString(5),
                        y: 3
                    }, {
                        x: newDateString(6),
                        y: 4
                    }],
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: '-Opens'
                },
                scales: {
                    xAxes: [{
                        type: 'time',
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Periods'
                        },
                        ticks: {
                            major: {
                                fontStyle: 'bold',
                                fontColor: '#FF0000'
                            }
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Counts'
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myLine = new Chart(ctx, config);
        };

        var map = new Datamap({
            element: document.getElementById('worldmap1')
        });

        // three graph      
        var DATA_COUNT = 3;

        var utils = Samples.utils;

        utils.srand(110);

        function colorize(opaque, hover, ctx) {
            var v = ctx.dataset.data[ctx.dataIndex];
            var c = v < -50 ? '#D60000' : v < 0 ? '#F46300' : v < 50 ? '#0358B6' : '#44DE28';

            var opacity = hover ? 1 - Math.abs(v / 130) - 0.2 : 1 - Math.abs(v / 130);

            return opaque ? c : utils.transparentize(c, opacity);
        }

        function hoverColorize(ctx) {
            return colorize(false, true, ctx);
        }

        function generateData() {
            return utils.numbers({
                count: DATA_COUNT,
                min: -100,
                max: 100
            });
        }

        var data = {
            datasets: [{
                data: generateData(),
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)'
                ]
            }],

            labels: [
                'Mobile',
                'Tablet',
                'Computer'

            ]
        };

        var options = {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    fontColor: 'rgb(0, 0, 0)'
                }
            },
            tooltips: false,

            elements: {
                arc: {
                    backgroundColor: colorize.bind(null, false, false),
                    hoverBackgroundColor: hoverColorize
                }
            }
        };

        var chart = new Chart('chart-0', {
            type: 'doughnut',
            data: data,
            options: options

        });

        var ctx = document.getElementById('chart-1-1');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Thunderbird', 'Outlook', 'Lotus Notes', 'Apple Mail', 'Other'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(255, 159, 64)'
                    ]
                }]
            },
            options: {
                legend: {
                    position: 'right'
                }
            }
        });

        var ctx = document.getElementById('chart-2');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Chrome', 'Firefox', 'Internet Explorer', 'Safari', 'Opera', 'Other'],

                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 5],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(255, 100, 0)',
                        'rgba(255, 159, 64)'
                    ]
                }]
            },

            options: {
                legend: {
                    position: 'right'
                }
            }

        });



        var ctx = document.getElementById('chart-3');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['18-20', '21-25', '26-35', '36-50', '50-70', '71+'],

                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 5],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(255, 100, 0)',
                        'rgba(255, 159, 64)'
                    ]
                }]
            },

            options: {
                legend: {
                    position: 'right'
                }
            }
        });


        var ctx = document.getElementById('chart-4');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],

                datasets: [{
                    label: '# of Votes',
                    data: [500, 325],
                    backgroundColor: [
                        'rgba(54, 162, 235)',
                        'rgba(255, 99, 132)'
                    ]
                }]
            },

            options: {
                legend: {
                    position: 'right'
                }
            }
        });


        var ctx = document.getElementById('chart-5');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Windows', 'iOS', 'Linux'],

                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(0, 120, 215)',
                        'rgba(253, 148, 38)',
                        'rgba(52, 190, 91)'
                    ]
                }]
            },

            options: {
                legend: {
                    position: 'right'
                }
            }
        });





        var setting = {
            roots: document.querySelector('.my-js-slider'),
            type: 'range',

        }
        var slider = wRunner(setting);

        $(document).ready(function() {
            //wRunner plugin initialization in jQuery
            $('.my-jquery-slider').wRunner({
                type: 'range',
                rangeValue: {
                    minValue: 0,
                    maxValue: 100,
                },

            });
        })
    </script>


@stop