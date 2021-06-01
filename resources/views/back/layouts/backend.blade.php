<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Antikvarijat Biblos</title>

        <meta name="description" content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('media/img/faviconbiblos.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/img/faviconbiblos.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/img/faviconbiblos.png') }}">

        <!-- Fonts and Styles -->
        @stack('css_before')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" id="css-main" href="{{ mix('css/dashmix.css') }}">

        <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="{{ mix('css/themes/xwork.css') }}"> -->
        @stack('css_after')

        <!-- Scripts -->
        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
    </head>
    <body>

        <div id="page-container" class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">

            @include('back.layouts.partials.aside')

            @include('back.layouts.partials.sidebar')

            @include('back.layouts.partials.topbar')

            <!-- Main Container -->
            <main id="main-container">
                @yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-body-light">
                <div class="content py-0">
                    <div class="row font-size-sm">
                        <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-right">
                            Crafted with <i class="fa fa-heart text-danger"></i> by <a class="font-w600" href="https://www.agmedia.hr" target="_blank">AG media</a>
                        </div>
                        <div class="col-sm-6 order-sm-1 text-center text-sm-left">
                            <a class="font-w600" href="https://www.antikvarijat-biblos.hr" target="_blank">Antikvarijat Biblos</a> &copy; <span data-toggle="year-copy"></span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <!-- Dashmix Core JS -->
        <script src="{{ asset('js/dashmix.app.js') }}"></script>

        <!-- Laravel Scaffolding JS -->
        <script src="{{ asset('/js/laravel.app.js') }}"></script>

        @stack('js_after')
    </body>
</html>
