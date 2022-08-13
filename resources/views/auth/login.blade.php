@extends('back.layouts.simple')

@section('content')

    <div class="row no-gutters justify-content-center bg-body-dark bckimagelogin">

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="hero-static col-sm-10 col-md-8 col-xl-8 col-xxl-6 d-flex align-items-center p-2 px-sm-0">
            <!-- Sign In Block -->
            <div class="block block-rounded block-transparent block-fx-pop w-100 mb-0 overflow-hidden bg-image" style="background-image: url({{ asset('media/img/login-bck.jpg') }});">
                <div class="row no-gutters">
                    <div class="col-md-6 order-md-1 bg-white">
                        <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                            <!-- Header -->
                            <div class="mb-2 text-center">
                                <a class="link-fx font-w700 font-size-h2" href="{{ route('index') }}">
                                    <span class="text-dark">Self</span><span class="text-primary">Checkins</span>
                                </a>
                                <p class="text-uppercase font-w700 font-size-sm text-muted">{{ __('auth.prijava') }}</p>
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alt" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('auth.email') }}">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-alt" id="password" name="password" placeholder="{{ __('auth.pass') }}">
                                </div>
                                <div class="form-group">
                                    <label for="remember_me" class="flex items-center">
                                        <x-jet-checkbox id="remember_me" name="remember" />
                                        <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-hero-primary">
                                        <i class="fa fa-fw fa-sign-in-alt mr-1"></i> {{ __('auth.login_btn') }}
                                    </button>
                                </div>
                            </form>
                            <div class="mb-2 text-center">
                                @if (Route::has('password.request'))
                                    <a class="link-fx font-size-sm" href="{{ route('password.request') }}">
                                        {{ __('auth.forgot') }}
                                    </a>
                                @endif
                            </div>
                            <div class="mb-2 text-center">
                                <a class="link-fx font-size-sm" href="{{ route('register') }}">
                                    {{ __('auth.register') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 order-md-0 bg-primary-dark-op d-flex align-items-center">
                        <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                            <div class="media">
                                <a class="img-link mr-3" href="{{ route('index') }}">
                                    <img class="img-avatar img-avatar-thumb" src="{{ asset('media/img/logo_self.png') }}" alt="SelfCheckIns Apartments">
                                </a>
                                <div class="media-body">
                                    <h2 class="mt-3"><a class="text-white font-w600" href="{{ route('index') }}">SelfCheckIns</a></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Sign In Block -->
        </div>
    </div>

@endsection
