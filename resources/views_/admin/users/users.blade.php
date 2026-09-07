@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
.table-scrollable table tbody tr td{
    vertical-align: middle;
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Users Management</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! action('AdminController@dashboard') !!}">Dashboard</a>
            </li>
        </ul>
         @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green-sharp bold uppercase">Users</span>
                            <span class="caption-helper">manage records...</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{action('UsersController@addEditUser')}}" class="btn btn-primary">Add User</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th>
                                            Id.
                                        </th>
                                        <th width="20%" >
                                            Name
                                        </th>
                                        <th width="20%">
                                            Email
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td></td>
                                        <td><input type="text" class="form-control form-filter input-sm" name="name" placeholder="Name"></td>
                                        <td><input type="text" class="form-control form-filter input-sm" name="email" placeholder="Email"></td>
                                        <td></td>
                                        <td>
                                            <div class="margin-bottom-5">
                                                <button class="btn btn-sm yellow filter-submit margin-bottom"><i title="Search" class="fa fa-search"></i></button>
                                                <button class="btn btn-sm red filter-cancel"><i title="Reset" class="fa fa-refresh"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Change Password Modal Starts-->
<div class="modal fade" id="changePassordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
            </div>
            <form action="{{ url('admin/change-user-password') }}" method="post" autocomplete="off">{{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" class="userId"> 
                        <label  class="form-control-label">New Password:</label>
                        <input name="password" type="text" class="form-control input-size">
                        <button type="button" class="btn btn-primary testAlign genPassword"> Generate Password</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary checkPassword">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
.table-scrollable table tbody tr td{
    vertical-align: middle;
}
.form-control.input-size {
  width: 70%;
}
.btn.btn-primary.testAlign {
  float: right;
  margin-top: -33px;
}
.sorting_1 > a {
  text-decoration: none;
}
</style>
<!-- Change Password Modal Ends-->
<script type="text/javascript">
    $(document).on('click','.genPassword',function(){
        var randomstring = Math.random().toString(36).slice(-8);
        $('.input-size').val(randomstring);
    });
    $(document).on('click','.checkPassword',function(){
        if($('.input-size').val() ==""){
            alert("Plaese Enter Password");
            return false;
        }
    });
    $(document).on('click','.editPassword',function(){
            $(".loadingDiv").show();
            var id= $(this).data('userid');
            $.ajax({
                data:{id:id},
                url:'/admin/change-user-password',
                type:"post",
                dataType:'json',
                success:function(resp){
                    $('#changePassordModal').modal('show');
                    $('.userId').val(resp.id);
                    $(".loadingDiv").hide();
                },
                error:function(){
                    alert('Something Went Wrong!');
                }
            })
        });
</script>
@stop





