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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" color="#fe6a6a" href="safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{ asset('css/simplebar.min.css') }}"/>
    <link rel="stylesheet" media="screen" href="{{ asset('css/tiny-slider.css') }}"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{ asset('css/theme.min.css') }}">
</head>
<!-- Body-->
<body class="handheld-toolbar-enabled">
<!-- Topbar-->
<div class="topbar topbar-light bg-light">
    <div class="container">
        <div class="topbar-text text-nowrap "><i class="ci-phone"></i><a class="topbar-link me-4" href="tel:+38514816574">+385 1 48 16 574</a> <i class="ci-location"></i><a class="topbar-link" href="Palmotićeva 28, Zagreb ">Palmotićeva 28, Zagreb </a></div>

        <div class="ms-3 text-nowrap"><a class="topbar-link d-none d-md-inline-block" href="order-tracking.html"><i class="ci-time"></i>PON-PET: 9-20 | SUB: 9-14</a>
        </div>
    </div>
</div>

@include('front.layouts.partials.header')

@yield('content')

@include('front.layouts.partials.footer')

<!-- Toolbar for handheld devices (Marketplace)-->
<div class="handheld-toolbar">
    <div class="d-table table-layout-fixed w-100"><a class="d-table-cell handheld-toolbar-item" href="dashboard-favorites.html"><span class="handheld-toolbar-icon"><i class="ci-heart"></i></span><span class="handheld-toolbar-label">Lista želja</span></a><a class="d-table-cell handheld-toolbar-item" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" onclick="window.scrollTo(0, 0)"><span class="handheld-toolbar-icon"><i class="ci-menu"></i></span><span class="handheld-toolbar-label">Menu</span></a><a class="d-table-cell handheld-toolbar-item" href="marketplace-cart.html"><span class="handheld-toolbar-icon"><i class="ci-cart"></i><span class="badge bg-primary rounded-pill ms-1">1</span></span><span class="handheld-toolbar-label">80.00kn</span></a></div>
</div>
<!-- Back To Top Button-->
<a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up"></i></a>
<!-- Vendor scrits: js libraries and plugins-->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/simplebar.min.js') }}"></script>
<script src="{{ asset('js/tiny-slider.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.polyfills.min.js') }}"></script>
<!-- Main theme script-->
<script src="{{ asset('js/theme.min.js') }}"></script>
</body>
</html>