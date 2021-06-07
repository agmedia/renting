@extends('back.layouts.backend')
@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">


@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Narudžbe</h1>
            </div>
        </div>
    </div>


    <!-- Page Content -->
    <div class="content">
    @include('back.layouts.partials.session')
        <!-- Quick Overview -->
        <div class="row row-deck">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="be_pages_ecom_orders.html">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-primary mb-1">18</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Čeka naplatu
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 mb-1">16</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Danas
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 mb-1">34</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Jučer
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 mb-1">220</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Ovaj mjesec
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

        <!-- All Orders -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Sve narudžbe</h3>
                <div class="block-options">
                    <div class="form-group mb-0 mr-2">
                        <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                        <!-- For more info and examples you can check out https://github.com/select2/select2 -->

                        <select class="js-select2 form-control" id="status-select" name="status" style="width: 100%;" data-placeholder="Promjeni status narudžbe">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            <option value="1">Plaćeno</option>
                            <option value="2">Dovršeno</option>

                        </select>
                    </div>
                </div>
                <div class="block-options">
                    <div class="dropdown">
                        <button type="button" class="btn btn-light" id="dropdown-ecom-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filtriraj
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
            <div class="block-content bg-body-dark">
                <!-- Search Form -->
                <form action="be_pages_ecom_orders.html" method="POST" onsubmit="return false;">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-alt" id="dm-ecom-orders-search" name="dm-ecom-orders-search" placeholder="Pretraži narudžbe">
                    </div>
                </form>
                <!-- END Search Form -->
            </div>
            <div class="block-content">
                <!-- All Orders Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter font-size-sm">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 30px;">
                                <div class="form-group">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkAll" name="status">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center" style="width: 120px;">Br. narudžbe</th>
                            <th class="d-none d-sm-table-cell text-center">Datum</th>
                            <th>Status</th>
                            <th class="d-none d-xl-table-cell">Kupac</th>
                            <th class="d-none d-xl-table-cell text-center">Artikli</th>
                            <th class="d-none d-sm-table-cell text-right">Vrijednost</th>
                            <th class="text-center">Detalji</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center">
                                <div class="form-group">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="019265" name="status">
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <a class="font-w600" href="{{ route('orders.create') }}">
                                    <strong>019265</strong>
                                </a>
                            </td>
                            <td class=" text-center">08/10/2020</td>
                            <td class="font-size-base">
                                <span class="badge badge-pill badge-success">Plaćeno</span>
                            </td>
                            <td>
                                <a class="font-w600" href="be_pages_ecom_customer.html">Pero Perić</a>
                            </td>
                            <td class="text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">5</a>
                            </td>
                            <td class=" text-right">
                                <strong>1334,50 kn</strong>
                            </td>
                            <td class="text-center font-size-base">
                                <a class="btn btn-sm btn-alt-secondary" href="be_pages_ecom_order.html">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="019265" name="status">
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">
                                    <strong>019265</strong>
                                </a>
                            </td>
                            <td class="d-none d-sm-table-cell text-center">08/10/2020</td>
                            <td class="font-size-base">
                                <span class="badge badge-pill badge-success">Plaćeno</span>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <a class="font-w600" href="be_pages_ecom_customer.html">Pero Perić</a>
                            </td>
                            <td class="d-none d-xl-table-cell text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">5</a>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <strong>1334,50 kn</strong>
                            </td>
                            <td class="text-center font-size-base">
                                <a class="btn btn-sm btn-alt-secondary" href="be_pages_ecom_order.html">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="019265" name="status">
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">
                                    <strong>019265</strong>
                                </a>
                            </td>
                            <td class="d-none d-sm-table-cell text-center">08/10/2020</td>
                            <td class="font-size-base">
                                <span class="badge badge-pill badge-warning">Čeka naplatu</span>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <a class="font-w600" href="be_pages_ecom_customer.html">Pero Perić</a>
                            </td>
                            <td class="d-none d-xl-table-cell text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">5</a>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <strong>1334,50 kn</strong>
                            </td>
                            <td class="text-center font-size-base">
                                <a class="btn btn-sm btn-alt-secondary" href="be_pages_ecom_order.html">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="019265" name="status">
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">
                                    <strong>019265</strong>
                                </a>
                            </td>
                            <td class="d-none d-sm-table-cell text-center">08/10/2020</td>
                            <td class="font-size-base">
                                <span class="badge badge-pill badge-info">Dovršeno</span>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <a class="font-w600" href="be_pages_ecom_customer.html">Pero Perić</a>
                            </td>
                            <td class="d-none d-xl-table-cell text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">5</a>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <strong>1334,50 kn</strong>
                            </td>
                            <td class="text-center font-size-base">
                                <a class="btn btn-sm btn-alt-secondary" href="be_pages_ecom_order.html">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="019265" name="status">
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">
                                    <strong>019265</strong>
                                </a>
                            </td>
                            <td class="d-none d-sm-table-cell text-center">08/10/2020</td>
                            <td class="font-size-base">
                                <span class="badge badge-pill badge-danger">Otkazano</span>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <a class="font-w600" href="be_pages_ecom_customer.html">Pero Perić</a>
                            </td>
                            <td class="d-none d-xl-table-cell text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">5</a>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <strong>1334,50 kn</strong>
                            </td>
                            <td class="text-center font-size-base">
                                <a class="btn btn-sm btn-alt-secondary" href="be_pages_ecom_order.html">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="019265" name="status">
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">
                                    <strong>019265</strong>
                                </a>
                            </td>
                            <td class="d-none d-sm-table-cell text-center">08/10/2020</td>
                            <td class="font-size-base">
                                <span class="badge badge-pill badge-dark">Poslano</span>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <a class="font-w600" href="be_pages_ecom_customer.html">Pero Perić</a>
                            </td>
                            <td class="d-none d-xl-table-cell text-center">
                                <a class="font-w600" href="be_pages_ecom_order.html">5</a>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <strong>1334,50 kn</strong>
                            </td>
                            <td class="text-center font-size-base">
                                <a class="btn btn-sm btn-alt-secondary" href="be_pages_ecom_order.html">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>

                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- END All Orders Table -->

                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination justify-content-end mt-2">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-label="Prethodna">
                                Prethodna
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="javascript:void(0)">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" aria-label="Sljedeća">
                                Sljedeća
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END All Orders -->
    </div>

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
<script>
    $("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>

@endpush
