<?php?>
<div class="side-bar">
  <ul>
    <li><a href="javascripr:void(0);">Dashboard</a></li>
    <li class="drop-downn">
      <a href="javascripr:void(0);" class="drp-click">Design</a>
      <ul class="sub-menu-side">
		<li><a href="https://maxxresponse.com/newsletter/choose-html-or-plain">Newsletters</a></li>
		<li><a href="https://maxxresponse.com/landing-page/choose-template">Landing Pages</a></li>
		<li><a href="javascript:void(0);">Surveys</a></li>
		<li><a href="javascript:void(0);">Polls</a></li>
		<li class="drop-downn">
			<a href="javascript:void(0);" class="drp-click">Invitations <span><i class="fa fa-info-circle" aria-hidden="true"></i></span></a>
			<ul class="sub-menu-side">
			<li class="drop-downn">
					<a href="javascript:void(0);" class="drp-click">Invitations with RSVP</a>
					<ul class="sub-menu-side">
						<li><a href="javascript:void(0);">Events and Corporates</a></li>
						<li><a href="javascript:void(0);">Weddings</a></li>
						<li><a href="javascript:void(0);">Socials</a></li>
					</ul>
				</li>
				<li class="drop-downn">
					<a href="javascript:void(0);" class="drp-click">Invitations without RSVP</a>
					<ul class="sub-menu-side">
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
    <li class="drop-downn open">
      <a class="drp-click" href="javascripr:void(0);">Campaigns</a>
      <ul class="sub-menu-side">
        <li><a href="https://maxxresponse.com/sms-campaign-list">SMS Campaigns</a></li>
        <li class="active"><a href="https://maxxresponse.com/email-campaign-list">Email Campaigns</a></li>
        <li><a href="https://maxxresponse.com/obd-and-ivr-campaign-list">OBD and IVR Campaigns</a></li>
        <li><a href="https://maxxresponse.com/google-ads-campaign-list">Google Ads Campaigns</a></li>
        <li><a href="https://maxxresponse.com/facebook-ads-campaign-list">Facebook Ads Campaigns</a></li>
      </ul>
    </li>
    <li class="drop-downn">
      <a href="javascripr:void(0);" class="drp-click">Reports</a>
      <ul class="sub-menu-side">
        <li><a href="https://maxxresponse.com/sms">SMS</a></li>
        <li><a href="https://maxxresponse.com/email">Email</a></li>
        <li><a href="https://maxxresponse.com/invitations-and-rsvp">Invitations and RSVP's</a></li>   
      </ul>
    </li>
    <li class="drop-downn">
      <a href="javascripr:void(0);" class="drp-click">Manage Account</a>
      <ul class="sub-menu-side">
        <li><a href="https://maxxresponse.com/my-account">Profile</a></li>
        <li><a href="https://maxxresponse.com/contact-lists">Contacts</a></li>
        <li><a href="javascript:;">Settings</a></li>    
      </ul>
    </li>
    <li><a href="javascripr:void(0);">Drafts</a></li>
  </ul>
  <div class="back-btn">
      <a href="javascript:history.go(-1)" style=""><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
  </div>
</div>

<script>
  $(document).ready(function(){
    jQuery('.drop-downn .drp-click').click(function(){
        jQuery('.drop-downn .drp-click').not(this).next().slideUp().parent().removeClass('open');
        jQuery(this).next().slideToggle().parent().toggleClass('open');
    });// according jQuery
  });
</script>