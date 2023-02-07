@extends('front.layouts.app')

@section('content')

    <div class=" bg-white pt-4 pb-3" >
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>{{ __('front/common.home') }}</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('front/common.contact') }} </li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-dark"> {{ __('front/common.contact') }}</h1>
            </div>
        </div>
    </div>
    <!-- Contact detail cards-->
    <section class="container pt-grid-gutter">
        <div class="row">
            @include('front.layouts.partials.success-session')
        </div>
    </section>

    <!-- Split section: Map + Contact form-->
    <div class="container px-0">
        <div class="row g-0 pb-5">
            <div class="col-lg-4 px-4 pe-xl-5 py-3">

                <div class="contact-info">
                    <h2 class="h4 mb-4">{{ __('front/common.contact') }}</h2>
                    <ul>
                        <li class="d-flex mb-4"> <i class="fas fa-map-marker-alt text-primary me-2 font-13 mt-2"></i>
                            <div class="contact-address">
                                <h5 class="text-secondary">{{ __('front/common.address') }}</h5>
                                <span>{{ $owner->title }}<br>{{ $owner->address }}<br>{{ $owner->city }}, {{ $owner->state }}, {{ $owner->zip }}</span> </div>
                        </li>
                        <li class="d-flex mb-4"> <i class="fas fa-phone-alt text-primary me-2 font-13 mt-2"></i>
                            <div class="contact-address">
                                <h5 class="text-secondary">{{ __('front/common.call') }}</h5>
                                <span class="d-table">{{ $owner->phone }}</span> </div>
                        </li>
                        <li class="d-flex mb-4"> <i class="fas fa-envelope text-primary me-2 font-13 mt-2"></i>
                            <div class="contact-address">
                                <h5 class="text-secondary">{{ __('front/common.email') }}</h5>
                                <span>{{ $owner->email }}</span> </div>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-lg-8 px-4 px-xl-5 py-3">
                <h2 class="h4 mb-4">{{ __('front/common.enquiry_form') }}</h2>
                <form action="{{ route('poruka') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label" for="cf-name">{{ __('front/common.name') }}:&nbsp;@include('back.layouts.partials.required-star')</label>
                            <input class="form-control bg-gray" type="text" name="name" id="cf-name" placeholder="">
                            @error('name')<div class="text-danger font-size-sm">{{ __('front/common.name_validate') }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="cf-email">{{ __('front/common.email') }}:&nbsp;@include('back.layouts.partials.required-star')</label>
                            <input class="form-control bg-gray" type="email" id="cf-email" placeholder="" name="email">
                            @error('email')<div class="invalid-feedback">{{ __('front/common.email_validate') }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="cf-phone">{{ __('front/common.mobile') }}:&nbsp;@include('back.layouts.partials.required-star')</label>
                            <input class="form-control bg-gray" type="text" id="cf-phone" placeholder="" name="phone">
                            @error('phone')<div class="invalid-feedback">{{ __('front/common.mobile_validate') }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="cf-message">{{ __('front/common.message') }}:&nbsp;@include('back.layouts.partials.required-star')</label>
                            <textarea class="form-control bg-gray" id="cf-message" rows="6" placeholder="" name="message"></textarea>
                            @error('message')<div class="invalid-feedback">{{ __('front/common.message_validate') }}</div>@enderror
                            <button class="btn btn-primary mt-4" type="submit">{{ __('front/common.submit') }}</button>
                        </div>
                    </div>
                    <input type="hidden" name="recaptcha" id="recaptcha">
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js_after')
    @include('front.layouts.partials.recaptcha-js')
@endpush
