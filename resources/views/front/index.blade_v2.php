@extends('layouts.frontLayout.front-layout')
@section('content')
<!-- Hero Header -->
<header class="hero-header">
    <div class="container" style="position: relative;">
    <div id="carousel-header" class="carousel slide header_crou">
            <!-- Indicators -->
            <!--ol class="carousel-indicators">
                @foreach($bannerImages as $ckey=> $banner)
                    <li data-target="#carousel-header" data-slide-to="{{$ckey}}" @if($ckey==0)  class="active" @endif></li>
                @endforeach
            </ol-->
			
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @foreach($bannerImages as $bkey=> $banner)
                    <div class="@if($bkey==0) slide-1 item active @else slide-2 item  @endif">
                        <img class="img-responsive img-full" src="{{ asset('images/banner/'.$banner['image'])}}" alt="">
                        <div class="carousel-caption">
                        @if(Auth::check())
                            {!!$banner['description']!!}
                        @endif
                        </div>
                    </div>
                @endforeach
            </div><!-- dynamic banner close --> 
			
        </div>

        @if(!Auth::check())
        <div class="header-login login_left_section hidden-xs hidden-sm">
            
                @if(Session::has('flash_message_success'))
                    <div role="alert" class="alert alert-success alert-dismissible fade in" style="opacity: 1;"><button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button>{!! session('flash_message_success') !!}</div>
                @endif
                @if(Session::has('flash_message_error'))
                    <div role="alert" class="alert alert-danger alert-dismissible fade in" style="opacity: 1;"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button>{!! session('flash_message_error') !!} </div>
                @endif
                @foreach($errors->all() as $error)
                    <li class="text-danger">{!!   $error !!}</li>
                @endforeach
                
                <div id="login_form">
                    <h1 class="text-center text-uppercase">Login</h1>
                    <form action="{{url('/login')}}" method="post" autocomplete="off">@csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter Email*" value="<?php if(!empty($stayTuned['rememberEmail'])){ echo $stayTuned['rememberEmail']; }?>" required>
                        </div>
                        <div class="form-group spass">
                            <input type="password" id="Password" name="password" class="form-control" placeholder="Enter Password*" value="<?php if(!empty($stayTuned['rememberPassword'])){ echo $stayTuned['rememberPassword']; }?>"required>
                            <a href="javascript:;" class="eycl" onclick="showPassword();"><span class="glyphicon glyphicon-eye-close"></span></a>
                        </div>
                        <div class="form-group clearfix">
                            <div class="checkbox pull-left">
                                <?php $checked=""; ?>
                                @if(!empty($stayTuned))
                                    <?php $checked="checked"; ?>
                                @endif
                                <label><input name="userremember" value="1" type="checkbox" {{$checked}}> Remember me</label>
                            </div>
                            <div class="pull-right">
                                <a href="javascript:;" data-toggle="modal" data-target="#ForgotPasswordModal">Forgot Password?</a>
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-block">Sign In</button>
                        </div>
                    </form>
                    <div>
                        <p class="text-center xhelp">Don't have an account? <a href="javascript:void(0);" id="signup-btn">Sign Up</a></p>
                    </div>
                </div>

                <div id="register_form" style="display: none;">
                    <h1 class="text-center text-uppercase">Register for Free Account</h1>
                    <form action="{{url('/register')}}" method="post" autocomplete="off">@csrf

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control"  placeholder="Name*" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email*" value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="password" name="password" class="form-control disableCutCopy"  placeholder="Password*" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" class="form-control disableCutCopy" placeholder="Confirm Password*" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-left">
                             <div class="checkbox pad_left20">
                                <input id="accept" name="accept" value="accept" type="checkbox"> By clicking “Create account” I accept the <a href="javascript:void(0);">Terms of Service</a> and the <a href="javascript:void(0);"> Privacy Policy</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-block" id="create_account" disabled="disabled">Create Account</button>
                        </div>
                    </form>
                    <div>
                        <p class="text-center xhelp">Do you have account? <a href="javascript:void(0);" id="signin-btn">Sign In</a></p>
                    </div>
                </div>
            
        </div>
        @endif


        

    </div>
