<div class="col-xs-12 col-sm-5 col-md-3">
    <div class="left-nav">
        <ul>
            <li><a href="{{url('/dashboard')}}">Dashboard</a></li> 
            <li id="accordion" role="tablist" aria-multiselectable="true">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Design</a>
                <ul id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                    <li>
                        <a href="{{url('/newsletter/choose-html-or-plain')}}">Newsletter</a>
                    </li>
                    <li>
                        <a href="{{url('/landing-page/choose-template')}}">Landing Pages</a>                        
                    </li>
                    <li>
                        <a href="javascript:void(0);">Surveys</a>                        
                    </li>
                    <li>
                        <a href="javascript:void(0);">Polls</a>                        
                    </li>
                    <li class="accordion_sub">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_1" aria-expanded="false" aria-controls="collapseOne_1">Invitations</a>
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
                </ul>
            </li>
            <li id="accordion2" role="tablist" aria-multiselectable="true">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsethree" aria-expanded="false" aria-controls="collapsethree">
                Campaign
                </a>
                <ul id="collapsethree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingthree">
                    <li><a href="{{url('/sms-campaign')}}">SMS Campaign</a></li>
                    <li><a href="{{url('/newsletter/choose-html-or-plain')}}">Email Campaign</a></li>
                </ul>
            </li>
            <li id="accordion3" role="tablist" aria-multiselectable="true">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                Reports
                </a>
                <ul id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
                    <li><a href="{{url('/sms-campgain')}}">SMS</a></li>
                    <li><a href="{{url('/newsletter/choose-html-or-plain')}}">Email</a></li>
                    <li><a href="javascript:void(0);">Invitations and RSVP's</a></li>
                </ul>
            </li>
            <li id="accordion1" role="tablist" aria-multiselectable="true">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="false" aria-controls="collapsetwo">Manage Account
                </a>
                <ul id="collapsetwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtwo">
                    <li><a href="{{url('/my-account')}}">Profile</a></li>
                    <li><a href="{{url('/contact-lists')}}">Contacts</a></li>
                    <li><a href="javascript:;">Settings</a></li>
                </ul>
            </li>
            
            <li><a href="{{url('/drafts')}}">Drafts</a></li>
        </ul>
    </div>
</div>