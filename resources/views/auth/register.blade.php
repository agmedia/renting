
@extends('back.layouts.simple')

@section('content')

    <div class="row no-gutters justify-content-center bg-body-dark bckimagelogin">
        <div class="hero-static col-sm-10 col-md-8 col-xl-8 col-xxl-6 d-flex align-items-center p-2 px-sm-0" style="max-width:900px">
            <!-- Sign Up Block -->
            <div class="block block-rounded block-transparent block-fx-pop w-100 mb-0 overflow-hidden bg-image" style="background-image: url({{ asset('media/img/login-bck.jpg') }});">
                <div class="row no-gutters">
                    <div class="col-md-6 order-md-1 bg-white">
                        <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                            <!-- Header -->
                            <div class="mb-2 text-center">
                                <a class="link-fx text-success font-w700 font-size-h1" href="{{ route('index') }}">
                                    <span class="text-dark">Self</span><span class="text-primary">Checkins</span>
                                </a>
                                <p class="text-uppercase font-w700 font-size-sm text-muted">{{ __('auth.create_user_account') }}</p>
                            </div>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
{{--                                <div class="form-group">--}}
{{--                                    <input type="text" class="form-control form-control-alt" id="name" name="name" placeholder="{{ __('auth.username') }}" value="{{ old('name') }}">--}}
{{--                                </div>--}}
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-alt" id="email" name="email" placeholder="{{ __('auth.email') }}" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="ml-2 font-size-sm text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-alt" id="password" name="password" placeholder="{{ __('auth.pass') }}">
                                    @if ($errors->has('password'))
                                        <span class="ml-2 font-size-sm text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-alt" id="password-confirmation" name="password_confirmation" placeholder="{{ __('auth.passconfirm') }}">
                                    @if ($errors->has('password'))
                                        <span class="ml-2 font-size-sm text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="form-group">
                                        <x-jet-label for="terms">
                                            <div class="flex items-center">
                                                <x-jet-checkbox name="terms" id="terms"/>
                                                <label>
                                                    {!! __('front/checkout.agree') !!}
                                                </label>
                                            </div>
                                        </x-jet-label>
                                        @if ($errors->has('terms'))
                                            <span class="font-size-sm text-danger">{{ $errors->first('terms') }}</span>
                                        @endif
                                    </div>
                                @endif
                                {{--<div class="form-group">
                                    <a href="#" data-toggle="modal" data-target="#modal-terms">Terms &amp; Conditions</a>
                                    <div class="custom-control custom-checkbox custom-control-primary">
                                        <input type="checkbox" class="custom-control-input" id="signup-terms" name="signup-terms">
                                        <label class="custom-control-label" for="signup-terms">I agree</label>
                                    </div>
                                </div>--}}
                                <div class="form-group">
                                    <button type="submit" class="btn  btn-block btn-hero-primary">
                                        <i class="fa fa-fw fa-plus mr-1"></i> {{ __('auth.create_account') }}
                                    </button>
                                </div>
                                <input type="hidden" name="recaptcha" id="recaptcha">
                            </form>
                            <!-- END Sign Up Form -->
                            <div class="mb-2 text-center">
                                <a class="link-fx font-size-sm" href="{{ route('login') }}">
                                    {{ __('auth.sign_in') }}
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
            <!-- END Sign Up Block -->
        </div>
    </div>

@endsection

@push('js_after')
    @if (config('app.env') == 'production')
        @include('front.layouts.partials.recaptcha-js')
    @endif
@endpush
