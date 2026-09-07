@extends('layouts.frontLayout.front-layout')
@section('content')

<div id="contents">
    <section class="page-section p-0 d-flex">
    @include('layouts.frontLayout.main-sidebar')
    <div class="right-panel">
    <div class="container-fluid">
    	<div class="planline page-title pad_top10 text-center">
            <span>Create Google Ads Campaign</span>
        </div>
        <div class="clearfix"></div>

        <div class="ads-campaign">
                <form action="">
                    <h4>Campaign Settings</h4>
                    <div class="form-group">
                        <label>Campaign Name <span class="red">*</span></label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Budget <span class="red">*</span></label>
                        <div class="row">
                            <div class="col-xs-6 col-lg-2">
                                <div class="input-group">
                                  <div class="input-group-addon" style="border: none; background-color: #f6f6f6; color: #777;">$</div>
                                  <input type="number" class="form-control" id="exampleInputAmount" placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-xs-6 col-lg-2">
                                <select class="form-control" id="budget">
                                    <option value="daily" data-description="Use a fixed budget per day.">Daily</option>    
                                    <option value="lifetime" data-description="What you're willing to spend over the entire duration of your campaign.">Lifetime</option>    
                                </select>

                            </div>

                            <div class="col-xs-12 col-lg-8">
                                <div id="budget_description" class="pad_top15"></div>
                            </div>
                        </div>
                        
                    </div>

                    <h4>Settings <span>AdGroup 1</span></h4>
                    <div class="form-group">
                        <label>AdGroup Name</label>
                        <input type="text" class="form-control" value="AdGroup 1">
                    </div>

                    <div class="form-group">
                        <label>Optimization Strategy</label>
                        <div class="row">
                            <div class="col-xs-6 col-lg-2">
                                <select class="form-control" id="strategy">
                                    <option value="Conversions" data-description="Target people most likely to convert, like signups and purchases.">Conversions</option>    
                                    <option value="Clicks" data-description="Focus on increasing traffic by maximizing clicks.">Clicks</option>
                                    <option value="Impressions" data-description="Maximize how many times your ads are shown.">Impressions</option>  
                                </select>
                            </div>
                            <div class="col-xs-6 col-lg-3">
                                <div class="input-group">
                                  <div class="input-group-addon" style="border: none; background-color: #f6f6f6; color: #777;">$</div>
                                  <input type="number" class="form-control" id="exampleInputAmount" placeholder="Amount">
                                  <div class="input-group-addon" style="border: none; background-color: #f6f6f6; color: #777;">Target CPC</div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-7">
                                <div id="strategy_description" class="pad_top15"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Start and End Dates</label>
                        <input type="text" name="datetimes" class="form-control">
                    </div>

                    <h4>Audience <span>AdGroup 1</span></h4>
                    <a href="#" class="cust_aud">
                    <div class="panel panel-default audience-info">
                      <div class="panel-body">
                        <div class="media">
                          <div class="media-left">
                           <i class="fa fa-users" aria-hidden="true"></i>
                          </div>
                          <div class="media-body">
                            <h5>Your Customized Audiences Here</h5>
                            <p>Target your customized audiences by creating new ones or choose existing ones from the buttons above.</p>
                          </div>
                        </div>
                      </div>
                    </div></a>

                    <div class="form-group">
                        <label>Locations</label>
                        <div class="clearfix">
                            <div class="pull-left">
                                <label class="switch">
                                  <input type="checkbox" id="target_location" checked>
                                  <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="pull-left pad_left20 ">
                                <div id="target_location_automatically">
                                    <p class="pad_top4">Automatically targeting the best locations (Recommended)</p>
                                </div>
                                <div id="target_location_manually" style="display: none;">
                                    <p class="pad_top4">Manually targeting locations</p>
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <div class="input-group">
                                              <div class="input-group-addon" style="border: none; background-color: #f6f6f6; color: #777;"><i class="fa fa-map-marker" aria-hidden="true"></i>
