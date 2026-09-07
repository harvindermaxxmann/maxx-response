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
                    <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
                @endif
                @foreach($errors->all() as $error)
                    <li class="text-danger">{!!   $error !!}</li>
                @endforeach
                <h1 class="text-center text-uppercase">Register for Free Account</h1>
                <form action="{{url('/register')}}" method="post" autocomplete="off">@csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control"  placeholder="Name*" value="{{ old('name') }}" required>
                    </div>
                    <!-- name -->	
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email*" value="{{ old('email') }}" required>
                    </div>
                    <!-- usernaem -->
                    <div class="form-group">
                        <input type="password" name="password" class="form-control disableCutCopy"  placeholder="Password*" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control disableCutCopy" placeholder="Confirm Password*" required>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default btn-block" style="margin-top:0px;">Create Account</button>
                    </div>
                </form>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-12">
                    <p class="text-center xhelp">By clicking “Create account” I accept the <a href="javascript:void(0)">Terms of Service</a> and the <a href="javascript:void(0)"> Privacy Policy.</a></p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 text-center login_right_section regis">
                <h1 class="title-section"><span class="title-regular"><strong>Maxx Response</strong></span></h1>
            </div>
        </div>
    </div>
</section>
@stop