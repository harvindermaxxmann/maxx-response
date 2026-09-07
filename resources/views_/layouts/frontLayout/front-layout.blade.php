<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title> Maxx Response</title>
        <!-- normalize core CSS -->
        <link href="{{ asset('css/front_css/normalize.css')}}" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/front_css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('css/front_css/carousel.css')}}" rel="stylesheet">
        <link href="{{ asset('css/fonts/glyphicons-halflings-regular.eot')}}" rel="stylesheet">
        <!-- Load jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="{{ asset('css/front_css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">
        <script src="{{ asset('js/front_js/ie-emulation-modes-warning.js')}}"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- Google Fonts - Change if needed -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400italic,400,700,300,600' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oxygen:400,700,300' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Eczar:400,500,600,700,800&display=swap" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Menu shrinking -->
        <script type="text/javascript" src="{{ asset('js/front_js/menu.js')}}"></script>
        <!-- Main styles of this template -->
        <link href="{{ asset('css/front_css/style.min.css?v='.date('his'))}}" rel="stylesheet">
        <!-- Custom CSS. Input here your changes -->
        <link href="{{ asset('css/front_css/custom.css?v='.date('his'))}}" rel="stylesheet">
        <link href="{{ asset('css/front_css/style.css?v='.date('his'))}}" rel="stylesheet">
        <!-- <link href="{{ asset('css/front_css/responsive.css?v='.date('his'))}}" rel="stylesheet"> -->
    </head>
    <style type="text/css">
    .loadingDiv {background-color: rgba(0, 0, 0, 0.6); background-image: url("../../images/ajax-loader.svg");background-position: center center;background-repeat: no-repeat;height: 100%;opacity: 1;position: fixed;right: 0;top: 0;width: 100%;z-index: 10000000;}
    #checkoutLoader {background: #ffffff;color: #666666;position: fixed;height: 100%;width: 100%;z-index: 5000;top: 0;left: 0;float: left;text-align: center;padding-top: 25%;opacity: .80;}
    .spinner {margin: 0 auto;height: 64px;width: 64px;animation: rotate 0.8s infinite linear;border: 5px solid firebrick;border-right-color: transparent;border-radius: 50%;}
        @keyframes rotate {0% {transform: rotate(0deg);}100% {transform: rotate(360deg);}}
    </style>
    <body>
        @include('layouts.frontLayout.front-header')
            @yield('content')
        @include('layouts.frontLayout.front-footer')
        <script type="text/javascript">
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <div class="loadingDiv" style="display: none;"></div>
        <div id="checkoutLoader" style="display:none;">
            <div class="spinner"></div>
            <br/>
            <p style="color: #FF0000;" id="CheckoutMessage">We are redirecting to Payment gateway.Please wait...</p>
        </div>
    </body>
</html>