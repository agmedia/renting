
@if (\Illuminate\Support\Facades\Route::is('index'))
    <header id="header" class="transparent-header-modern fixed-header-bg-white w-100 shadow">
        <div class="top-header bg-white py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex h-100 align-items-center justify-content-start">
                            <div class="me-3"><a href="mailto:selfcheckins@gmail.com" class="text-primary"><i class="fas fa-envelope text-primary me-1"></i>selfcheckins@gmail.com</a></div>
                            <div class="dropdown hover-dropdown">
                                <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">{{ __('front/common.help_and_support') }}</button>
                                <ul class="dropdown-menu">

                                    @foreach($pages as $page)
                                        <li><a class="dropdown-item" href="{{ route('page', ['page' => $page->translation(current_locale())->slug]) }}">{{ $page->translation(current_locale())->title }}</a></li>
                                    @endforeach
                                    <li> <a class="dropdown-item" href="{{ route('faq') }}">{{ __('front/common.faq') }}</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex h-100 align-items-center justify-content-end">
                            @include('front.layouts.partials.currency-selector')
                            @include('front.layouts.partials.language-selector')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-nav bg-gray">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <nav class="navbar navbar-expand-lg navbar-light secondary-nav hover-primary-nav">
                            <a class="navbar-brand" href="{{ route('index') }}"><img class="nav-logo" src="{{ asset('assets/images/logo.svg') }}" alt=""></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto ms-auto mt-3">

                                    @foreach($pages as $page)
                                        <li class="nav-item d-block d-sm-none"><a class="nav-link" href="{{ route('page', ['page' => $page->translation(current_locale())->slug]) }}">{{ $page->translation(current_locale())->title }}</a></li>
                                    @endforeach
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="{{ route('faq') }}">{{ __('front/common.faq') }}</a> </li>
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="{{ route('kontakt') }}">{{ __('front/common.contact') }}</a> </li>
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="{{ route('login') }}">{{ __('front/common.login') }}</a> </li>
                                </ul>
                                <a class="btn btn-primary d-none d-xl-block" href="{{ route('login') }}"><i class="fas fa-user text-white me-1"></i> {{ __('front/common.login_register') }}</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
@else
    <header id="header" class="fixed-header-bg-white">
        <div class="top-header bg-white py-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex h-100 align-items-center justify-content-start">
                            <!-- <div class="me-3"><a href="callto:012345678102" class="text-primary"><i class="fas fa-phone-alt text-primary me-1"></i>(012) 345 678 102</a></div>-->
                            <div class="me-3"><a href="mailto:selfcheckins@gmail.com" class="text-primary"><i class="fas fa-envelope text-primary me-1"></i>selfcheckins@gmail.com</a></div>
                            <div class="dropdown hover-dropdown">
                                <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">{{ __('front/common.help_and_support') }}</button>
                                <ul class="dropdown-menu">

                                    @foreach($pages as $page)
                                        <li><a class="dropdown-item" href="{{ route('page', ['page' => $page->translation(current_locale())->slug]) }}">{{ $page->translation(current_locale())->title }}</a></li>
                                    @endforeach
                                    <li> <a class="dropdown-item" href="{{ route('faq') }}">{{ __('front/common.faq') }}</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex h-100 align-items-center justify-content-end">
                            @include('front.layouts.partials.currency-selector')
                            @include('front.layouts.partials.language-selector')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-nav bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <nav class="navbar navbar-expand-lg navbar-light secondary-nav hover-primary-nav">
                            <a class="navbar-brand" href="{{ route('index') }}"><img class="nav-logo" src="{{ asset('assets/images/logo.svg') }}" alt=""></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto ms-auto mt-3">

                                    @foreach($pages as $page)
                                        <li class="nav-item d-block d-sm-none"><a class="nav-link" href="{{ route('page', ['page' => $page->translation(current_locale())->slug]) }}">{{ $page->translation(current_locale())->title }}</a></li>
                                    @endforeach
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="{{ route('faq') }}">{{ __('front/common.faq') }}</a> </li>
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="{{ route('kontakt') }}">{{ __('front/common.contact') }}</a> </li>
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="{{ route('login') }}">{{ __('front/common.login') }}</a> </li>
                                </ul>
                                <a class="btn btn-primary d-none d-xl-block" href="{{ route('login') }}"><i class="fas fa-user text-white me-1"></i> {{ __('front/common.login_register') }}</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endif
