@if(count($templates)>0)
	@foreach($templates as $template)
		<div class="col-xs-12 col-md-3">
	        <div class="landing_box">
	            <a href="javascript:;" data-landingimage="{{url('images/PageImages/'.$template['image'])}}" data-thankyouimage= "{{url('/landing-assets/'.$template['template']['folder'].'/'.$template['template']['thankyou_image'])}}" data-pageid="{{$template['id']}}" data-templateid="{{$template['template_id']}}" class="landing_img_box processLandingPage"><img src="{{asset('images/PageImages/'.$template['image'])}}" class="img-responsive" alt="{{$template['name']}}" />
	            <span class="btn-border"><b>Use Theme</b></span>
	            </a>
	            <a href="javascript:;" class="landing_text_box">{{$template['name']}}</a>
	        </div>
	    </div>
	@endforeach
@else
	<span>No Landing Pages Found.</span>
@endif


