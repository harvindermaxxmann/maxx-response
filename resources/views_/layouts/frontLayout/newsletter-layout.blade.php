@foreach($templates as $template)
    <div class="col-xs-12 col-md-3">
        <div class="landing_box">
            <a href="{{url('process-template?template='.$template['id'].'&type=newsletter&ref='.$uniqid)}}" class="landing_img_box"><img src="{{asset('images/PageImages/'.$template['image'])}}" class="img-responsive" alt="{{$template['name']}}" />
            <span class="btn-border"><b>Use Theme</b></span>
            </a>
            <a href="{{url('process-template?template='.$template['id'].'&type=newsletter&ref='.$uniqid)}}" class="landing_text_box">{{$template['name']}}</a>
        </div>
    </div>
@endforeach