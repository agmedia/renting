@extends('front.layouts.app')



@section ( 'title', $page->title. ' - SelfCheckIns' )
@section ( 'description', $page->meta_description )

@push('meta_tags')

    <link rel="canonical" href="{{ env('APP_URL')}}" />
    <meta property="og:locale" content="hr_HR" />
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ $page->title }} - SelfCheckIns" />
    <meta property="og:description" content="{{ $page->meta_description }}" />
    <meta property="og:url" content="{{ env('APP_URL')}}"  />
    <meta property="og:site_name" content="SelfCheckIns" />
    <meta property="og:image" content="https://images.antikvarijatbibl.lin73.host25.com/media/antikvarijat-biblos.jpg" />
    <meta property="og:image:secure_url" content="https://images.antikvarijatbibl.lin73.host25.com/media/antikvarijat-biblos.jpg" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="720" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:alt" content="{{ $page->title }} - SelfCheckIns" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $page->title }} - SelfCheckIns" />
    <meta name="twitter:description" content="{{ $page->meta_description }}" />
    <meta name="twitter:image" content="https://images.antikvarijatbibl.lin73.host25.com/media/antikvarijat-biblos.jpg" />

@endpush





@section('content')



        <div class=" bg-white pt-4 pb-3" >
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                            <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>{{ __('front/common.home') }}</a></li>
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $page->title }} </li>
                        </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                    <h1 class="h3 text-dark"> {{ $page->title }}</h1>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="mt-3 mb-5 text-dark titleformat">
                {!! $page->description !!}
            </div>
        </div>



@endsection
