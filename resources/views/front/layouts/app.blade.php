<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title> @yield('title') </title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="@yield('description')">

    <meta name="author" content="Antikvarijat Biblos">
    @stack('meta_tags')
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('settings.images_domain') . 'media/img/favicon-32x32.png' }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('settings.images_domain') . 'media/img/favicon-32x32.png' }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('settings.images_domain') . 'media/img/favicon-16x16.png' }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('settings.images_domain') . 'apple-touch-icon.png' }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('settings.images_domain') . 'favicon-32x32.png' }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('settings.images_domain') . 'favicon-16x16.png' }}">
    <link rel="mask-icon" href="{{ config('settings.images_domain') . 'safari-pinned-tab.svg' }}" color="#314837">
    <meta name="msapplication-TileColor" content="#314837">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{ config('settings.images_domain') . 'css/theme.min.css' }}">

    @if (config('app.env') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-YY35049KQZ"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-YY35049KQZ');
        </script>
    @endif

    @stack('css_after')

    <style>
        [v-cloak] { display:none !important; }
    </style>

</head>
<!-- Body-->
<body class="handheld-toolbar-enabled">
<!-- Topbar-->
<div class="topbar topbar-light bg-light d-none d-md-block">
    <div class="container">
        <div class="topbar-text text-nowrap">
            <a class="topbar-link me-4" href="tel:+38514816574"><i class="ci-phone"></i> +385 1 48 16 574</a>
            <a class="topbar-link me-4" href="https://www.google.com/maps/place/Biblos/@45.810942,15.9794894,17.53z/data=!4m5!3m4!1s0x4765d7aac4f8b023:0xb60bceb791b31ede!8m2!3d45.8106161!4d15.9816921?hl=hr" target="_blank"><i class="ci-location"></i> Palmotićeva 28, Zagreb </a>
           <a class="topbar-link d-none d-md-inline-block" href="{{ route('kontakt') }}"><i class="ci-time"></i> PON-PET: 9-20 | SUB: 9-14</a>
        </div>
        <div class="ms-3 text-nowrap">
            <a class="topbar-link d-none d-md-inline-block" href="{{ route('faq') }}">Česta pitanja</a>
            <a class="topbar-link ms-3 ps-3 border-start border-dark d-none d-md-inline-block" href="{{ route('catalog.route.page',['page' => 'o-nama']) }}">O nama</a>
            <a class="topbar-link ms-3 ps-3 border-start border-dark d-none d-md-inline-block" href="{{ route('kontakt') }}">Kontakt</a>
        </div>
    </div>
</div>

<div id="agapp">
    @include('front.layouts.partials.header')

    @yield('content')

    @include('front.layouts.partials.footer')

    @include('front.layouts.partials.handheld')
</div>

<!-- Back To Top Button-->
<a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up"></i></a>
<!-- Vendor Styles including: Font Icons, Plugins, etc.-->
<link rel="stylesheet" media="screen" href="{{ config('settings.images_domain') . 'css/tiny-slider.css' }}"/>
<!-- Vendor scrits: js libraries and plugins-->
<script src="{{ asset('js/jquery/jquery-2.1.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/tiny-slider.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.polyfills.min.js') }}"></script>
<!-- Main theme script-->
<script src="{{ asset('js/theme.min.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>

<script>
    $(() => {
        $('#search-input').on('keyup', (e) => {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('search-form').submit();
            }
        })
    });
</script>

@stack('js_after')

</body>
</html>
