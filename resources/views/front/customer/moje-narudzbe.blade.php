@extends('front.layouts.app')

@section('content')

    <!-- Order Details Modal-->
    @foreach ($orders as $order)
        <div class="modal fade" id="order-details{{ $order->id }}">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">{{ __('front/common.order_number') }} - {{ $order->id }}</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <div class="mt-lg-2 p-4 mb-2 reservationbox">
                            <div class="img-80 float-start me-3 mb-4 rounded-circle"><img src="{{ $order->apartment->thumb }}" alt="{{ $order->apartment->title }}" title="{{ $order->apartment->title }}"></div>
                            <h5 class="mt-2 mb-0 text-primary"><a href="{{ route('apartment', ['apartment' => $order->apartment->translation->slug]) }}">{{ $order->apartment->title }}</a></h5>
                            <p class="mb-0">{{ __('front/checkout.entire_rental_unit') }}</p>
                            <div class="clearfix"></div>
                            <div class="row row-cols-1 ">
                                <div class="col mt-0">
                                    <h4 class="mt-0 mb-2 text-primary">{{ __('front/checkout.price_details') }}</h4>
                                    <ul class="list-group mb-3">
                                        @foreach ($order->reservation['total']['items'] as $item)
                                            <li class="list-group-item d-flex justify-content-between py-3 lh-sm">
                                                <div>
                                                    <h6 class="my-0">{{ $item['price_text'] }} x {{ $item['count'] }} {!! $item['title'] !!} </h6>
                                                </div>
                                                <span class="text-muted">{{ $item['total_text'] }}</span>
                                            </li>
                                        @endforeach
                                        @foreach ($order->reservation['total']['total'] as $item)
                                            <li class="list-group-item d-flex justify-content-end bg-light">
                                                <h5 class="my-0 mx-5">{!! $item['title'] !!}</h5>
                                                <strong>{{ $item['total_text'] }}</strong>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('front.customer.layouts.header')

    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
        @include('front.customer.layouts.sidebar')

            <!-- Content  -->
            <section class="col-lg-8">
                @include('front.customer.layouts.title', ['title' => __('front/common.order_history')])

                <!-- Orders list-->
                <div class="table-responsive fs-md mb-4">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>{{ __('front/common.order_number') }}</th>
                            <th>{{ __('front/checkout.dates') }}</th>
                            <th>Status</th>
                            <th>{{ __('front/checkout.total') }}</th>
                            <th>{{ __('front/common.order_action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details{{ $order->id }}" data-bs-toggle="modal">{{ $order->id }}</a></td>
                                <td class="py-3">{{ $order->reservation['request']['dates'] }}</td>
                                <td class="py-3"><span class="badge bg-info m-0">{{ $order->status->title->{current_locale()} }}</span></td>
                                <td class="py-3 text-right">{{ currency_main($order->total, true) }}</td>
                                <td class="py-1 text-right">
                                    <a class="btn btn-icon mt-1" href="#order-details{{ $order->id }}" data-bs-toggle="modal"><i class="fas fa-eye mx-1 text-info"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center font-size-sm" colspan="4">
                                    <label>{{ __('front/common.no_orders') }}</label>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $orders->links() }}

            </section>
        </div>
    </div>

@endsection
