@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard p-0 d-flex">

	@include('layouts.frontLayout.main-sidebar')

	<div class="right-panel">
    <div class="container-fluid">
        <div class="col-xs-12 col-md-12 text-center planline" style="padding:0;"><span>Done!</span> </div>
        
        <div class="col-xs-12 col-md-12 text-center min500">
            <h3 style="margin-top:50px;"> Your Newsletter campaign has been started successfully.</h3>
        </div>
    </div>
	</div>
</section>
@stop