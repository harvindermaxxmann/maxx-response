@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section padlowtopbot" style="padding-bottom:30px;">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1 class="title-section"><span class="title-regular">Complete Purchase</span></h1>
         </div>
      </div>
   </div>
</section>
<section class="page-section padlowtopbot" style="padding-top:0px;">
      <div class="container">
         @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!!   $error !!}
            </div>
        @endforeach
         <form id="CompletePurchase" action="{{url('complete-purchase')}}" method="post" autocomplete="off">@csrf
            <div class="col-md-12 backg_sec payMoptin">
               <h5>Payment information:</h5>
               <div class="row mar_top20">
                  <div class="col-xs-12 col-md-6">
                     <div class="form-group">
                        <input type="text" name="card_number" class="form-control" id="cardnumber" placeholder="Card Number" value="{{old('card_number')}}" required>
                     </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                     <ul class="paymenticon">
                        <li><a href="javascript:;"><i class="fa fa-cc-visa"></i></a></li>
                        <li><a href="javascript:;"><i class="fa fa-cc-mastercard"></i></a></li>
                        <li><a href="javascript:;"><i class="fa fa-cc-amex"></i></a></li>
                        <li><a href="javascript:;"><i class="fa fa-cc-discover"></i></a></li>
                     </ul>
                  </div>
               </div>
               <!-- row close -->
               <div class="row mar_top10">
                  <div class="col-xs-12 col-md-12">
                     <div class="row">
                        <div class="col-xs-12 col-md-4">
                           <input type="hidden" name="order_id" value="{{$_GET['orderId']}}">
                           <select name="card_expiry_month" class="form-control" required>
                              <option value="">Expiration Month</option>
                              @for ($m=1; $m<=12; $m++) {
                                 <?php $month = date('F', mktime(0,0,0,$m, 1, date('Y')));?>
                                 <option value="{{$m}}" {{(old("card_expiry_month") == $m ? "selected":"")}}>{{$month}}</option>
                              @endfor
                           </select>
                        </div>
                        <div class="col-xs-12 col-md-4">
                           <select name="card_expiry_year" class="form-control" required>
                              <option value="">Expiration Year</option>
                              <?php $next10years = date('Y')+10; ?>
                              @for ($year=date('Y'); $year<=$next10years; $year++) {
                                 <option value="{{$year}}" {{(old("card_expiry_year") == $year ? "selected":"")}}>{{$year}}</option>
                              @endfor
                           </select>
                        </div>
                        <div class="col-xs-12 col-md-4">
                           <input type="password" name="cvv" class="form-control" id="Cvv" placeholder="CVV" required>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <p class="text-center">
               <button type="submit" class="btn btn-primary">Submit Payment</button>
               </p>
         </form>
      </div>
</section>
<script type="text/javascript">
  $("#CompletePurchase").submit(function(e){
      $('.loadingDiv').show();
  });
</script>
@stop