@extends('front.layouts.app')

@section ( 'title', 'FAQ - SelfCheckIns' )

@push('meta_tags')
    <link rel="canonical" href="{{ env('APP_URL')}}"/>
    <meta property="og:locale" content="{{ current_locale(true) }}"/>
    <meta property="og:type" content="page"/>
    <meta property="og:title" content="{{ __('front/common.faq') }} - SelfCheckIns"/>
    <meta property="og:description" content="{{ __('front/common.faq') }}"/>
    <meta property="og:url" content="{{ env('APP_URL')}}"/>
    <meta property="og:site_name" content="SelfCheckIns"/>
    <meta property="og:image" content="{{ asset(config('settings.default_apartment_image')) }}"/>
    <meta property="og:image:secure_url" content="{{ asset(config('settings.default_apartment_image')) }}"/>
    <meta property="og:image:width" content="1920"/>
    <meta property="og:image:height" content="720"/>
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:image:alt" content="{{ __('front/common.faq') }} - SelfCheckIns"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{ __('front/common.faq') }} - SelfCheckIns"/>
    <meta name="twitter:description" content="{{ __('front/common.faq') }}"/>
    <meta name="twitter:image" content="{{ asset(config('settings.default_apartment_image')) }}"/>
@endpush


@section('content')

    <div class=" bg-white pt-4 pb-3">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>{{ __('front/common.home') }}</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('front/common.faq') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-dark">{{ __('front/common.faq') }}</h1>
            </div>
        </div>
    </div>
    <div class="full-row bg-white pt-3 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="navigation_link_widget mb-5 bg-gray p-4">
                        <h5 class="double-down-line-left text-secondary position-relative pb-4 mb-4">{{ __('front/common.additional_info') }}</h5>
                        <ul>
                            @foreach($pages as $page)
                                <li>
                                    <a href="{{ route('page', ['page' => $page->translation(current_locale())->slug]) }}">{{ $page->translation(current_locale())->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="info-pages bg-gray px-4 py-5 ">
                        @foreach ($faqs as $fa)
                            <div class="faq-item mb-4"><span class="faq-question bg-primary text-white">Q</span>
                                <div class="d-table">
                                    <h5 class="mb-2 text-secondary">{{ $fa->title }}</h5>
                                    {!! $fa->description !!}
                                    <hr>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
