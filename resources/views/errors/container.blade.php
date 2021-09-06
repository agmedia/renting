<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Skladišna Logistika" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>  @yield ('title' ) - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('temp/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/swiper.css') }}" type="text/css" />
    <!-- shop Demo Specific Stylesheet -->
    <link rel="stylesheet" href="{{ asset('demos/shop/shop.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('demos/shop/css/fonts.css') }}" type="text/css" />
    <!-- / -->
    <link rel="stylesheet" href="{{ asset('temp/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/magnific-popup.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/responsive.css') }}" type="text/css" />
    <!-- Include mmenu files -->
    <link href="{{ asset('dist/mmenu.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/mburger.css') }}" rel="stylesheet" />
    <script src="{{ asset('dist/mmenu.js') }}"></script>
    <!-- Fire the plugin -->
    <script>
        document.addEventListener(
            "DOMContentLoaded", () => {
                new Mmenu( "#menu", {
                    "extensions": [
                        "pagedim-black",
                        "border-full"
                    ],
                    "navbars": [
                        {
                            "position": "bottom",
                            "content": [
                                "<a class='fa fa-envelope' href='#/'></a>",
                                "<a class='fa fa-twitter' href='#/'></a>",
                                "<a class='fa fa-facebook' href='#/'></a>"
                            ]
                        }
                    ]
                });
            }
        );
    </script>
    @stack('css_before')
    @stack('css')
</head>
<body class="stretched side-panel-left" data-loader="9" data-loader-color="#C11226" data-animation-in="fadeIn" data-speed-in="1500" data-animation-out="fadeOut" data-speed-out="800"
>
<!-- Document Wrapper -->
<div id="wrapper" class="clearfix">
    <!-- Topbar -->
@include('front.layouts.partials.topbar')
<!-- Header -->
@include('front.layouts.partials.navbar')
<!-- Slider -->
{{-- @include('front.layouts.partials.slider') --}}
<!-- Content -->
@yield('content')
<!-- Footer -->
    @include('front.layouts.partials.footer')
</div><!-- #wrapper end -->
@include('front.layouts.partials.sidenav')
<!-- Go To Top -->
<div id="gotoTop" class="icon-angle-up"></div>
<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>
<!-- External JavaScripts
============================================= -->
<script src="{{ asset('temp/js/jquery.js') }}"></script>
<script src="{{ asset('js/blazy.min.js') }}"></script>
<script src="{{ asset('temp/js/plugins.js') }}"></script>
<!-- Footer Scripts
============================================= -->
<script src="{{ asset('temp/js/functions.js') }}"></script>
@stack('js')
<script>
    jQuery(function() {
        jQuery( "#side-navigation" ).tabs({ show: { effect: "fade", duration: 400 } });
    });
</script>

</body>
</html>
