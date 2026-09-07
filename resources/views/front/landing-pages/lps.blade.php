@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center planline" style="padding:0;">
                <span>Landing Pages</span>
            </div>
        </div>
        
        @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif

        <div class="row">
            <div class="col-xs-12 mar_bottom15">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="btn btn-primary" href="{{url('/landing-page/choose-template')}}">Create Landing Page</a>
                    </li>
                </ul>
            </div>
        </div>
		
	<div class="clearfix"></div>	
		
		<div class="row mar_top50 blocks_div">
		
				<!-- leftside  -->
			<div class="col-xs-12 col-sm-5 col-md-3">
                <div class="left-nav">
                    <ul>
				 @if(Auth::check())
                    <!--li><a @if(Session::has('menuactive') && Session::get('menuactive')=="sms") class="signup" @endif href="{{url('/sms-campgain')}}">Sms</a></li>
                    <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="drafts") class="signup" @endif href="{{url('/drafts')}}">Drafts</a></li>
                    <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="landingpage") class="signup" @endif href="{{url('/lps/manage')}}">Landing Pages</a></li>
                    <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="contacts") class="signup" @endif href="{{url('/contact-lists')}}">Contacts</a></li-->
					<li @if(Session::has('menuactive') && Session::get('menuactive')=="dashboard") class="active" @endif><a href="{{url('/dashboard')}}">Dashboard</a></li>	
					<li @if(Session::has('menuactive') && Session::get('menuactive')=="my-account") class="active" @endif><a href="{{url('/my-account')}}">Manage Account</a></li>
                    <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="contacts") class="signup" @endif href="{{url('/contact-lists')}}">contact</a></li>	
					<li><a href="javascript:;">Setting</a></li>		
                    <!--li class="dropdown @if(Session::has('menuactive') && Session::get('menuactive')=="dashboard") active @endif">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi {{Auth::user()->name}}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <!--li class="dropdown-header">Main Page</li>
                            
                            
                        </ul>
                    </li-->
                @endif							
               </div>
            </div><!-- leftside  -->
		
		<!-- rightside -->
			<div class="col-xs-12 col-sm-7 col-md-9">
				
			<div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="60" class="text-center">#</th>
                    <th width="20%"></th>
                    <th>Name</th>
                    <th>Modified on</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($lps))
                    @foreach($lps as $dkey=> $landingpage)
                        <tr>
                            <td width="60" class="text-center"><strong>{{++$dkey}}</strong></td>
                            <td>
                                @if(!empty($landingpage['page']))
                                    <img width="80" height="80" class="objectfit_contain" src="{{asset('images/PageImages/'.$landingpage['page']['image'])}}">
                                @else
                                    <img width="80" height="80" class="objectfit_contain" src="{{asset('images/no-draft.png')}}">
                                @endif
                            </td>
                            <td>
                                <h4><a href="{{url('/html/editor?type=landing-page&a=lp&ref='.$landingpage['unique_id'])}}">{{$landingpage['name']}}</a></h4>

                            </td>
                            <td>{{date('F d, Y',strtotime($landingpage['updated_at']))}}
                                <br>
                                {{date('h:ia',strtotime($landingpage['updated_at']))}}
                            </td>
                            <td><a title="Start SMS Campaign" class="btn btn-success" href="javascript:;" data-toggle="tooltip" data-placement="top"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                <a title="Edit Page" class="btn btn-primary" href="{{url('/html/editor?type=landing-page&a=lp&ref='.$landingpage['unique_id'])}}" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"></i></a>
                                @if(!empty($landingpage['max_subdomain']))
                                    <a target="_blank" title="Preview" class="btn btn-warning" href="{{$landingpage['max_subdomain']}}" data-toggle="tooltip" data-placement="top" data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"></i></a>
                                @endif
                                <a title="Delete Page" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Landing Page?');" href="{{url('/delete-landing/'.$landingpage['id'])}}" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">
                            (none).
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>	
				
				
				
				
			</div><!-- right div -->		
		
		
		
		</div>
	
    </div>
</section>
@stop