@extends('layouts.frontLayout.front-layout')
@section('content')
<!-- Login page -->
<section class="page-section login_page padlowtopbot" id="loginpage">
    <div class="container">
        <div class="row mobrail">
            <div class="col-xs-12 col-sm-6 col-md-6 login_left_section">
                @if(Session::has('flash_message_success'))
                    <div role="alert" class="alert alert-success alert-dismissible fade in" style="opacity: 1;"><button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button>{!! session('flash_message_success') !!}</div>
                @endif
                @if(Session::has('flash_message_error'))
                    <div role="alert" class="alert alert-danger alert-dismissible fade in" style="opacity: 1;"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button>{!! session('flash_message_error') !!} </div>
                @endif
                @foreach($errors->all() as $error)
                    <li class="text-danger">{!!   $error !!}</li>
                @endforeach
                <h1 class="text-center text-uppercase">Login</h1>
                <form action="{{url('/login')}}" method="post" autocomplete="off">@csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter Email*" value="<?php if(!empty($stayTuned['rememberEmail'])){ echo $stayTuned['rememberEmail']; }?>" required>
                    </div>
                    <div class="form-group spass">
                        <input type="password" id="Password" name="password" class="form-control" placeholder="Enter Password*" value="<?php if(!empty($stayTuned['rememberPassword'])){ echo $stayTuned['rememberPassword']; }?>"required>
                        <a href="javascript:;" class="eycl" onclick="showPassword();"><span class="glyphicon glyphicon-eye-close"></span></a>
                    </div>
                    <div class="form-group" style="margin-bottom:30px;">
                        <div class="checkbox col-xs-6 col-sm-6 col-md-6">
                            <?php $checked=""; ?>
                            @if(!empty($stayTuned))
                                <?php $checked="checked"; ?>
                            @endif
                            <label><input name="userremember" value="1" type="checkbox" {{$checked}}> Remember me</label>
                        </div>
                        <div class="col-md-6 col-xs-6 col-sm-6 text-right">
                            <a href="javascript:;" data-toggle="modal" data-target="#ForgotPasswordModal">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default btn-block">Sign In</button>
                    </div>
                </form>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-12">
                    <p class="text-center xhelp">Don't have an account? <a href="{{url('/register')}}">Sign Up</a></p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 text-center login_right_section">
                <h1 class="title-section"><span class="title-regular"><strong>Maxx Response</strong></span></h1>
            </div>
        </div>
    </div>
</section>
<!-- Forgot Password Modal -->
<div class="modal fade" id="ForgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="ForgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="ForgotPasswordLabel">Forgot Password</h5>
            </div>
            <form id="Forgotpwd" action="javascript:;" autocomplete="off">@csrf
                <div class="modal-body">
                <span class="alert alert-success SuccessFader" style="display: none; float: left; width: 100%;"></span>
                <span class="alert alert-danger FailureFader" style="display: none; float: left; width: 100%;"></span>
                    <div class="form-group">
                        <label for="forgot-email" class="col-form-label">Email:</label>
                        <input placeholder="Enter Email" name="email" type="email" class="form-control" id="forgot-email" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="Forgotbtn" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Forgot Password Modal -->
<script type="text/javascript">
    function showPassword() {
        var x = document.getElementById("Password");
        if (x.type === "password") {
            x.type = "text";
        }else {
            x.type = "password";
        }
    }
    $("#Forgotpwd").on("submit",function(){
        var email = $("#forgot-email").val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var resp= regex.test(email);
        if(resp ==false){
            $(".FailureFader").text('Please enter vaild Email address'); 
            $(".FailureFader").slideDown();
            setTimeout(function(){
                $(".FailureFader").slideUp();      
            }, 1500);
            return false;
        }
        $('.loadingDiv').show();
        $("#Forgotbtn").prop('disabled', true);
        var formdata = $(this).serialize();
        $.ajax({
            url : '/forgot-password',
            data : formdata,
            type : 'post',
            dataType : 'json',
            success:function(resp){
                $("#forgot-email").val('');
                if(resp.status =="sucess"){
                    $(".SuccessFader").text(resp.message); 
                    $(".SuccessFader").slideDown();
                    setTimeout(function(){
                        $(".SuccessFader").slideUp();      
                    }, 2500);
                    setTimeout(function() {$('#ForgotPasswordModal').modal('hide');}, 3000);
                }else{
                    $(".FailureFader").text(resp.message); 
                    $(".FailureFader").slideDown();
                    setTimeout(function(){
                        $(".FailureFader").slideUp();      
                    }, 2500);
                }
                $('.loadingDiv').hide();
                $("#Forgotbtn").prop('disabled', false);
            },
            error:function(){}
        })
    });
</script>
@stop