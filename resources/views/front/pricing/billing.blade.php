@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section padlowtopbot" style="padding-bottom:30px;">
    <div class="container">
        <div class="row">
            <!-- <div class="col-md-12 text-center">
				<h1 class="title-section"><span class="title-regular">Billing Information</span></h1>
               <p class="lead">You are just 60 seconds away from your new Maxx Response account!</p>
            </div> -->
        </div>
    </div>
</section>
<section class="page-section padlowtopbot" style="padding-top:0px;">
    <div class="container">
        <!-- form start -->	
        <form action="{{url('/billing')}}" autocomplete="off" method="post">@csrf
	    	@foreach($errors->all() as $error)
	            <p class="text-center"><li class="text-danger text-center">{!!   $error !!}</li></p>
	        @endforeach
        	@if(!Auth::check())
	            <div class="col-md-12 backg_sec payMoptin">
	                <h5>Account details:</h5>
	                <div class="row mar_top20">
	                    <div class="col-xs-12 col-md-6">
	                        <div class="form-group">
	                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
	                        </div>
	                    </div>
	                    <div class="col-xs-12 col-md-6">
	                        <div class="form-group">
	                            <input type="email" name="email"  class="form-control" placeholder="Email" value="{{ old('email') }}">
	                        </div>
	                    </div>
	                    <div class="col-xs-12 col-md-6">
	                        <div class="form-group">
	                            <input type="password" name="password" class="form-control" placeholder="Password">
	                        </div>
	                    </div>
	                    <div class="col-xs-12 col-md-6">
	                        <div class="form-group">
	                            <input type="password" name="password_confirmation"  class="form-control" placeholder="Confirm Password">
	                        </div>
	                    </div>
	                </div>
	            </div>
	        @endif
            <!-- billing address -->	
            <div class="col-md-12 payMoptin">                
                <div class="text-center planline mar_bottom20"><span> Billing Details </span></div>
                <div class="form-group mar_top20">
                    <select class="form-control" name="country" id="getCountry" required>
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                        	 <?php $countrysel=""; ?>
                        	@if(old('country') == $country->country_name)
							    <?php $countrysel="selected"; ?>
							@else
								@if(!empty($billingDetails) && $billingDetails['country'] == $country->country_name)
									<?php $countrysel="selected"; ?>
								@endif
							@endif
                        	<option value="{{$country->country_name}}" {{$countrysel}}>{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="address" class="form-control" placeholder="Billing Address" value="@if(!empty(old('address'))){{old('address')}}@else{{((!empty($billingDetails['address'])?$billingDetails['address']:''))}}@endif" required>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <input type="text" name="zip" class="form-control" placeholder="Zip/Postal Code" value="@if(!empty(old('zip'))){{old('zip')}}@else{{((!empty($billingDetails['zip'])?$billingDetails['zip']:''))}}@endif" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="state" id="getState" required>
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                     <?php $statesel=""; ?>
                                    @if(old('state') == $state->state_name)
                                        <?php $statesel="selected"; ?>
                                    @else
                                        @if(!empty($billingDetails) && $billingDetails['state'] == $state->state_name)
                                            <?php $statesel="selected"; ?>
                                        @endif
                                    @endif
                                    <option value="{{$state->state_name}}" {{$statesel}}>{{$state->state_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="city" id="AppendCities" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                     <?php $citysel=""; ?>
                                    @if(old('city') == $city->city_name)
                                        <?php $citysel="selected"; ?>
                                    @else
                                        @if(!empty($billingDetails) && $billingDetails['city'] == $city->city_name)
                                            <?php $citysel="selected"; ?>
                                        @endif
                                    @endif
                                    <option value="{{$city->city_name}}" {{$citysel}}>{{$city->city_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- row close -->
                <div class="form-group">
                    <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="@if(!empty(old('company_name'))){{old('company_name')}}@else{{((!empty($billingDetails['company_name'])?$billingDetails['company_name']:''))}}@endif" required>
                </div>
            </div>
            <!-- billing address close-->				
            <p class="text-center">
            	<button type="submit" class="btn btn-primary"> @if(Auth::check()) Submit & Proceed @else Create Account &amp; Proceed @endif</button>
            </p>
        </form>
        <!-- form close -->	
    </div>
</section>
@stop