<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">

    <title>Antikvarijat Biblos - Knjige, vedute i zemljovidi</title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="Dobrodošli na stranice Antikvarijata Biblos, Palmotićeva 28, Zagreb. Radno vrijeme pon-pet 09-20h, sub 09-14h.e">
    <meta name="keywords" content="antikvarijat,stare knjige,vedute,mape,biblos">
    <meta name="author" content="Antikvarijat Biblos">
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" color="#fe6a6a" href="safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{ asset('css/theme.min.css') }}">

    @stack('css_after')

    @livewireStyles
</head>
<!-- Body-->
<body class="handheld-toolbar-enabled">
<!-- Topbar-->
<div class="topbar topbar-light bg-light d-none d-md-block">
    <div class="container">
        <div class="topbar-text text-nowrap ">
            <a class="topbar-link me-4" href="tel:+38514816574"><i class="ci-phone"></i> +385 1 48 16 574</a>
            <a class="topbar-link me-4" href="https://www.google.com/maps/place/Biblos/@45.810942,15.9794894,17.53z/data=!4m5!3m4!1s0x4765d7aac4f8b023:0xb60bceb791b31ede!8m2!3d45.8106161!4d15.9816921?hl=hr" target="_blank"><i class="ci-location"></i> Palmotićeva 28, Zagreb </a>
           <a class="topbar-link d-none d-md-inline-block" href="{{ route('kontakt') }}">  <i class="ci-time"></i> PON-PET: 9-20 | SUB: 9-14</a></div>

        <div class="ms-3 text-nowrap">

            <a class="topbar-link d-none d-md-inline-block" href="{{ route('faq') }}">Česta pitanja</a>
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
<link rel="stylesheet" media="screen" href="{{ asset('css/tiny-slider.css') }}"/>
<!-- Vendor scrits: js libraries and plugins-->
<script src="{{ asset('js/jquery/jquery-2.1.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/tiny-slider.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.polyfills.min.js') }}"></script>
<!-- Main theme script-->
<script src="{{ asset('js/theme.min.js') }}"></script>

@livewireScripts

<script>
    $(() => {
        $('#search-input').on('keyup', (e) => {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('search-form').submit();
            }
        })
    });

    /**
     *
     * @param type
     * @param search
     */
    function setURL(type, search) {
        let url = new URL(location.href);
        let params = new URLSearchParams(url.search);
        let keys = [];

        for(var key of params.keys()) {
            if (key === type) {
                keys.push(key);
            }
        }

        keys.forEach((value) => {
            if (params.has(value)) {
                params.delete(value);
            }
        })

        if (search) {
            params.append(type, search);
        }

        console.log(params)

        url.search = params;
        //location.href = url;
    }
</script>

@stack('js_after')

</body>
</html>
