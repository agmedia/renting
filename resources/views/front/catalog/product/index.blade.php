@extends('front.layouts.app')

@section('content')

    <!-- Page Title-->
    <div class="page-title-overlap bg-dark pt-4" style="background-image: url({{ asset('media/img/indexslika.jpg') }});-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>

                        @if ($group)
                            @if ($group && ! $cat && ! $subcat)
                                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ \Illuminate\Support\Str::ucfirst($group) }}</li>
                            @elseif ($group && $cat)
                                <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route', ['group' => $group]) }}">{{ \Illuminate\Support\Str::ucfirst($group) }}</a></li>
                            @endif

                            @if ($cat && ! $subcat)
                                @if ($prod)
                                    <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route', ['group' => $group, 'cat' => $cat]) }}">{{ $cat->title }}</a></li>
                                @else
                                    <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $cat->title }}</li>
                                @endif
                            @elseif ($cat && $subcat)
                                <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route', ['group' => $group, 'cat' => $cat]) }}">{{ $cat->title }}</a></li>
                                @if ($prod)
                                    @if ($cat && ! $subcat)
                                        <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route', ['group' => $group, 'cat' => $cat]) }}">{{ $prod->name }}</a></li>
                                    @else
                                        <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route', ['group' => $group, 'cat' => $cat, 'subcat' => $subcat]) }}">{{ $subcat->title }}</a></li>
                                    @endif
                                @endif
                            @endif
                        @endif

                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $prod->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-light mb-0"><span style="font-weight: lighter;">{{ $prod->author->title }}:</span> {{ $prod->name }}</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Gallery + details-->
        <div class="bg-light shadow-lg rounded-3 px-4 py-3 mb-5">
            <div class="px-lg-3">
                <div class="row">
                    <!-- Product gallery-->
                    <div class="col-lg-7 pe-lg-0 pt-lg-4">
                        <div class="product-gallery">
                            <div class="product-gallery-preview order-sm-2">
                                @if ( ! empty($prod->image))
                                    <div class="product-gallery-preview-item active" id="first"><img  src="{{ asset($prod->image) }}"  alt="{{ $prod->name }}"></div>
                                @endif

                                @if ($prod->images->count())
                                    @foreach ($prod->images as $key => $image)
                                        <div class="product-gallery-preview-item" id="key{{ $key + 1 }}"><img  src="{{ asset($image->image) }}" alt="{{ $image->alt }}"></div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="product-gallery-thumblist order-sm-1">
                                @if ( ! empty($prod->image))
                                    <a class="product-gallery-thumblist-item active" href="#first"><img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}"></a>
                                @endif

                                @if ($prod->images->count())
                                    @foreach ($prod->images as $key => $image)
                                        <a class="product-gallery-thumblist-item" href="#key{{ $key + 1 }}"><img src="{{ asset($image->image) }}" alt="{{ $image->alt }}"></a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Product details-->
                    <div class="col-lg-5 pt-4 pt-lg-0">
                        <div class="product-details ms-auto pb-3">

                            <div class="mb-3 mt-4">
                                @if ($prod->special())
                                    <span class="h3 fw-normal text-accent me-1">{!! $prod->priceString($prod->special()) !!}</span>
                                    <del class="text-muted fs-lg me-3">{!! $prod->priceString() !!}</del>
                                    <span class="badge bg-danger align-middle mt-n2">Akcija</span>
                                @else
                                    <span class="h3 fw-normal text-accent me-1">{!! $prod->priceString() !!}</span>
                                @endif

                                @if ($prod->quantity)
                                    <span class="badge bg-success align-middle mt-n2">Dostupno</span>
                                @else
                                    <span class="badge bg-fourth align-middle mt-n2">Nedostupno</span>
                                @endif
                            </div>

                            <add-to-cart-btn id="{{ $prod->id }}"></add-to-cart-btn>

                            <!-- Product panels-->
                            <ul class="list-unstyled fs-sm spec">
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Autor</span><span class="text-muted"><a class="product-meta text-primary" href="{{ route('catalog.route.author', ['author' => $prod->author]) }}">{{ $prod->author->title }}</a></span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Izdavač</span><a class="product-meta text-primary" href="{{ route('catalog.route.publisher', ['publisher' => $prod->publisher]) }}">{{ $prod->publisher->title }}</a></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Šifra</span><span class="text-muted">{{ $prod->sku }}</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Broj stranica</span><span class="text-muted">{{ $prod->pages ?: '0' }}</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Dimenzije</span><span class="text-muted">{{ $prod->dimensions ?: '...' }}</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Mjesto izdavanja</span><span class="text-muted">{{ $prod->origin ?: '...' }}</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Pismo</span><span class="text-muted">{{ $prod->letter ?: '...' }}</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Stanje</span><span class="text-muted">{{ $prod->condition ?: '...' }}</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Uvez</span><span class="text-muted">{{ $prod->binding ?: '...' }}</span></li>
                            </ul>

                            <div class=" pt-2 pb-4 mb-1">
                                <div class="mt-3"><span class="d-inline-block align-middle text-muted fs-sm me-3 mt-1 mb-2">Podijeli:</span>
                                    <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center py-md-3">
            <div class="col-lg-8 col-md-12 offset-lg-2 py-4 text-center">
                <h2 class="h3 mb-2 pb-0">{{ $prod->name }}</h2>
                <h3 class="h6 mb-4">{{ $prod->author->title }}</h3>
                <p class="fs-md pb-2">{!! $prod->description !!}</p>
                <div class="mt-3 me-3"><a class="btn-tag me-2 mb-2" href="{{ route('catalog.route.author', ['author' => $prod->author]) }}">#{{ $prod->author->title }}</a></div>
            </div>
        </div>
    </div>

    <!-- Product carousel (You may also like)-->
    <div class="container py-5 my-md-3">
        <h2 class="h3 text-center pb-4">Preporučamo</h2>
        <div class="tns-carousel tns-controls-static tns-controls-outside">
            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;controls&quot;: false, &quot;nav&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 18},&quot;768&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 30}}}">
                @foreach ($cat->products()->get()->take(5) as $cat_product)
                    @if ($cat_product->id  != $prod->id)
                        <div>
                            @include('front.catalog.category.product', ['product' => $cat_product])
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>


@endsection

@push('js_after')

    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=6134a372eae16400120a5035&product=sop' async='async'></script>

@endpush
