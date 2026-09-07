@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard" style="background-color: #f3f3f3;">
    <div class="container">
        @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        <div class="lp_settings">
            <h1 class="text-center">My landing page settings</h1>
            <form action="{{url('/lp-settings')}}" method="post">@csrf
                <div class="settings_section">
                    <input type="hidden" name="ref" value="{{$uniqid}}">
                    <a class="heading" role="button" data-toggle="collapse" href="#collapseSeo" aria-expanded="false" aria-controls="collapseSeo">SEO settings <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <div class="collapse in" id="collapseSeo">
                        <div class="fields">
                            <div class="form-group">
                                <label>Page title</label>
                                <input type="text" name="page_title" placeholder="Page title" class="form-control" required value="{{(!empty($landingdetails->page_title)) ? $landingdetails->page_title :''}}">
                                <span id="helpBlock" class="help-block">This name will appear as the title of your page.</span>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" placeholder="Enter Description" name="page_description" rows="5" required>{{(!empty($landingdetails->page_description)) ? $landingdetails->page_description :''}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.settings_section -->
                <div class="settings_section">
                    <a class="heading" role="button" data-toggle="collapse" href="#collapseUrl" aria-expanded="false" aria-controls="collapseUrl">Landing Page URL settings <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <div class="collapse in" id="collapseUrl">
                        <div class="fields">
                            <div class="form-group">
                                <label>Use one of Maxxresponse subdomains</label>
                                <div class="row">
                                    @if(!empty($landingdetails->max_subdomain))
                                        <div class="col-xs-12 https_text">
                                            MaxxResponse Subdomain :- {{$landingdetails->max_subdomain}}
                                        </div>
                                    @else
                                        <div class="col-xs-2 https_text">
                                            http://
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" name="subdomain" class="form-control">
                                        </div>
                                        <div class="col-xs-1 dot_text">
                                            .
                                        </div>
                                        <div class="col-xs-5">
                                            <select class="form-control" name="domain">
                                                <option value="mxmcm.com">mxmcm.com</option>
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- @if(!empty($landingdetails->user_domain))
                                <p>Your Domain :- {{$landingdetails->user_domain}}</p>
                            @else
                                <input type="hidden" id="userDomain" name="user_domain" >
                                <p>Assign your own domain</p>
                                <p><a href="javascript:;" data-toggle="modal" data-target="#addNewDomain">+ Add a new domain</a></p>
                                <p><small>There are two ways to assign your domain to your Landing Page: <a href="#">Change DNS settings</a> or <a href="#">Add a CNAME entry to your subdomain</a>.</small></p>
                            @endif -->
                        </div>
                    </div>
                </div>
                <div class="bottom-links">
                    <div class="row">
                        <div class="col-sm-4"><a href="{{url('/html/editor?type=landing-page&a=lp&ref='.$uniqid)}}" class="btn btn-primary">Previous Step</a></div>
                        <div class="col-sm-8 text-right">
                            <input type="submit" class="btn btn-primary" value="Save">
                            <!-- <input type="submit" class="btn btn-primary" value="Publish"> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.lp_settings -->
    </div>
</section>
<!-- Add New Domain Model Box -->
<div id="addNewDomain" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="addNewDomain">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title">Add new domain</h1>
            </div>
            <form id="addDomainForm" method="post" action="javascript:;"> @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="url" id="domainUrl" name="user_domain" class="form-control" placeholder="https://www.testing.com" required>
                            </div>
                        </div>
                        <p class="help-text">Using a subdomain is optional, but always a good idea. If you want to use "www" as a subdomain, make sure you don't have a website on that domain.</p>
                    </div>
                    <div class="bottom-links">
                        <div class="text-right">
                            <input type="submit"   class="btn btn-primary" value="Add domain">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /#addNewDomain -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#addDomainForm").submit(function(e){
            e.preventDefault();
            var domainurl = $('#domainUrl').val();
            $('#userDomain').val(domainurl);
            $('#addNewDomain').modal('hide');
        });
    });
</script>
@stop