</header>
<section class="page-section padlowtopbot" id="intro">
        <div class="container intro">
           
                <div class="col-xs-12 col-sm-12 p-0 text-center">
                    <h3>About Maxxresponse</h3>
                    <p class="visible-xs"><img src="{{ asset('images/about-img.png')}}" alt="" class="img-responsive img-thumbnail" /></p>
                    <p>Mxxresponse with a powerful and intuitive editor is a robust design & publishing platform. It is a platform to bring your creativity to real life. Impress your client by creating the marketing material quick and easy.</p>



                   
                    <p>
                        <a href="{{url('/pricing')}}" class="btn btn-darkgrey mar_top20 btn-lg text-uppercase" style="font-weight: 600;">View Pricing</a>
                         @if(!Auth::check())
                        <a href="{{route('register')}}" class="btn btn-orange mar_top20 mar_left15 btn-lg text-uppercase" style="font-weight: 600;">Register Free</a>
                        @endif
                    </p>
                    
                </div>

                <!--div class="col-xs-12 col-sm-6 col-sm-offset-1 text-right hidden-xs">
                    <div class="thumb-bg">
                        <div class="img-cont"><img src="{{ asset('images/about-img.png')}}" alt="" class="img-responsive img-thumbnail"></div>
                    </div>                    
                </div-->
            
        </div>
    </section>

    <section id="services">
        

        <div class="service_grid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-8 hidden-xs">
                        <img src="{{ asset('images/design-section-img.png')}}" alt="" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <h3 style="padding-top: 50px;">Turn your visitors into customers</h3>
                        <p class="visible-xs"><img src="{{ asset('images/design-section-img.png')}}" alt="" class="img-responsive"></p>
                        <p>As it is said, First impression is the last impression. Landing pages gives a glimpse to your website visitors of what your brand is about. Whatever your current business goals may be increasing sales figures, growing your customer base, expanding your footprint into new markets or launching a new product or service, among others – well-crafted landing pages support all these objectives.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="service_grid">
            <div class="container">
                <div class="row">                
                    <div class="col-xs-12 col-md-5">
                        <h3 style="padding-top: 90px;">Be everywhere your customers are</h3>
                        <p class="visible-xs"><img src="{{ asset('images/campaign-section-img.png')}}" alt="" class="img-responsive"></p>
                        <p>As social media grew in popularity, many marketers started to question the future value of email marketing. It’s widely used as an efficient and cost-effective method for new customer acquisition, building brand awareness, and increasing product sales, as well as fostering trust and loyalty with a company’s customer base. Compared to the many marketing channels available today to reach your target audience, email is the most effective channel for capturing attention, as well as engaging and connecting with prospects and customers.</p>
                    </div>
                    <div class="col-xs-12 col-md-7 text-right hidden-xs">
                        <img src="{{ asset('images/campaign-section-img.png')}}" alt="" class="img-responsive">                 
                    </div>
                </div>
            </div>
        </div>

        <div class="service_grid">
            <div class="container">
                <div class="text-center">                
                    <h3>Powerful and Simple Template Builder</h3>
                    <p>Create professional and responsive templates without any Coding knowledge</p>
                    <div class="pad_top15">
                        <img src="{{ asset('images/template-builder-img.png')}}" alt="" class="img-responsive mx-auto">                 
                    </div>
                </div>
            </div>
        </div>
        
    </section>    

    <section class="page-section padlowtopbot" id="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-center">Happy Customers</h3>
                    <div class="row">                        
                        <div class="col-lg-6 testimonials_grid">
                            <div class="bg-white rounded">
                                <p class="quote">  
                                	<i class="fa fa-quote-left" aria-hidden="true"></i>                                  
                                    Uniquely streamline highly efficient scenarios and 24/7 initiatives. Conveniently embrace multifunctional ideas through proactive customer service. Distinctively conceptualize 2.0 intellectual capital via user-centric partnerships.
                                </p>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <img src="{{ asset('images/user-placeholder.png')}}" alt="" class="img-responsive img-circle">
                                    </div>
                                    <div class="col-xs-9 testi_by">
                                        <h5>Upendra Chaurasia</h5>
                                                                               
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="col-lg-6 testimonials_grid">
                            <div class="bg-white rounded">
                                <p class="quote">  
                                	<i class="fa fa-quote-left" aria-hidden="true"></i>                                  
                                    Uniquely streamline highly efficient scenarios and 24/7 initiatives. Conveniently embrace multifunctional ideas through proactive customer service. Distinctively conceptualize 2.0 intellectual capital via user-centric partnerships.
                                </p>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <img src="{{ asset('images/user-placeholder.png')}}" alt="" class="img-responsive img-circle">
                                    </div>
                                    <div class="col-xs-9 testi_by">
                                        <h5>KP Singh Mann</h5>
                                                                               
                                    </div>
                                </div>
                            </div>                            
                        </div>                      
                    </div>                    
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


<script>
    $(document).ready(function(){
        $("#signup-btn").click(function(){
            $("#register_form").slideDown();
            $("#login_form").hide();
        });

        $("#signin-btn").click(function(){
            $("#register_form").hide();
            $("#login_form").slideDown();
        });

        $("#accept").click(function(){
            if ($(this).is(':checked')) {
                $('#create_account').removeAttr('disabled'); 
            }
            else {
                $('#create_account').attr('disabled', true);
            }
        });
    });
</script>

@stop