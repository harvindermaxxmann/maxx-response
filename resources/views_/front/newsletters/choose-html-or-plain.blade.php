@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

    <div class="right-panel">
    <div class="container-fluid">

        <div class="text-center planline" style="padding-top:10px;"><span>Create Newsletter</span> </div>

        
        <div class="pad_top30 blocks_div">
           
            <!-- rightside -->
            <div>
                <div class="row creatimgbox">
                    <div class="col-xs-12 col-md-6">
                        <div class="thumbnail">
                            <p style="margin:0px;"><a href="{{url('/newsletter/basic-settings?type=editor')}}"><img src="{{ asset('images/drags.jpg')}}" title="Drag Drop Email Editor" alt="Drag Drop Email Editor"></a></p>
                            <div class="caption">
                                <p>Discover the pure joy of creating beautiful email messages with the Email Creator.</p>
                                <p><a href="{{url('newsletter/basic-settings?type=editor')}}" class="btn btn-primary btn-lg" role="button">Drag-and-Drop Email Editor</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="thumbnail">
                            <p style="margin:0px;"><a href="{{url('/newsletter/basic-settings?type=plain-html')}}"><img src="{{asset('images/codescr.jpg')}}" alt="Drag drop image"></a></p>
                            <div class="caption">
                                <p>If you're an advanced user and know your way around HTML, choose the HTML Source Editor.</p>
                                <p><a href="{{url('/newsletter/basic-settings?type=plain-html')}}" class="btn btn-primary btn-lg" role="button">HTML Source Editor</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                
            </div>
            <!-- rightside close-->	
        </div>
        <!-- row close-->	
    </div>
    </div>
</section>
@stop