@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\LinkedList; ?>
<?php $lists = LinkedList::lists(); ?>
<section class="page-section dasboard  p-0 d-flex">
    @include('layouts.frontLayout.main-sidebar')

    <div class="right-panel">
    <div class="container-fluid">
        @foreach($errors->all() as $error)
            
            <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!!   $error !!}
            </div>
            
        @endforeach
        <div class="text-center planline mar_bottom20"><span>@if($type=="single") Add Contact @elseif($type=="multiple") Add Multiple Contacts @else Import Contacts @endif</span></div>
        <!-- <div class="col-xs-12 col-md-12 text-center planline" style="padding:0;">
            <span>@if($type=="single") Add Contact @elseif($type=="multiple") Add Multiple Contacts @else Import Contacts @endif</span>
        </div> -->
        @if($type=="single")
            <div class="col-xs-12">
                <form autocomplete="off" method="post" action="{{url('add-contact/'.$type)}}">@csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="List">Select List<span class="red">*</span></label>
                            <select class="form-control" name="list_id" id="getList" required>
                                <option value="">Select</option>
                                @foreach($lists as $list)
                                    <option value="{{$list['id']}}">{{$list['list_name']}}</option>
                                @endforeach
                                <option value="add-new">Add new List Name</option>
                            </select>
                        </div>
                    </div>





                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="FirstName">Name<span class="red">*</span></label>
                            <input type="text" name="name" class="form-control" id="FirstName" placeholder=" Name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Email">Email<span class="red">*</span></label>
                            <input type="email" name="email" class="form-control" id="Email" placeholder="Email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Phone">Phone<span class="red">*</span></label>
                            <input type="number" name="phone" class="form-control" id="Phone" placeholder="Phone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address<span class="red">*</span></label>
                            <input type="text"  name="address" class="form-control" id="address" placeholder="Address" value="{{ old('address') }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="country">Country</label>
                            <select class="form-control" name="country" id="getCountry">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                     <?php $countrysel=""; ?>
                                    @if(old('country') == $country->country_name)
                                        <?php $countrysel="selected"; ?>
                                    @endif
                                    <option value="{{$country->country_name}}" {{$countrysel}}>{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state">State</label>
                            <select class="form-control" name="state" id="getState">
                                <option value="">Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <select class="form-control" name="city" id="AppendCities">
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pincode">Pincode</label>
                            <input type="text" name="pincode" class="form-control" id="pincode" placeholder="pincode" value="{{ old('pincode') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="JobTitle">Job Title</label>
                            <input type="text" name="job_title" class="form-control" id="JobTitle" placeholder="Job Title" value="{{ old('job_title') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="OPtIn">OPT In</label>
                            <select class="form-control" name="opt_in">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="comapnyName">Company Name</label>
                            <input type="text" name="company_name" class="form-control" id="comapnyName" placeholder="Company Name" value="{{ old('company_name') }}">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>
                                Note :- If you add duplicate email then it will delete previous one.
                            </label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-row">
                        <label for="terms"></label>
                        <input id="terms" type="checkbox" value="yes" required> Please accept our terms &conditions
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary center-block">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        @elseif($type=="multiple")
            <form autocomplete="off" action="{{url('add-contact/'.$type)}}" method="post">@csrf
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-9">
                            <button type="button" class="btn btn-primary add-row">Add More</button>
                            <button type="button" class="btn btn-primary delete-row">Delete</button>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-3 mob-mar_top15">
                            <select class="form-control" name="list_id" id="getList" required>
                                <option value="">Select List</option>
                                @foreach($lists as $list)
                                    <option value="{{$list['id']}}">{{$list['list_name']}}</option>
                                @endforeach
                                <option value="add-new">Add new List Name</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php if(isset($_GET['rows']) && !empty($_GET['rows']) && is_numeric($_GET['rows'])){?>
                <input type="hidden" name="rows" id="UpdateContactRows" value="{{$_GET['rows']}}">
                <?php } else{?>
                        <input type="hidden" name="rows" id="UpdateContactRows" value="1">
                <?php } ?>
                <div class="clearfix"></div>
                <div class="table-responsive">
                <table class="table table-striped" id="AddMultipleContact">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkall"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Pincode</th>
                            <th>Job Title</th>
                            <th>OPT In</th>
                            <th>Company Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(isset($_GET['rows']) && !empty($_GET['rows']) && is_numeric($_GET['rows'])){
                                $total=$_GET['rows'] -1;
                            }else{
                                $total=0;
                            }  ?>
                        @for($i=0; $i<=$total;$i++)
                            <tr> 
                                <td>@if($i != 0)<input type='checkbox' name='record'>@endif</td>
                                <td><input type="text" placeholder="Name" class="form-control" name="name[]" value="" required></td>
                                <td><input type="email" placeholder="Email" class="form-control" name="email[]" value="" required></td>
                                <td><input type="number" placeholder="Phone" class="form-control" name="phone[]" value="" required></td>
                                <td><input type="text" placeholder="Address" class="form-control" name="address[]" value=""></td>
                                <td>
                                    <select class="form-control" name="country[]">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                             <?php $countrysel=""; ?>
                                            
                                            <option value="{{$country->country_name}}" {{$countrysel}}>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" placeholder="State" class="form-control" name="state[]" value=""></td>
                                <td><input type="text" placeholder="City" class="form-control" name="city[]" value=""></td>
                                <td><input type="number" placeholder="Pincode" class="form-control" name="pincode[]" value=""></td>
                                <td><input type="text" placeholder="Job Title" class="form-control" name="job_title[]" value="" ></td>
                                <td>
                                    <select class="form-control" name="opt_in[]">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td><input type="text" placeholder="Company Name" class="form-control" name="company_name[]" value=""></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary center-block">Submit</button>
                    </div>
                </div>
            </form>
        @elseif($type=="import")
            <div class="col-xs-12 col-md-6 midlcenter text-center">
                <form autocomplete="off" method="post" action="{{url('add-contact/'.$type)}}" enctype='multipart/form-data'>@csrf
                    <div class="form-group">
                        <label for="getList"></label>
                        <select class="form-control" name="list_id" id="getList" required>
                            <option value="">Select Listss</option>
                            @foreach($lists as $list)
                                <option value="{{$list['id']}}">{{$list['list_name']}}</option>
                            @endforeach
                            <option value="add-new">Add new List Name</option>
                        </select>
                    </div>


<div class="form-group">
                        <label for="servicespecific">Services</label>
                        <select class="form-control" name="services" id="servicespecific" required>
                            <option value="">Select List</option>
                            @foreach($users_role as $roleserve)
                                <option value="{{$roleserve->id}}">{{$roleserve->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>



              <div class="form-group">
                        <label for="getList">Users</label>
                        <select class="form-control" name="users" id="users" required>
                            <option value="">Select List</option>
                          
                                <option value=""></option>
                     
                            
                        </select>
                    </div>      



                    <div class="form-group">
                        <label for="ContactFile"></label>
                        <input type="file" name="contact" id="ContactFile" required>
                    </div>
                    <div class="form-group">
                        <p>
                            <span class="text-center">Note:- Please upload only csv file formats. We will accept only 500 rows in one csv and we will not consider wrong email. Email must be correct.<br> <a href="{{url('/contcat-demo-format.csv')}}"> <strong>Download Sample format</strong></a></span>
                        </p>
                    </div>

                 <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary center-block">Submit</button>
                        </div>
                    </div>
                </form> 
            </div>

        @elseif($type=="contacts")
            <div class="col-xs-12 col-md-6 midlcenter text-center">
                <form autocomplete="off" method="post" action="{{url('add-contact/'.$type)}}" enctype='multipart/form-data' id="ContactListForm">
                    @csrf
                    <div class="form-group">
                        <label for="getList">List Name</label>
                        <input class="form-control" type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="ContactFile">Service</label>
                        <select class="form-control selctbox" onchange="getUsers();" name="serviceType" id="serviceType">
                                <option value="all">All</option>
                                <option value="1">Web Development &amp; Enhancement</option>
                                <option value="2">Mobile App Development</option>
                                <option value="3">Digital Marketing</option>
                                <option value="4">Brand Management</option>
                                <option value="5">Business Intelligence</option>
                                <option value="6">Design &amp; Advertisement</option>
                                <option value="7">Sales</option>
                                <option value="9">Management</option>
                                <option value="10">Systems Administration</option>
                                <option value="13">Quality Control</option>
                                <option value="14">Quality Assurance Service</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="getList">Skills</label>
                        <input onkeyup="getUsers();" class="form-control" type="text" name="user_skills" id="skillname" required>
                    </div>
                    
                    <div class="form-group">
                        <p>
                            <span class="text-center">User found:<strong id="totalUser">Download Sample format</strong></a></span>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary center-block">Submit</button>
                        </div>
                    </div>
                </form> 
            </div>
        @endif

    </div>

</div>
</section>
<span id="CloseListNameEvent" style="display: none;">no</span>
<!-- New List Name Modal -->
<div class="modal fade" id="ListNameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Add List Name</h5>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form id="AddlistForm" action="javascript:;" method="post" autocomplete="off">@csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="List-name" class="col-form-label">List Name:</label>
                        <input type="text" name="list_name" class="form-control" id="List-name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- New List Name Modal -->
<table class="table table-striped samplerow" style="display:none;">
    <tbody>
        <tr>
            <td><input type='checkbox' name='checkbox[]'></td>
            <td><input type="text" placeholder="Name" class="form-control" name="name[]" required></td>
            <td><input type="email" placeholder="Email" class="form-control" name="email[]" required></td>
            <td><input type="number" placeholder="Phone" class="form-control" name="phone[]"  required></td>
            <td><input type="text" placeholder="Address" class="form-control" name="address[]" required></td>
            <td>
                <select class="form-control" name="country[]">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{$country->country_name}}">{{$country->country_name}}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" placeholder="State" class="form-control" name="state[]"></td>
            <td><input type="text" placeholder="City" class="form-control" name="city[]"></td>
            <td><input type="number" placeholder="Pincode" class="form-control" name="pincode[]"></td>
            <td><input type="text" placeholder="Job Title" class="form-control" name="job_title[]" ></td>
            <td><select class="form-control" name="opt_in[]">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select></td>
            <td><input type="text" placeholder="Company Name" class="form-control" name="company_name[]"></td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','#getList',function(){
            var value = $(this).val();
            if(value == "add-new"){
                $('#CloseListNameEvent').text('no');
                $('#ListNameModal').modal('show');
            }
        });

        $("#AddlistForm").submit(function(e){
            e.preventDefault();
            $('.loadingDiv').show();
            var formdata = $("#AddlistForm").serialize();   
            $.ajax({
                url: '/add-list-name',
                type:'POST',
                data: formdata,
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        if(data.status=="failed"){
                            var msg = [];
                            msg[0] = data.message;
                            printErrorMsg(msg);
                            $('.print-error-msg').delay(3000).fadeOut('slow');
                        }else{
                            $('#getList option:first').after($('<option>', {
                                value: data.listid,
                                text: data.listname
                            }));
                            $('#getList option:eq(1)').prop('selected', true);
                            $('#CloseListNameEvent').text('yes');
                            $("#AddlistForm").trigger("reset");
                            $('#ListNameModal').modal('hide');
                        }
                    }else{
                        printErrorMsg(data.error);
                        $('.print-error-msg').delay(3000).fadeOut('slow');
                    }
                    $('.loadingDiv').hide();
                }
            });
        });

        $(document).on('change','#serviceTypeID',function(e){
            e.preventDefault();
         
            var formdata = $("#ContactListForm").serialize();
            $.ajax({
                url: '/search-contacts',
                type:'POST',
                data: formdata,
                success: function(data) {
                    $('#no_of_contacts').text('200');                 
                }
            });
        });

        $('#ListNameModal').on('hide.bs.modal', function (e) {
            if($('#CloseListNameEvent').text() =="no"){
                $('#getList option:eq(0)').prop('selected', true);
            }
            $("#AddlistForm").trigger("reset");
        });

        function printErrorMsg(msg){
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

        $(".add-row").click(function(){
            var rowCount = $('#AddMultipleContact tr').length;
            if(rowCount >=51){
                alert('You can not add more than 50 contacts');
            }else{
                $('#UpdateContactRows').val(rowCount);
                /*var markup = "<tr><td><input type='checkbox' name='checkbox[]'><td><input type='email' placeholder='Email' class='form-control' name='email[]' required></td><td><input type='text' placeholder='First Name' class='form-control' name='first_name[]' required></td> <td><input type='text' placeholder='Last Name' class='form-control' name='last_name[]' required></td><td><input type='text' placeholder='Company Name' class='form-control' name='company_name[]' required></td><td><input type='number' placeholder='Phone' class='form-control' name='phone[]' required></td><td><input type='text' placeholder='Title' class='form-control' name='title[]'></td><td><input type='text' placeholder='Job Title' class='form-control' name='job_title[]'></td><td><input type='text' placeholder='OPT in' class='form-control' name='opt_in[]'></td><td><input type='text' placeholder='Confirmed Time' class='form-control' name='confirmed_time[]'></td><td><input type='text' placeholder='Privacy Policy' class='form-control' name='privacy_policy[]'></td></tr>";*/
                //$("table tbody").append(markup);
                var row = $('.samplerow tr').clone(true);
                row.appendTo('#AddMultipleContact');
            }
        });
        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $('.checkall').prop('checked', false);
            var checkedlength = $('[name="checkbox[]"]:checked').length;
            if(checkedlength==0){
                alert('Please select row using checkbox to be removed.'); return false;
            }
            $("#AddMultipleContact").find('input[name="checkbox[]"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                    var rowCount = $('#AddMultipleContact tr').length -1;
                    $('#UpdateContactRows').val(rowCount);
                }
            });
        });

        $(document).on('change','.checkall',function(){
            if($(this).prop("checked") == true){
                $('input:checkbox').prop('checked', this.checked);
            }else{
                $("input:checkbox").prop('checked', false);
            }
        });
 });

function getUsers(){

var serviceType = $("#serviceType").val();
var skillname   = $("#skillname").val();

    $.ajax({ url: '/getspecservice',
            type:'POST',
            data: {service_id:serviceType, skills:skillname},
            headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
            success: function(response) {
                $('#totalUser').html(response.data);

            }
        });
}


</script>
@stop