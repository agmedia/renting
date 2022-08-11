@extends('front.layouts.app')
@if (request()->routeIs(['index']))
    @section ( 'title', 'Rent' )
@section ( 'description', 'Dobrodošli na stranice Rent, Palmotićeva 28, Zagreb. Radno vrijeme pon-pet 09-20h, sub 09-14h.' )


@push('meta_tags')

    <link rel="canonical" href="{{ env('APP_URL')}}" />
    <meta property="og:locale" content="hr_HR" />
    <meta property="og:type" content="product" />
    <meta property="og:title" content="Antikvarijat Biblos - Knjige, vedute i zemljovidi" />
    <meta property="og:description" content="Dobrodošli na stranice Antikvarijata Biblos, Palmotićeva 28, Zagreb. Radno vrijeme pon-pet 09-20h, sub 09-14h." />
    <meta property="og:url" content="{{ env('APP_URL')}}"  />
    <meta property="og:site_name" content="Antikvarijat Biblos" />
    <meta property="og:image" content="https://images.antikvarijatbibl.lin73.host25.com/media/antikvarijat-biblos.jpg" />
    <meta property="og:image:secure_url" content="https://images.antikvarijatbibl.lin73.host25.com/media/antikvarijat-biblos.jpg" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="720" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:alt" content="Antikvarijat Biblos - Knjige, vedute i zemljovidi" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Antikvarijat Biblos - Knjige, vedute i zemljovidi" />
    <meta name="twitter:description" content="Antikvarijat Biblos - Knjige, vedute i zemljovidi" />
    <meta name="twitter:image" content="https://images.antikvarijatbibl.lin73.host25.com/media/antikvarijat-biblos.jpg" />

@endpush

@else
    @section ( 'title', $page->title. ' - Antikvarijat Biblos' )
@section ( 'description', $page->meta_description )
@endif

@section('content')

    @if (request()->routeIs(['index']))

        <!-- Hero section -->
        <section class="bg-accent bg-position-top-left bg-repeat-0 py-5" style="background-image: url({{ config('settings.images_domain') . 'media/img/lightslider.webp' }});-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
            <div class="pb-lg-5 mb-lg-3">
                <div class="container py-lg-4 my-lg-5">
                    <div class="row mb-2 mb-sm-3">
                        <div class="col-lg-7 col-md-9  text-start">
                            <h1 class="text-white lh-base">{{ \Illuminate\Support\Facades\App::getLocale() }}</h1>

                        </div>
                    </div>

                    <div class="widget mt-4 text-md-nowrap  pb-lg-5 mb-4 mb-sm-3 text-start">
                        <ul>
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{--{!! $page->description !!}--}}

        <section class="container-fluid pt-grid-gutter bg-third">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </section>

    @else

        <div class=" bg-dark pt-4 pb-3" style="background-image: url({{ config('settings.images_domain') . 'media/img/indexslika.jpg' }});-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                            <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $page->title }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                    <h1 class="text-light">{{ $page->title }}</h1>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="mt-5 mb-5">
                {!! $page->description !!}
            </div>
        </div>

    @endif

@endsection
