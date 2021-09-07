@extends('back.layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Nadzorna ploča</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Nadzorna ploča</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    @if (auth()->user()->can('*'))
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="content pt-0">
                    <a href="{{ route('roles.set') }}" class="btn btn-hero-sm btn-rounded btn-hero-info">Set Roles</a>
                    <a href="{{ route('import.initial') }}" class="btn btn-hero-sm btn-rounded btn-hero-info ml-3">Initial Import</a>
<!--                    <a href="{{ route('import.initial') }}" class="btn btn-hero-sm btn-rounded btn-hero-info ml-3">Initial Import</a>-->
                </div>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row row-deck">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('orders') }}">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-warning mb-1">{{ $data['proccess'] }}</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Narudžbi u obradi
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('orders') }}">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-success mb-1">{{ $data['finished'] }}</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Dovršenih narudžbi
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('orders') }}">
                    <div class="block-content py-5">
                        <div class="font-size-h3 text-success font-w600 mb-1">{{ $data['today'] }}</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Narudžbi danas
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('orders') }}">
                    <div class="block-content py-5">
                        <div class="font-size-h3 text-success font-w600 mb-1">{{ $data['this_month'] }}</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Narudžbi ovaj mjesec
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

        <!-- Orders Overview -->
<!--        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Tjedni pregled</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                &lt;!&ndash; Chart.js is initialized in js/pages/be_pages_ecom_dashboard.min.js which was auto compiled from _js/pages/be_pages_ecom_dashboard.js) &ndash;&gt;
                &lt;!&ndash; For more info and examples you can check out http://www.chartjs.org/docs/ &ndash;&gt;
                <div style="height: 420px;"><canvas class="js-chartjs-overview"></canvas></div>
            </div>
        </div>-->


        <!-- Top Products and Latest Orders -->
        <div class="row">
            <div class="col-xl-6">
                <!-- Top Products -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Zadnje prodani artikli</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-striped table-vcenter font-size-sm">
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="text-center" style="width: 100px;">
                                        <a class="font-w600" href="{{ route('products.edit', ['product' => $product->real]) }}">{{ $product->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', ['product' => $product->real]) }}">{{ $product->name }}</a>
                                    </td>
                                    <td class="font-w600 text-right">{{ number_format($product->price, 2, ',', '.') }} kn</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Top Products -->
            </div>
            <div class="col-xl-6">
                <!-- Latest Orders -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Zadnje narudžbe</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-striped table-vcenter font-size-sm">
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="font-w600 text-center" style="width: 100px;">
                                        <a href="be_pages_ecom_order.html">{{ $order->id }}</a>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <a href="be_pages_ecom_customer.html">{{ $order->payment_fname . ' ' . $order->payment_lname }}</a>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-{{ $order->status->color }}">{{ $order->status->title }}</span>
                                    </td>
                                    <td class="font-w600 text-right">{{ number_format($order->total, 2, ',', '.') }} kn</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Latest Orders -->
            </div>
        </div>
        <!-- END Top Products and Latest Orders -->
    </div>
    <!-- END Page Content -->
@endsection

@push('js_after')

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/be_pages_ecom_dashboard.min.js') }}"></script>

@endpush

