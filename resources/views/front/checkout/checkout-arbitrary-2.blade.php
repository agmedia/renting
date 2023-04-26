@extends('front.layouts.app')

@push('css_after')
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
@endpush

@section('content')

    <div class="page-banner full-row bg-white py-5">
        <div class="container">
            <div class="row row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <h3 class="page-name text-secondary m-0"> <a href="{{ route('index') }}"><i class="fas fa-angle-left me-5"></i></a>{{ __('front/checkout.special') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row bg-white pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 order-lg-1 mt-0">
                    <h5 class="mt-2 mb-0 text-primary">{{ __('front/checkout.arbitrary.title2') }}</h5>

                    <div class="row mt-3 row-cols-xl-4 row-cols-md-4 row-cols-1 g-4">
                        @foreach ($orders as $order)
                            <div class="col" >
                                <div class="featured-thumb hover-zoomer">
                                    <div class="overflow-hidden position-relative">
                                        <a href="{{ route('checkout.arbitrary.info', ['order' => $order->id]) }}"> <img id="apartment-image-{{ $order->apartment->id }}" src="{{ $order->apartment->thumb }}" alt="{{ $order->apartment->title }}"></a>
{{--                                        <div class="featured bg-primary text-white">{{ currency_main($order->apartment->price_regular, true) }} / {{ config('settings.apartment_price_by')[$order->apartment->price_per]['title'][current_locale()] }}</div>--}}

                                        @if ($order->apartment->featured)
                                            <div class="starmark text-white"><i class="far fa-star"></i></div>
                                        @endif
                                    </div>
                                    <div class="featured-thumb-data shadow-one">
                                        <div class="p-4 pb-2">
                                            <h5 class="text-secondary hover-text-primary mb-2"><a href="{{ route('checkout.arbitrary.info', ['order' => $order->id]) }}">{{ $order->apartment->title }}</a></h5>
                                        </div>
                                        <div class="ps-4 pb-2">
                                            <span class="location"><i class="fas fa-star text-primary"></i> {{ $order->apartment->m2 }}m² <i class="fas fa-door-open text-primary"></i> {{ $order->apartment->rooms }} {{ __('front/apartment.rooms') }}   <i class="fas fa-users text-primary me-1"></i> {{ $order->apartment->max_persons }}  {{ __('front/apartment.guests') }}</span>
                                        </div>

                                        <div class="px-4 pb-4 d-inline-block w-100">
                                            <div class="float-start">
                                                @if (collect(json_decode($order->apartment->featured_amenities))->count())
                                                    @foreach (collect(json_decode($order->apartment->featured_amenities))->all() as $item)
                                                        <span class="location list">
                                                                    <img src="{{ asset('media/icons') }}/{{ $item->icon }}" class="offer-icon list" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->title->{current_locale()} }}" style="margin-right: 5px;" />
                                                                </span>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="float-end"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js_after')

@endpush
