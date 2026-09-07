


<div class="mainNav navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container{{ Request::is('/') || Request::is('pricing') || Request::is('login') || Request::is('register') ? '' : '-fluid' }}">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a href="{{ route('index') }}" class="maxxlogo">
    <img class="logo" src="{{ asset('images/logo_maxxresponse.png') }}" alt="Logo">
</a>
        </div>
        <nav class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                
               @if(!Auth::check())
                    <li class="visible-xs visible-sm"><a @if(Session::has('menuactive') && Session::get('menuactive')=="signin") class="signup" @endif href="{{url('/login')}}" >Login</a></li>
                    <li class="visible-xs visible-sm"><a href="{{url('/register')}}" @if(Session::has('menuactive') && Session::get('menuactive')=="signup") class="signup" @endif >Register</a></li>
                @endif

                @if(Auth::check())
                    <!-- <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="sms") class="signup" @endif href="{{url('/sms')}}">Sms</a></li>
                    <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="drafts") class="signup" @endif href="{{url('/drafts')}}">Drafts</a></li>
                    <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="landingpage") class="signup" @endif href="{{url('/lps/manage')}}">Landing Pages</a></li>
                    <li><a @if(Session::has('menuactive') && Session::get('menuactive')=="contacts") class="signup" @endif href="{{url('/contact-lists')}}">Contacts</a></li> -->
                    <li class="dropdown @if(Session::has('menuactive') && Session::get('menuactive')=="dashboard") active @endif">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi {{Auth::user()->name}}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <!--li class="dropdown-header">Main Page</li-->
                            <li @if(Session::has('menuactive') && Session::get('menuactive')=="my-account") class="active" @endif><a href="{{url('/my-account')}}">Manage Account</a></li>
                            <li @if(Session::has('menuactive') && Session::get('menuactive')=="dashboard") class="active" @endif><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li @if(Session::has('menuactive') && Session::get('menuactive')=="pricing") class="active" @endif><a href="{{url('/pricing')}}">Upgrade Your Plan</a></li>
                            <li><a href="{{url('/logout')}}">Log Out</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
    
    
    
    
</div>



<div id="contents">

    


