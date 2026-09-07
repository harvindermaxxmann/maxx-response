<?php use App\PackageFeature; use App\Pricing; ?>
<div class="col-md-12">
    <div class="container backg_sec">
        <div class="row">
            @foreach($packages as $pkey=> $package)
                <form action="{{url('/buy-package')}}" method="post">@csrf
                    <input type="hidden" name="plan" style="display: none;" id="ActivePlan" value="{{$discount['value']}}"/>
                    <div class="col-xs-12 col-sm-4 col-md-4 servattr @if($pkey==1) populated @endif text-center">
                        <h3>{{$package['package_name']}}</h3>
                        <p>{{$package['description']}}</p>
                        <input type="hidden" name="package" value="{{$package['id']}}">
                        @if(!empty($package['listsize']))
                            <div class="selectplan">
                                <label>List Size</label>
                                <select class="form-control" id="getListsize" name="listsize">
                                    @foreach($package['listsize'] as $listsize)
                                        <option data-packageid="{{$package['id']}}" value="{{$listsize['list_size']}}">{{$listsize['list_size']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <?php $pricingdetails = Pricing::calculatePrice($package['id'],$package['listsize'][0]['list_size'],$discount);?>
                            <div class="pprice"><strong id="UpdatePrice-{{$package['id']}}">{{$pricingdetails['symbol']}} {{number_format($pricingdetails['monthprice'],2)}}</strong><sub>/Month</sub> </div>
                            <div class="plink">
                                <button type="submit" class="btn btn-default">Choose Package</button>
                            </div>
                        @endif
                        @foreach($features as $feature)
                            <div class="serviceinn">
                                <h2 class="serviceheading">{{$feature['name']}}</h2>
                                <ul>
                                    @foreach($feature['subfeatures'] as $subfeature)
                                        <?php $featExistsInPackage = PackageFeature::checkfeatureExists($package['id'],$subfeature['id']); ?>
                                        @if($featExistsInPackage =="yes")
                                            <li>{{$subfeature['name']}} <span class="glyphicon glyphicon-ok"></span></li>
                                        @else
                                            <li>{{$subfeature['name']}}<span class="glyphicon glyphicon-remove"></span></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
               </form> 
            @endforeach	
        </div>
    </div>
</div>