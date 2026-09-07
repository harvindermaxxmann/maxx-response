@extends('layouts.frontLayout.front-layout')
@section('content')
<div id="contents">
    <section class="page-section p-0 d-flex">

        @include('layouts.frontLayout.main-sidebar')

        <div class="right-panel">
            <div class="container-fluid" >
            <div class="row" style="border-bottom:solid 1px #f1f1f1;">
                <div class="col-xs-12 col-md-8">
                    <h2 style="display:inline-block;">Contact Group</h2>
                </div>
                <div class="col-xs-12 col-md-4 text-right">
                    <!-- <a href="{{url('add-contact/single')}}" class="btn btn-success" style="display:inline-block;">Create List</a> -->
                    <div class="col-xs-12 mar_bottom15">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong>Contacts</strong><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('/add-contact/single')}}">Add Contact</a></li>
                                    <li><a href="{{url('/add-contact/multiple')}}">Add Multiple Contacts</a></li>
                                    <li><a href="{{url('/add-contact/import')}}">Import Contacts</a></li>
                                    <li><a href="{{url('/export-contacts')}}">Export Contacts</a></li>
                                    <li><a href="{{url('/add-contact/contacts')}}"> Contacts</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- row close -->
            <div class="clearfix"></div>
            <!-- middle filter div  -->             
            <div class="col-xs-12 col-md-12 midle_filter_div">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <form action="{{url('/contact-lists')}}" method="get">
                            <p class="text-uppercase">Filter by</p>
                            <ul>
                                <li>
                                    <div class="form-group">
                                        <input type="date" name="date" class="form-control" value="<?php if(isset($_GET['date']) && !empty($_GET['date'])){ echo $_GET['date'];} ?>">
                                    </div>
                                </li>
                            </ul>
                            <input type="submit" class="btn btn-primary mar_top10" value="Apply Filter">
                            @if(isset($_GET['date']) && !empty($_GET['date']))
                                <a class="btn btn-danger"  href="{{url('/contact-lists')}}">Clear Filters</a>
                            @endif
                        </form>
                    </div>
                    <div class="col-xs-12 col-md-9">
                         <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Group Name</th>
                                    <th>Total Contacts</th>
                                    <th>Created On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($contactlists) >0)
                                    @foreach($contactlists as $contactlist)
                                        <tr>
                                            <td>{{$contactlist->list_name}}</td>
                                            <td>{{$contactlist->contacts_count}}</td>
                                            <td>{{date('d M Y, h:ia',strtotime($contactlist->created_at))}}</td>
                                            <td><a class="btn btn-success" href="{{url('/contacts?lists='.$contactlist->id)}}"><i class="fa fa-file"></i></a>
                                             <a title="Delete Contact" onclick="return confirm('Are you sure you want to delete this contact?');"  href="{{url('delete-contactlist/'.$contactlist['id'])}}" class="btn btn-default"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                       <td colspan="4" class="text-center"> No Contact Lists found.</td> 
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- middle filter div  close-->
            </div>          
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','#emailcheckall',function(){
            if($(this).prop("checked") == true){
                $('input[name="emailcheck[]"]').prop('checked', this.checked);
                var emailcheckcount=$('input[name="emailcheck[]"]:checked').length;
                if(emailcheckcount >0){
                    $('#ViewEmailList').show();
                }else{
                    $('#ViewEmailList').hide();
                }
            }else{
                $('#ViewEmailList').hide();
                $('input[name="emailcheck[]"]').prop('checked', false);
            }
        });

        $('#ViewEmailList').click(function()  { 
            var selected = [];   
            $('input:checkbox[name="emailcheck[]"]:checked').each(function() {
                selected.push($(this).val());
            });
            var lists = selected.join(',');
            var url = "/contacts?lists="+lists;
            window.open(url, '_blank');
        });

        $(document).on('change','.emailcheckbox',function(){
            var emailcheckcount=$('input[name="emailcheck[]"]:checked').length;
            if(emailcheckcount >0){
                $('#ViewEmailList').show();
            }else{
                $('#ViewEmailList').hide();
            }
        });

        $(document).on('change','#smscheckall',function(){
            if($(this).prop("checked") == true){
                $('input[name="smscheck[]"]').prop('checked', this.checked);
                var smscheckcount=$('input[name="smscheck[]"]:checked').length;
                if(smscheckcount >0){
                    $('#ViewSmsList').show();
                }else{
                    $('#ViewSmsList').hide();
                }
            }else{
                $('#ViewSmsList').hide();
                $('input[name="smscheck[]"]').prop('checked', false);
            }
        });


        $('#ViewSmsList').click(function()  { 
            var selected = [];   
            $('input:checkbox[name="smscheck[]"]:checked').each(function() {
                selected.push($(this).val());
            });
            var lists = selected.join(',');
            var url = "/contacts?lists="+lists;
            window.open(url, '_blank');
        });

        $(document).on('change','.smscheckbox',function(){
            var smscheckcount=$('input[name="smscheck[]"]:checked').length;
            if(smscheckcount >0){
                $('#ViewSmsList').show();
            }else{
                $('#ViewSmsList').hide();
            }
        });
    })
</script>
@stop
