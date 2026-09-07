@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\User;?>
<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

<div class="right-panel">
    <div class="container-fluid">

        @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        @foreach($errors->all() as $error)
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> {!!   $error !!} </div>            
        @endforeach

        <div class="text-center planline" style="padding-top:5px;"><span>Manage Account</span></div>

        <div class="clearfix"></div>
		
		<div class="blocks_div">
			
        <div class="mngacount" style="padding:0px; margin-top:0px;">
            <ul class="nav nav-tabs"  role="tablist">
                <li role="presentation" @if(empty($_GET)) class="active" @endif><a href="#AccountD" data-toggle="tab">Account details</a></li>
                <li role="presentation"><a @if(isset($_GET['tab']) && $_GET['tab']=="change-password") class="active" @endif href="#ChangeP" data-toggle="tab">Change password</a></li>
                <li role="presentation"><a href="#subscriptions" data-toggle="tab">Subscriptions</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade @if(empty($_GET)) in active @endif" id="AccountD">
                    <form action="{{url('/update-account-details')}}" method="post" autocomplete="off">@csrf
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <h4>User details</h4>
                                <div class="form-group">
                                    <label>Full Name<span class="red">*</span></label>
                                    <input type="text" name="name" class="form-control" value="@if(!empty(old('name'))){{old('name')}}@else{{((!empty(Auth::user()->name)?Auth::user()->name:''))}}@endif" required >
                                </div>
                                <div class="form-group">
                                    <label>Email<span class="red">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <h4>Address details</h4>
                                <div class="form-group">
                                    <label>Country<span class="red">*</span></label>
                                    <select class="form-control" name="country" id="getCountry" required>
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <?php $countrysel=""; ?>
                                            @if(!empty($billingDetails) && $billingDetails['country'] == $country->country_name)
                                                <?php $countrysel="selected"; ?>
                                            @endif
                                            <option value="{{$country->country_name}}" {{$countrysel}}>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>State/province/region<span class="red">*</span></label>
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
                                <div class="form-group">
                                    <label>City<span class="red">*</span></label>
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
                                <div class="form-group">
                                    <label>Address<span class="red">*</span></label>
                                    <input type="text" name="address" class="form-control" value="@if(!empty(old('address'))){{old('address')}}@else{{((!empty($billingDetails['address'])?$billingDetails['address']:''))}}@endif" required>
                                </div>
                                <div class="form-group">
                                    <label>Zip/Postal code<span class="red">*</span></label>
                                    <input type="text" name="zip" class="form-control" value="@if(!empty(old('zip'))){{old('zip')}}@else{{((!empty($billingDetails['zip'])?$billingDetails['zip']:''))}}@endif" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <h4>Business details</h4>
                                <div class="form-group">
                                    <label>Company Name<span class="red">*</span></label>
                                    <input type="text" name="company_name" class="form-control" value="@if(!empty(old('company_name'))){{old('company_name')}}@else{{((!empty(Auth::user()->company_name)?Auth::user()->company_name:''))}}@endif" required>
                                </div>
                                <div class="form-group">
                                    <label>Cell phone number<span class="red">*</span></label>
                                    <input type="tel" name="phone" class="form-control" value="@if(!empty(old('phone'))){{old('phone')}}@else{{((!empty(Auth::user()->phone)?Auth::user()->phone:''))}}@endif" required>
                                </div>
                                <div class="form-group">
                                    <label>Your website address (optional)</label>
                                    <input type="text" name="website" class="form-control" value="@if(!empty(old('website'))){{old('website')}}@else{{((!empty(Auth::user()->website)?Auth::user()->website:''))}}@endif" >
                                </div>
                                <div class="form-group">
                                    <label>Your industry (optional)</label>
                                    <input type="text" name="industry" class="form-control" value="@if(!empty(old('industry'))){{old('industry')}}@else{{((!empty(Auth::user()->industry)?Auth::user()->industry:''))}}@endif" >
                                </div>
                                <div class="form-group">
                                    <?php $employeesArray = array('0-50','50-250','250-500','More than 500') ?>
                                    <label>Number of employees (optional)</label>
                                    <select class="form-control" name="no_of_employees">
                                        <option value="">Please Select</option>
                                        @foreach($employeesArray as $empsize)
                                            <option value="{{$empsize}}" @if($empsize==Auth::user()->no_of_employees) selected @endif>{{$empsize}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- row close -->
                        <p class="text-center"><button type="submit" class="btn btn-default">Save</button></p>
                    </form>
                    <!-- form close -->
                </div>
                <div role="tabpanel" class="tab-pane fade @if(isset($_GET['tab']) && $_GET['tab']=="change-password") in active @endif" id="ChangeP" >
                    
                    <!-- change password form start -->
                    <div class="col-xs-12 col-md-12">
                        
                        <form method="post" action="{{url('change-password')}}" autocomplete="off">@csrf
							<div class="row mar-top30">
							
							<div class="col-xs-12 col-md-4">
							<div class="form-group">
                                <label>Current Password<span class="red">*</span></label>
                                <input type="password" class="form-control" name="current_password" placeholder="Enter Current Password" required>
                            </div>	
							</div>
							<div class="col-xs-12 col-md-4">
							<div class="form-group xpas">
                                <label>New Password<span class="red">*</span></label>
                                <input type="password" name="password" class="form-control" id="Password" placeholder="Enter New Password" required>
                            </div>
							</div>
							<div class="col-xs-12 col-md-4">
								<div class="form-group xpas">
                                <label>Confirm Password<span class="red">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirm Password"  id="Password1" required>
                            </div>
							</div>
							
							</div>

							
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-default">Change Password</button>
                            </div>
                        
                        </form>
                        <!-- change password form close -->
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="subscriptions" >
                    
                    <div class="row">
                        <div class="col-xs-12 midlcenter">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Invoice Number</th>
                                            <th>Package</th>
                                            <th>Payment Mode</th>
                                            <th>Amount</th>
                                            <th>Payment Status</th>
                                            <th>Subscription Status</th>
                                            <th>Expiry Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $subscriptions = User::userSubscriptions();?>
                                        @if(!empty($subscriptions))
                                            @foreach($subscriptions as $subscription)
                                                <tr>
                                                    <td>{{$subscription['invoice_id']}}</td>
                                                    <td>{{$subscription['package_name']}}</td>
                                                    <td>{{$subscription['payment_mode']}}</td>
                                                    <td><strong>{{$subscription['currency']}} {{$subscription['grand_total']}}</strong></td>
                                                    <td>{{$subscription['payment_status']}}</td>
                                                    <td>
                                                        @if($subscription['payment_status'] =="Completed")
                                                        {{$subscription['order_status']}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($subscription['payment_status'] =="Completed")
                                                        {{date('d F, Y',strtotime($subscription['expiry_date']))}}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a target="_blank" href="{{url('/view-invoice/'.$subscription['id'])}}"><i class="fa fa-file"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">No subscription found. &nbsp;<a href="{{url('/pricing')}}">Subscribe Now</a></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		
		
				
		
		</div><!-- row close -->
		
    </div>
    <!-- container close -->

  </div>  
</section>
@stop