</div>
                                              <input type="text" class="form-control"> 
                                              
                                            </div>
                                        </div>

                                        <div class="pull-left mar_left15" style="padding-top: 8px;">
                                            <label class="switch">
                                              <input type="checkbox" id="including_excluding" checked>
                                              <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <p class="pull-left mar_left15" style="padding-top: 12px;"><span id="including_text">Including</span> <span id="excluding_text" style="display: none;">Excluding</span></p>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <h4>Ads <span class="badge" style="color:#fff; font-size:11px;">0</span> <span>AdGroup 1</span></h4>

                    <div class="row ads-choose">
                        <div class="col-xs-12 col-lg-3">
                            <a href="javascript:void(0);" class="thumbnail">
                              <div><i class="fa fa-th" aria-hidden="true"></i></div>
                              <div class="caption">
                                <h3>Choose</h3>
                                <p>Choose ads from your Ad Library.</p>
                              </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-lg-3">
                            <a href="javascript:void(0);" class="thumbnail">
                              <div><i class="fa fa-paint-brush" aria-hidden="true"></i></div>
                              <div class="caption">
                                <h3>Create</h3>
                                <p>Create custom ads using our easy-to-use tool.</p>
                              </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-lg-3">
                            <a href="javascript:void(0);" class="thumbnail">
                              <div><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>
                              <div class="caption">
                                <h3>Upload</h3>
                                <p>Already have finished ads? Upload them here.</p>
                              </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-lg-3">
                            <a href="javascript:void(0);" class="thumbnail">
                              <div><i class="fa fa-flask" aria-hidden="true"></i></div>
                              <div class="caption">
                                <h3>Request Free Ads</h3>
                                <p>Tell us your requirements and we'll make a complete set of ads for you.</p>
                              </div>
                            </a>
                        </div>
                    </div>


                    <h4>Connect Google</h4>

                    <div class="connect">
                        <h5>Google Account</h5>
                        <p>We need your google account information so you can reach potential customers. Your ads will appear in the Newsfeed and link to your website.</p>
                        <p>
                            <button type="button" class="btn btn-primary"><i class="fa fa-google" aria-hidden="true"></i> Log in with Google</button>
                        </p>
                    </div>


                    <h4>Launch and Pay</h4>
                    <div class="payment-method">
                        <h5 class="text-center">No payment methods.</h5>
                       

                        <p id="have_promo"><a href="javascript:void(0);">Have a promo code?</a></p>

                        <div id="promo_code" style="display: none;">
                          <p><a href="javascript:void(0);">Promo Code (hide promo)</a></p>
                          <div class="form-inline">
                <div class="form-group">
                  <input type="email" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary mar_left15">Apply</button>
              </div>
                        </div>
                    </div>


                    <h4>Ready To Launch</h4>
                    <div class="panel panel-default launch">
                      <div class="panel-body text-center">
                        <button type="submit" class="btn btn-lg btn-primary">Launch</button>
                        <p class="mar_top15">Excited? You should be!</p>
                      </div>
                    </div>



                </form>
            </div>




    </div>
	</div>
</div>

</section>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
$('#budget').change(function(){
    var $selected = $(this).find(':selected');
    
    $('#budget_description').html($selected.data('description'));
}).trigger('change');

$('#strategy').change(function(){
    var $selected = $(this).find(':selected');
    
    $('#strategy_description').html($selected.data('description'));
}).trigger('change');

$(function() {
  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'M/DD hh:mm A'
    }
  });
});

$("#target_location").change(function(){
    if(this.checked) {
        $("#target_location_automatically").show();
        $("#target_location_manually").hide();
    } else {
         $("#target_location_automatically").hide();
        $("#target_location_manually").show();
    }
});


$("#including_excluding").change(function(){
    if(this.checked) {
        $("#including_text").show();
        $("#excluding_text").hide();
    } else {
         $("#including_text").hide();
        $("#excluding_text").show();
    }
});

$("#have_promo a").click(function(){
    $("#have_promo").hide();
    $("#promo_code").show();
   
});

$("#promo_code a").click(function(){
    $("#have_promo").show();
    $("#promo_code").hide();
   
});




</script>

@stop