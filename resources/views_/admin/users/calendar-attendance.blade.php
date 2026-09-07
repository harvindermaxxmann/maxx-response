<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no">
    <link href="{{asset('/fullcalendar/fullcalendar.min.css')}}" rel='stylesheet' />
    <script src="{{asset('/fullcalendar/moment.min.js')}}"></script>
    <script src="{!! asset('js/backend_js/jquery.min.js') !!}" ></script>
    <script src="{{asset('/fullcalendar/fullcalendar.min.js')}}"></script>
    <title>User Attendance Calendar - Pioneer</title>
</head>
<body>
    <div class="fullWidth text-center" style="z-index: 9;">
        <div class="contain">
                <span class="eleBlock" style="background-color: #ff0000;">
                    A
                </span>       
                <span class="eleBlock" style="background-color: #48C9B0;">
                    P
                </span>       
                <span class="eleBlock" style="background-color: #87CEFA;">
                    L
                </span>       
        </div>
    </div>    
    <div class="fullWidth text-center">
        <div id='calendar'></div>
    </div>
</body>
<script>
    $(document).ready(function() {
        var atteandances = <?php print_r(json_encode($getattendances)) ?>;
        var defDate = "<?php echo $firstdate; ?>";
        $('#calendar').fullCalendar({
            height: 400,
            monthNames:['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            defaultDate: defDate,
            navLinks: false, // can click day/week names to navigate views
            editable: false,
            eventLimit: false, // allow "more" link when too many events
            events: atteandances,
            firstDay:1,
            eventRender: function (event, element, view) { 
                var dateString = event.start.format("YYYY-MM-DD");
                if(event.is_leave=="yes"){
                    $(view.el[0]).find('.fc-day[data-date=' + dateString + ']').css('background-color', '#87CEFA');
                }else if(event.attendance_status=="absent"){
                    $(view.el[0]).find('.fc-day[data-date=' + dateString + ']').css('background-color', '#FF0000');
                }else if(event.in_time !="" || event.out_time !=""){
                        $(view.el[0]).find('.fc-day[data-date=' + dateString + ']').css('background-color', '#48C9B0');
                }
            }
        });
       //$('.fc-unselectable .fc-row:last-child').remove();
    });
</script>
</html>
<style>
body{margin:5px 10px 40px;padding:0;font-family:"Lucida Grande",Helvetica,Arial,Verdana,sans-serif;font-size:14px; height: 100%;}.fc-button-group,.fc-event-container,.fc-right,.fc-time{display:none}#calendar{max-width:900px;margin:0 auto}.fc-day-top{text-align:center!important}.fc-day-number{float:none!important;text-align:center;display:inline-block}.fc-content-skeleton{position:absolute !important;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%);left:0;}
.overHidden{overflow: hidden !important;}
.fullWidth{float: left; display: inline-block; width: 100%; position: relative;}
.text-center{text-align: center;}
.text-right{text-align: right;}
.eleBlock{display: inline-block; float: none; position: relative; width: 30px; height:30px; text-align: center; line-height: 30px; font-size: 10px; color: #121212; overflow: hidden;white-space: nowrap; margin-bottom: 10px; border: 1px solid #ddd; text-rendering: optimizeLegibility;}
.eleBlock:not(:last-of-type){margin-right: 5px;}
.contain{max-width: 900px; display: inline-block; float: none; text-align: right; position: relative; width: 100%;}
.fc-toolbar{ position: absolute; bottom: 100%; left: 0; width: 100%;}
#calendar{z-index: 1;position: relative;}
/* .fc-other-month .fc-day-number { display:none;} */
</style>
