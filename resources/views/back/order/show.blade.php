@extends('back.layouts.backend')
@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">


@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Narudžba pregled</h1>
            </div>
        </div>
    </div>


    <!-- Page Content -->
    <div class="content">
    @include('back.layouts.partials.session')
        <!-- Quick Overview -->
<!--        <div class="row row-deck">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="item rounded-lg bg-xeco-lighter mx-auto mb-3">
                            <i class="fa fa-check text-xeco-dark"></i>
                        </div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            ORD.<strong>{{ $order->id }}</strong>
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="item rounded-lg bg-xeco-lighter mx-auto mb-3">
                            <i class="fa fa-check text-xeco-dark"></i>
                        </div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Plaćanje karticom
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="item rounded-lg bg-xeco-lighter mx-auto mb-3">
                            <i class="fa fa-check text-xeco-dark"></i>
                        </div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            GLS Dostava 25 kn
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="item rounded-lg bg-xeco-lighter mx-auto mb-3">
                            <i class="fa fa-check text-xeco-dark"></i>
                        </div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Plaćeno
                        </p>
                    </div>
                </a>
            </div>
        </div>-->
        <!-- END Quick Overview -->

        <!-- Products -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Artikli</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter font-size-sm">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">Slika</th>
                            <th>Naziv</th>

                            <th class="text-center">Kol</th>
                            <th class="text-right" style="width: 10%;">Cijena</th>
                            <th class="text-right" style="width: 10%;">Ukupno</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td class="text-center"><a href="be_pages_ecom_product_edit.html"> <img src="{{ asset($product->product->image) }}" height="80px"/></a></td>
                                <td><a href="be_pages_ecom_product_edit.html"><strong>{{ $product->name }}</strong></a></td>

                                <td class="text-center"><strong>{{ $product->quantity }}</strong></td>
                                <td class="text-right">{!! \App\Helpers\Helper::priceString($product->price) !!}</td>
                                <td class="text-right">{!! \App\Helpers\Helper::priceString($product->total) !!}</td>
                            </tr>
                        @endforeach

                        @foreach ($order->totals as $total)
                            <tr>
                                <td colspan="4" class="text-right"><strong>{{ $total->title }}:</strong></td>
                                <td class="text-right">{!! \App\Helpers\Helper::priceString($total->value) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END Products -->

        <!-- Customer -->
        <div class="row">
            <div class="col-sm-6">
                <!-- Billing Address -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Adresa dostave</h3>
                    </div>
                    <div class="block-content">
                        <div class="font-size-h4 mb-1">{{ $order->shipping_fname }} {{ $order->shipping_lname }}</div>
                        <address class="font-size-sm">
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_zip }} {{ $order->shipping_city }}<br>
                            {{ $order->shipping_state }}<br><br>
                            <i class="fa fa-phone"></i> {{ $order->shipping_phone }}<br>
                            <i class="fa fa-envelope"></i> <a href="javascript:void(0)">{{ $order->shipping_email }}</a>
                        </address>
                    </div>
                </div>
                <!-- END Billing Address -->
            </div>
            <div class="col-sm-6">
                <!-- Shipping Address -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Napomene</h3>
                    </div>
                    <div class="block-content">
                        <p>{{ $order->comment }}</p>
                    </div>
                </div>
                <!-- END Shipping Address -->
            </div>
        </div>
        <!-- END Customer -->

        <!-- Log Messages -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Povijest narudžbe</h3>
                <div class="block-options">
                    <div class="dropdown">
                        <button type="button" class="btn btn-alt-secondary" id="btn-add-comment">
                            Dodaj komentar
                        </button>
                        <button type="button" class="btn btn-light" id="dropdown-ecom-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Promjeni status
                            <i class="fa fa-angle-down ml-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-ecom-filters">
                            @foreach ($statuses as $status)
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">{{ $status->title }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="block-content">
                <table class="table table-borderless table-striped table-vcenter font-size-sm">
                    <tbody>
                    @foreach ($order->history as $record)
                        <tr>
                            <td class="font-size-base">
                                <span class="badge badge-primary">Narudžba</span>
                            </td>
                            <td>
                                <span class="font-w600">{{ \Illuminate\Support\Carbon::make($order->created_at)->diffForHumans() }}</span>
                            </td>
                            <td>
                                <a href="javascript:void(0)">{{ $record->user ? $record->user->name : $record->order->shipping_fname . ' ' . $record->order->shipping_lname }}</a>
                            </td>
                            <td>{{ $record->comment }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Log Messages -->
    </div>
    <!-- END Page Content -->

@endsection

@push('js_after')

    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#status-select').select2({
                placeholder: 'Promjenite status'
            });

        })
    </script>

@endpush
