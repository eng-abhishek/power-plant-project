<!DOCTYPE html>
<html lang="en" >

<!-- begin::Head -->
<head>
    <meta charset="utf-8" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ChainSwap') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
      WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>
<!--end::Web font -->
<!--begin::Base Styles -->
<link href="{{asset('assets/backend/css/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/backend/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
<!--end::Base Styles -->

<link rel="shortcut icon" href="{{asset('assets/backend/images/favicon.ico')}}" />

@yield('styles')

</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">

        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url({{asset('assets/backend/images/bg-2.jpg')}});">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">

                @yield('content')

            </div>
        </div>
    </div>
    <!-- end:: Page -->

    <!--begin::Base Scripts -->
    <script src="{{asset('assets/backend/js/vendors.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/backend/js/scripts.bundle.js')}}" type="text/javascript"></script>
    <!--end::Base Scripts -->

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    @yield('scripts')

</body>
<!-- end::Body -->

</html>