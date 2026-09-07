@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section login_page" id="loginpage">
    <div class="container">
        <div class="row mobrail">
            <div class="col-xs-12 col-sm-6 col-md-6 login_left_section text-center" style="min-height:490px;">
                <p class="thanku"><img src="{{ asset('images/cancelx.png')}}" alt="cancel image" /></p>
                <h1 class="text-center text-uppercase">Cancel</h1>
                <p>Your Order has been cancelled.</p>
                <p><a href="{{url('/')}}" class="btn btn-primary">
                    Back To Home Page
                    </a>
                </p>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 text-center login_right_section">
                <h1 class="title-section"><span class="title-regular"><strong>Maxx Response</strong></span></h1>
            </div>
        </div>
    </div>
</section>
@stop