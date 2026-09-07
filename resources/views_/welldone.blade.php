@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section">
	<div class="container">
		<div class="mobrail">
			<div class="col-xs-12 col-sm-12 col-md-12 text-center">
				
				<h1 class="text-center text-uppercase">Well Done !</h1>
				<p>You can see your Landing page at:</p>
				<p><a href="javascript:">https://maxxmannit-3379.gr8.com</a></p>
				
				
				<div class="col-xs-12 col-md-10" style="float:none; margin:20px auto;">
				<div class="row">
				<div class="col-xs-12 col-md-4 icobox text-center">
				<p><span><i class="fa fa-plus-circle fa-3x"></i></span></p>
				<p><a href="javascript:;">Create another landing page </a></p>	
				</div>	
				<div class="col-xs-12 col-md-4 icobox text-center">
				<p><span><i class="fa fa-eye fa-3x"></i></span></p>
				<p><a href="javascript:;">View your landing page </a></p>	
				</div>		
				<div class="col-xs-12 col-md-4 icobox text-center">
				<p><span><i class="fa fa-table fa-3x"></i></span></p>
				<p><a href="javascript:;">Manage your landing page </a></p>	
				</div>	
				</div>
				<div class="clearfix"></div>	
					
				<div class="row adsbox">
					<div class="col-md-4 text-center">
					<p style="color:#fff; font-size:16px;"><small><i class="fa fa-users"></i>&nbsp;&nbsp; Page visitors</small></p>	
					<span class="fa-2x">12456</span>
					</div>
					<div class="col-md-8 text-left">
					<h2 style="margin-top:25px;">Boost your landing page traffic</h2>
					<h5>With facebook ads in Maxxresponse</h5>
					</div>
					
				</div>	
					
				
				</div>
				
				
				
				
				
			</div>
			
		</div>
	</div>
</section>
<?php Session::forget('invoiceid'); ?>
@stop