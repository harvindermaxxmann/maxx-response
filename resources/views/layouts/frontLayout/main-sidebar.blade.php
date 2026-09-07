<div class="left-nav fixed-to-left">
    <ul> 
    
     @if(Auth::check())
    <li @if(Session::has('menuactive') && Session::get('menuactive')=="dashboard") class="active" @endif><a href="{{url('/dashboard')}}">Dashboard</a></li> 
    <li @if(Session::has('menuactive') && Session::get('menuactive')=="Design") class="active" @endif id="accordion" role="tablist" aria-multiselectable="true">
    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
    Design
    </a>
    <ul id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
    <li @if(Session::has('menuactive') && Session::get('menuactive')=="newsletter") class="active" @endif><a href="{{url('/newsletter/choose-html-or-plain')}}">Newsletters</a></li>
    <li @if(Session::has('menuactive') && Session::get('menuactive')=="Landing Page") class="active" @endif><a href="{{url('/landing-page/choose-template')}}">Landing Pages</a></li>
    <li>
        <a href="javascript:void(0);">Surveys</a>                        
    </li>
    <li>
        <a href="javascript:void(0);">Polls</a>                        
    </li>
    <li class="accordion_sub">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_1" aria-expanded="false" aria-controls="collapseOne_1">Invitations <span data-toggle="tooltip" data-placement="right" title="Create guest list and guest preferences"><i class="fa fa-info-circle" aria-hidden="true"></i>
</span></a>
        <ul id="collapseOne_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_1">
            <li class="accordion_sub_child">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_1_1" aria-expanded="false" aria-controls="collapseOne_1_1">Invitations with RSVP</a>
                <ul id="collapseOne_1_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_1_1">
                    <li><a href="javascript:void(0);">Events and Corporates</a></li>
                    <li><a href="javascript:void(0);">Weddings</a></li>
                    <li><a href="javascript:void(0);">Socials</a></li>
                </ul>
            </li>
            <li class="accordion_sub_child">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_1_2" aria-expanded="false" aria-controls="collapseOne_1_2">Invitations without RSVP</a>
                <ul id="collapseOne_1_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_1_2">
                    <li><a href="javascript:void(0);">Events and Corporates</a></li>
                    <li><a href="javascript:void(0);">Weddings</a></li>
                    <li><a href="javascript:void(0);">Socials</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li><a href="javascript:void(0);">OBD and IVR</a></li>
    </ul>
    </li>
    <li id="accordion2" role="tablist" aria-multiselectable="true">
    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsethree" aria-expanded="false" aria-controls="collapsethree">
    Campaigns
    </a>
    <ul id="collapsethree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingthree">
    <li><a href="{{url('/sms-campaign-list')}}">SMS Campaigns</a></li>
    <li><a href="{{url('/email-campaign-list')}}">Email Campaigns</a></li>
    <li><a href="{{url('/obd-and-ivr-campaign-list')}}">OBD and IVR Campaigns</a></li>
    <li><a href="{{url('/google-ads-campaign-list')}}">Google Ads Campaigns</a></li>
    <li><a href="{{url('/facebook-ads-campaign-list')}}">Facebook Ads Campaigns</a></li>
    </ul>
    </li>   
    <li id="accordion3" role="tablist" aria-multiselectable="true">
    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
    Reports
    </a>
    <ul id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
    <li><a href="{{url('/sms')}}">SMS</a></li>
    <li><a href="{{url('/email')}}">Email</a></li>
    <li><a href="{{url('/invitations-and-rsvp')}}">Invitations and RSVP's</a></li>   
    </ul>
    </li>
    <li @if(Session::has('menuactive') && Session::get('menuactive')=="Manage Account") class="active" @endif id="accordion1" role="tablist" aria-multiselectable="true">
    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="false" aria-controls="collapsetwo">
    Manage Account
    </a>
    <ul id="collapsetwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtwo">
    <li @if(Session::has('menuactive') && Session::get('menuactive')=="my-account") class="active" @endif><a href="{{url('/my-account')}}">Profile</a></li>
    <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="contacts") class="active" @endif href="{{url('/contact-lists')}}">Contacts</a></li>
    <li><a href="javascript:;">Settings</a></li>    
    </ul>
    </li>                   
    <li><a href="{{url('/drafts/')}}">Drafts</a></li>

@endif

    </ul>                           

    <div class="back-btn text-right">
        <a href="javascript:history.go(-1)" style=""><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
    </div>
</div>

