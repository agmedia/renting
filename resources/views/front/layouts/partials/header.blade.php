
@if (\Illuminate\Support\Facades\Route::is('index'))
   <header  class="transparent-header-modern bg-white w-100 shadow">
        <div class="top-header bg-white py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-11 col-sm-10">
                        <div class="d-flex h-100 align-items-center justify-content-start">
                            <div class="me-2"><a href="mailto:selfcheckins@gmail.com" class="text-primary"><i class="fas fa-envelope text-primary me-1"></i>selfcheckins@gmail.com</a></div>
                            <div class="me-0"><a href="tel:+385 99 500 8000" class="text-primary"><i class="fas fa-phone-alt text-primary me-1"></i>+385 99 500 8000</a></div>
                            <div class="dropdown hover-dropdown d-none d-sm-block">
                                <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">{{ __('front/common.help_and_support') }}</button>
                                <ul class="dropdown-menu">
                                    @foreach($pages as $page)
                                        <li><a class="dropdown-item" href="{{ route('page', ['page' => $page->translation(current_locale())->slug]) }}">{{ $page->translation(current_locale())->title }}</a></li>
                                    @endforeach
                                    <li> <a class="dropdown-item" href="{{ route('faq') }}">{{ __('front/common.faq') }}</a> </li>
                                        <li > <a class="dropdown-item" href="{{ route('kontakt') }}">{{ __('front/common.contact') }}</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-1 col-sm-2">
                        <div class="d-flex h-100 align-items-center justify-content-end">
                            @if ( ! request()->routeIs('checkout.*'))
                                @include('front.layouts.partials.language-selector')
                            @endif
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
    <header  class="fixed-header-bg-white">
        <div class="top-header bg-white py-2">
            <div class="container">
                <div class="row">
                    <div class="col-11 col-sm-10">
                        <div class="d-flex h-100 align-items-center justify-content-start">
                            <div class="me-2"><a href="mailto:selfcheckins@gmail.com" class="text-primary"><i class="fas fa-envelope text-primary me-1"></i>selfcheckins@gmail.com</a></div>

                            <div class="me-0"><a href="tel:+385 99 500 8000" class="text-primary"><i class="fas fa-phone-alt text-primary me-1"></i>+385 99 500 8000</a></div>
                            <div class="dropdown hover-dropdown d-none d-md-block">
                                <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">{{ __('front/common.help_and_support') }}</button>
                                <ul class="dropdown-menu">
                                    @foreach($pages as $page)
                                        <li><a class="dropdown-item" href="{{ route('page', ['page' => $page->translation(current_locale())->slug]) }}">{{ $page->translation(current_locale())->title }}</a></li>
                                    @endforeach
                                    <li> <a class="dropdown-item" href="{{ route('faq') }}">{{ __('front/common.faq') }}</a> </li>
                                    <li > <a class="dropdown-item" href="{{ route('kontakt') }}">{{ __('front/common.contact') }}</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-1 col-sm-2">
                        <div class="d-flex h-100 align-items-center justify-content-end">
                            @if ( ! request()->routeIs('checkout.*'))
                                @include('front.layouts.partials.language-selector')
                            @endif
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
