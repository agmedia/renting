<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <base href="{{ config('app.url') }}">

    <!-- Title -->
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    <!-- Meta Tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="www.agmedia.hr">
    @stack('meta_tags')

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#183b64">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

    <!-- Css Link -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/all.min.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/jquery-ui.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/color.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/style.css?v=4") }}">


    @stack('css_after')

    <style>
        [v-cloak] { display:none !important; }
    </style>

</head>

@if (config('app.env') == 'production')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LKLJ86FLWH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-LKLJ86FLWH');
    </script>
@endif

<!-- Body-->
<body class="handheld-toolbar-enabled" >
<!--<div id="agapp">-->
    <div id="page-wrapper" class="bg-white">

        @include('front.layouts.partials.header')

        @yield('content')

     {{--  @if ( ! \Illuminate\Support\Facades\Route::is('index'))--}}
            @include('front.layouts.partials.footer')
        {{--  @endif --}}

        <!-- Scroll to top -->
        <a href="#" class="bg-secondary text-white" id="scroll"><i class="fas fa-angle-up"></i></a>
    </div>
<!--</div>-->


<!-- Javascript Files -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!--jQuery Layer Slider -->
<script src="{{ asset('assets/js/greensock.js') }}"></script>
<script src="{{ asset('assets/js/layerslider.transitions.js') }}"></script>
<script src="{{ asset('assets/js/layerslider.kreaturamedia.jquery.js') }}"></script>

@stack('js_middle')

<!--jQuery Layer Slider -->
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/tmpl.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dependClass-0.1.js') }}"></script>
<script src="{{ asset('assets/js/draggable-0.1.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slider.js') }}"></script>
<script src="{{ asset('assets/js/wow.js') }}"></script>
<script src="{{ asset('assets/js/validate.js') }}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script>
    $(() => {
        $('#search-input').on('keyup', (e) => {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('search-form').submit();
            }
        })

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

@stack('js_after')

</body>
</html>
