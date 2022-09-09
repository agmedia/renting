
@if (\Illuminate\Support\Facades\Route::is('index'))
    <header id="header" class="transparent-header-modern fixed-header-bg-white w-100 shadow">
        <div class="top-header bg-white py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex h-100 align-items-center justify-content-start">
                            <!-- <div class="me-3"><a href="callto:012345678102" class="text-primary"><i class="fas fa-phone-alt text-primary me-1"></i>(012) 345 678 102</a></div>-->
                            <div class="me-3"><a href="mailto:selfcheckins@gmail.com" class="text-primary"><i class="fas fa-envelope text-primary me-1"></i>selfcheckins@gmail.com</a></div>
                            <div class="dropdown hover-dropdown">
                                <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">Help and Support</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="faq.html">Freequenly Ask Question</a></li>
                                    <li><a class="dropdown-item" href="#">Terms & Condition</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex h-100 align-items-center justify-content-end">
                            <div class="currency me-2">
                                <form action="#" method="post">
                                    <div class="select-arrow text-primary">
                                        <select class="form-select">
                                            <option>€ EUR</option>
                                            <option>$ USD</option>
                                            <option>kn HRK</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="language">
                                <div class="dropdown hover-dropdown">
                                    <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">{{ \Illuminate\Support\Str::upper(current_locale()) }}</button>
                                    <ul class="dropdown-menu">
                                        @foreach (ag_lang() as $lang)
                                            <li>
                                                <a class="dropdown-item @if (current_locale() == $lang->code) active @endif" href="{{ LaravelLocalization::getLocalizedURL($lang->code, null, [], true) }}">{{ $lang->title->{LaravelLocalization::getCurrentLocale()} }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
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
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="index.html">Properties</a> </li>
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="faq.html">Freequenly Ask Question</a> </li>
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="#">Contact</a> </li>

                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="login.html">Login</a> </li>

                                </ul>
                                <a class="btn btn-primary d-none d-xl-block" href="login.html"><i class="fas fa-user text-white me-1"></i> Login / Register</a>
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
                                <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">Help and Support</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="faq.html">Freequenly Ask Question</a></li>

                                    <li><a class="dropdown-item" href="#">Terms & Condition</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex h-100 align-items-center justify-content-end">
                            <div class="currency me-2">
                                <form action="#" method="post">
                                    <div class="select-arrow text-primary">
                                        <select class="form-select">
                                            <option>€ EUR</option>
                                            <option>$ USD</option>
                                            <option>kn HRK</option>

                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="language">
                                <div class="dropdown hover-dropdown">
                                    <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">{{ \Illuminate\Support\Str::upper(current_locale()) }}</button>
                                    <ul class="dropdown-menu">
                                        @foreach (ag_lang() as $lang)
                                            <li>
                                                <a class="dropdown-item @if (current_locale() == $lang->code) active @endif" href="{{ LaravelLocalization::getLocalizedURL($lang->code, null, [], true) }}">{{ $lang->title->{LaravelLocalization::getCurrentLocale()} }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
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
                            <a class="navbar-brand" href="index.html"><img class="nav-logo" src="assets/images/logo.svg" alt=""></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto ms-auto mt-3">
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="index.html">Properties</a> </li>
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="faq.html">Freequenly Ask Question</a> </li>
                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="#">Contact</a> </li>

                                    <li class="nav-item d-block d-sm-none"> <a class="nav-link" href="login.html">Login</a> </li>

                                </ul>
                                <a class="btn btn-primary d-none d-xl-block" href="login.html"><i class="fas fa-user text-white me-1"></i> Login / Register</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endif