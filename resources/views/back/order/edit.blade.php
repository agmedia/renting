@extends('back.layouts.backend')
@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">


@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Narudžba edit</h1>
            </div>
        </div>
    </div>


    <!-- Page Content -->
    <div class="content">
    @include('back.layouts.partials.session')
        <!-- Quick Overview -->
        <div class="row row-deck">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="item rounded-lg bg-xeco-lighter mx-auto mb-3">
                            <i class="fa fa-check text-xeco-dark"></i>
                        </div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            ORD.01852
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
        </div>
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
                        <tr>
                            <td class="text-center"><a href="be_pages_ecom_product_edit.html"> <img src="{{ asset('media/img/knjiga.jpg') }}" height="80px"/></a></td>
                            <td><a href="be_pages_ecom_product_edit.html"><strong>Vukovi jedu pse</strong></a></td>

                            <td class="text-center"><strong>1</strong></td>
                            <td class="text-right">80,00kn</td>
                            <td class="text-right">80,00kn</td>
                        </tr>
                        <tr>
                            <td class="text-center"><a href="be_pages_ecom_product_edit.html"> <img src="{{ asset('media/img/knjiga.jpg') }}" height="80px"/></a></td>
                            <td><a href="be_pages_ecom_product_edit.html"><strong>Vukovi jedu pse</strong></a></td>

                            <td class="text-center"><strong>1</strong></td>
                            <td class="text-right">80,00kn</td>
                            <td class="text-right">80,00kn</td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-right"><strong>Među suma:</strong></td>
                            <td class="text-right">160,00kn</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Dostava:</strong></td>
                            <td class="text-right">25,00kn</td>
                        </tr>
                        <tr class="table-active">
                            <td colspan="4" class="text-right text-uppercase"><strong>Ukupno:</strong></td>
                            <td class="text-right"><strong>185,00kn</strong></td>
                        </tr>
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
                        <div class="font-size-h4 mb-1">Pero Perić</div>
                        <address class="font-size-sm">
                            Taborska 11<br>
                            10000 Zagreb<br>
                            Croatia<br><br>
                            <i class="fa fa-phone"></i> +385 99 2153 698<br>
                            <i class="fa fa-envelope-o"></i> <a href="javascript:void(0)">preo.peric@gmail.com</a>
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
                        <p>Molim dostaviti čim prije. Hvala.</p>
                    </div>
                </div>
                <!-- END Shipping Address -->
            </div>
        </div>
        <!-- END Customer -->

        <!-- Log Messages -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Statusi</h3>
                <div class="block-options">
                    <div class="dropdown">
                        <button type="button" class="btn btn-light" id="dropdown-ecom-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dodaj status
                            <i class="fa fa-angle-down ml-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-ecom-filters">
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Čeka naplatu
                                <span class="badge badge-primary badge-pill">78</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Plaćeno
                                <span class="badge badge-secondary badge-pill">12</span>
                            </a>

                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Otkazano
                                <span class="badge badge-secondary badge-pill">5</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Poslano
                                <span class="badge badge-secondary badge-pill">280</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Sve narudžbe
                                <span class="badge badge-secondary badge-pill">19k</span>
                            </a>
                        </div>


                    </div>
                </div>
            </div>

            <div class="block-content">
                <table class="table table-borderless table-striped table-vcenter font-size-sm">
                    <tbody>

                    <tr>
                        <td class="font-size-base">
                            <span class="badge badge-primary">Narudžba</span>
                        </td>
                        <td>
                            <span class="font-w600">Siječanj 15, 2020 - 14:59</span>
                        </td>
                        <td>
                            <a href="javascript:void(0)">Admin</a>
                        </td>
                        <td>Narudžba poslana</td>
                    </tr>
                    <tr>
                        <td class="font-size-base">
                            <span class="badge badge-primary">Narudžba</span>
                        </td>
                        <td>
                            <span class="font-w600">Siječanj 15, 2020 - 14:29</span>
                        </td>
                        <td>
                            <a href="javascript:void(0)">Pero PErić</a>
                        </td>
                        <td>Narudžba izvršena</td>
                    </tr>
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
