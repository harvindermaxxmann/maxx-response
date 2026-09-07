@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard p-0 d-flex">

	 @include('layouts.frontLayout.main-sidebar')
    
    <div class="right-panel">
    <div class="container-fluid">
        <div class="text-center planline pad_top10"><span>Thank You</span> </div>
        <div class="text-center min500">
            <h3 style="margin-top:50px;">We have received your request for Sender Id. We wil email you sender Id in 1 to 3 business days. </h3>
        </div>
    </div>
	</div>

</section>
@stop