@extends('front.layouts.app')

@push('css_after')

@endpush

@section('content')

    <div class="page-banner full-row bg-white py-5">
        <div class="container">
            <div class="row row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <h3 class="page-name text-secondary m-0"> <a href="javascript:history.back()"><i class="fas fa-angle-left me-5"></i></a>Checkout Preview</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row bg-white pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-1 order-lg-2 content">
                    <div class="sidebar">
                        <div class="mt-lg-4 p-4 mb-4 shadow-one reservationbox ">
                            <div class="img-80 float-start me-3 mb-4 rounded-circle"><img src="assets/images/apartmani/4.jpeg" alt=""></div>
                            <h5 class="mt-2 mb-0 text-primary">{{ $checkout->apartment->title }}</h5>
                            <p class="mb-0">{{ __('front/checkout.entire_rental_unit') }}</p>
                            <div class="clearfix"></div>
                            <div class="row row-cols-1 ">
                                <div class="col mt-0">
                                    <h4 class="mt-0 mb-2 text-primary">{{ __('front/checkout.price_details') }}</h4>
                                    <ul class="list-group mb-3">
                                        @foreach ($checkout->total['items'] as  $item)
                                            <li class="list-group-item d-flex justify-content-between py-3 lh-sm">
                                                <div>
                                                    <h6 class="my-0">{{  $item['price_text'] }} x {{ $item['count'] }} {{ $item['title'] }} </h6>
                                                </div>
                                                <span class="text-muted">{{ $item['total_text'] }}</span>
                                            </li>
                                        @endforeach
                                        @foreach ($checkout->total['total'] as  $item)
                                            <li class="list-group-item d-flex justify-content-between bg-light">
                                                <h5 class="my-0">{!! $item['title'] !!}</h5>
                                                <strong>{{ $item['total_text'] }}</strong>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 order-lg-1 mt-0">
                    <h5 class="mt-2 mb-0 text-primary">{{ $checkout->apartment->title }}</h5>

                    <div class="row">
                        <div class="col-sm-12 mt-5">
                            {!! $form !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js_after')

@endpush
