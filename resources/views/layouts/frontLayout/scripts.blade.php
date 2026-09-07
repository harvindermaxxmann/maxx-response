<!-- Scripts -->
<!-- Loads Bootstrap Main JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>
<script src="{{ asset('js/front_js/bootstrap.min.js')}}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('js/front_js/ie10-viewport-bug-workaround.js')}}"></script>
<!-- Initiate Google Maps - For more Infos look into the documentation -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="{{ asset('js/front_js/google-map.js')}}"></script>
<!-- Initiate Portoflio Script -->
<script src="{{ asset('js/front_js/isotope.min.js')}}"></script>
<script src="{{ asset('js/front_js/portfolio.js')}}"></script>
<!-- Initiate Fancybox/Lightbox Script -->
<!-- Fancybox/Lightbox -->
<script type="text/javascript" src="{{ asset('js/front_js/jquery.fancybox.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/front_js/jquery.fancybox.pack.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/front_css/jquery.fancybox.css')}}" media="screen" />
<script type="text/javascript" src="{{ asset('js/front_js/jquery.fancybox-media.js')}}"></script>
<!-- Initiate Fancybox/Lightbox for Videos -->
<script type="text/javascript">
    $(document).ready(function () {
        //disable cut,copy,paste
        $('.disableCutCopy').bind('copy paste cut',function(e) { 
            e.preventDefault(); 
        });
        /** Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
         */
        $('.fancybox-media')
        .attr('rel', 'media-gallery')
        .fancybox({
            openEffect: 'none',
            closeEffect: 'none',
            preEvffect: 'none',
            nextEffect: 'none',
            arrows: false,
            helpers: {
                media: {},
                buttons: {}
            }
        });
		
	 $('[data-toggle="tooltip"]').tooltip();
$(document).on("change", "#job22", function(){
var id = $(this).val();
if(id !=''){
      $.ajax({
        
            type : 'GET',
            url : '{{url("getcampaignId")}}/'+id,
           // data: {'id': id},
        dataType : 'JSON', 
            beforeSend: function(){
               $("#FetchHTML").html("<div class='alert alert-info'>Loading...</div>");
            },
            success:function(response){ 
                  var content =response.data; 
                  
                  $("#FetchHTML").val(content);                        
                              
               } 
         });

} else{
    alert("Please select the job.");
    return false;
}

});

  });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','#getCountry',function(){
            var country = $(this).val();
            if(country ==""){
                $('#getState').html('<option value="">Select State</option>');
                $('#AppendCities').html('<option value="">Select City</option>');
            }else{
                $('.loadingDiv').show();
                $.ajax({
                    type :'post',
                    data : {country: country},
                    url :'/get-states',
                    success:function(resp){
                        $('#getState').html(resp);
                        $('#AppendCities').html('<option value="">Select City</option>');
                        $('.loadingDiv').hide();
                    },
                    error:function(){

                    }
                })
            }
        })
        $(document).on('change','#getState',function(){
            var state = $(this).val();
            if(state ==""){
                $('#AppendCities').html('<option value="">Select City</option>');
            }else{
                $('.loadingDiv').show();
                $.ajax({
                    type :'post',
                    data : {state: state},
                    url :'/get-cities',
                    success:function(resp){
                        $('#AppendCities').html(resp);
                        $('.loadingDiv').hide();
                    },
                    error:function(){

                    }
                })
            }
        })
    });
</script>