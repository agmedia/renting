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

    <!-- Page Content -->
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row row-deck">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="be_pages_ecom_orders.html">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-warning mb-1">78</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Narudžbi u obradi
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-success mb-1">26</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Dovršenih narudžbi
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="font-size-h3 text-success font-w600 mb-1">126</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Narudžbi danas
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="font-size-h3 text-success font-w600 mb-1">350</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Narudžbi ovaj mjesec
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

        <!-- Orders Overview -->
     <!--   <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Orders Overview</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div> -->
        <!--   <div class="block-content block-content-full"> -->
              <!-- Chart.js is initialized in js/pages/be_pages_ecom_dashboard.min.js which was auto compiled from _js/pages/be_pages_ecom_dashboard.js) -->
                <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
               <!-- <div style="height: 420px;"><canvas class="js-chartjs-overview"></canvas></div>
            </div>
        </div> -->
        <!-- END Orders Overview -->

        <!-- Top Products and Latest Orders -->
        <div class="row">
            <div class="col-xl-6">
                <!-- Top Products -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Zadnje prodani artijki</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-striped table-vcenter font-size-sm">
                            <tbody>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.965</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Diablo III</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.154</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Control</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.523</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Minecraft</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.423</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Hollow Knight</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.391</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Sekiro: Shadows Die Twice</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.218</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">NBA 2K20</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.995</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Forza Motorsport 7</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.761</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Minecraft</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.860</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Dark Souls III</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 100px;">
                                    <a class="font-w600" href="be_pages_ecom_product_edit.html">PID.952</a>
                                </td>
                                <td>
                                    <a href="be_pages_ecom_product_edit.html">Age of Mythology</a>
                                </td>
                                <td class="font-w600 text-right">320,00 kn</td>
                            </tr>
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
                        <h3 class="block-title">Zadnje narudžbes</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-striped table-vcenter font-size-sm">
                            <tbody>
                            <tr>
                                <td class="font-w600 text-center" style="width: 100px;">
                                    <a href="be_pages_ecom_order.html">ORD.7116</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Brian Stevens</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Plaćeno</span>
                                </td>
                                <td class="font-w600 text-right">250,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7115</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Laura Carr</a>
                                </td>
                                <td>
                                    <span class="badge badge-danger">Otkazano</span>
                                </td>
                                <td class="font-w600 text-right">307,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7114</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Brian Stevens</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Plaćeno</span>
                                </td>
                                <td class="font-w600 text-right">413,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7113</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Justin Hunt</a>
                                </td>
                                <td>
                                    <span class="badge badge-warning">Čeka naplatu</span>
                                </td>
                                <td class="font-w600 text-right">812,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7112</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Thomas Riley</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Plaćeno</span>
                                </td>
                                <td class="font-w600 text-right">753,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7111</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Jesse Fisher</a>
                                </td>
                                <td>
                                    <span class="badge badge-warning">Čeka naplatu</span>
                                </td>
                                <td class="font-w600 text-right">210,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7110</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Scott Young</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Plaćeno</span>
                                </td>
                                <td class="font-w600 text-right">224,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7109</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Alice Moore</a>
                                </td>
                                <td>
                                    <span class="badge badge-warning">Čeka naplatu</span>
                                </td>
                                <td class="font-w600 text-right">481,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7108</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Jose Parker</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Plaćeno</span>
                                </td>
                                <td class="font-w600 text-right">999,00 kn</td>
                            </tr>
                            <tr>
                                <td class="font-w600 text-center">
                                    <a href="be_pages_ecom_order.html">ORD.7107</a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <a href="be_pages_ecom_customer.html">Jose Wagner</a>
                                </td>
                                <td>
                                    <span class="badge badge-danger">Otkazano</span>
                                </td>
                                <td class="font-w600 text-right">311,00 kn</td>
                            </tr>
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

