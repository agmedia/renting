@extends('front.layouts.app')

@section('content')
    <div class="full-row bg-white p-0">
        <div class="container-fluid">
            <div class="row">

                <!-- listings -->
                <div class="col-xl-6 ">
                    <div class="row property-search my-2 mt-0">
                        <div class="col-md-12">

                            <!---listings -->
                            <div class="row row-cols-md-2 row-cols-1 g-4">
                                <div class="col">
                                    <div class="featured-thumb hover-zoomer">
                                        <div class="overflow-hidden position-relative">
                                            <a href="property-single-1.html"> <img src="{{ asset($apartment->image) }}" alt="{{ $apartment->title }}"></a>
                                            <div class="featured bg-primary text-white">€ {{ number_format($apartment->price, 0, ',', '.') }} {{ config('settings.apartment_price_by')[$apartment->price_per]['title'][current_locale()] }}</div>
                                            <div class="starmark text-white"><i class="far fa-star"></i></div>
                                        </div>
                                        <div class="featured-thumb-data shadow-one">
                                            <div class="p-4 pb-2">
                                                <h5 class="text-secondary hover-text-primary mb-2"><a href="property-single-1.html">{{ $apartment->title }}</a></h5>
                                                <span class="location"><i class="fas fa-map-marker-alt text-primary"></i> {{ $apartment->address }}, {{ $apartment->city }}</span> </div>
                                            <div class="ps-4 pb-2">
                                                <span class="location"><i class="fas fa-star text-primary"></i> {{ $apartment->m2 }} m² - {{ $apartment->rooms }} rooms - {{ $apartment->beds }} beds</span>
                                            </div>

                                            <div class="px-4 pb-4 d-inline-block w-100">
                                                <div class="float-start"><i class="fas fa-user text-primary me-1"></i> Apartments Repinc</div>
                                                <div class="float-end"><i class="far fa-calendar-alt text-primary me-1"></i> 2 Months Ago</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js_after')

@endpush
