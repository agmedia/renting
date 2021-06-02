@extends('back.layouts.backend')
@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">


@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Artikli</h1>
                <a class="btn btn-hero-success my-2" href="{{ route('products.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> Novi artikl</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content">
    @include('back.layouts.partials.session')
        <!-- Quick Overview -->
        <div class="row row-deck">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="be_pages_ecom_dashboard.html">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-dark mb-1">36.963</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Svi artikli
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-danger mb-1">63</div>
                        <p class="font-w600 font-size-sm text-danger text-uppercase mb-0">
                            Neaktivnih
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="be_pages_ecom_dashboard.html">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-success mb-1">13</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Danas unešenih
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="be_pages_ecom_dashboard.html">
                    <div class="block-content py-5">
                        <div class="font-size-h3 font-w600 text-info mb-1">100</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Unešenih ovaj tjedan
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

        <!-- All Products -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Svi artikli</h3>

                <div class="block-options">

                    <div class="dropdown">

                        <button class="btn btn-outline-primary mr-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-search"></i> Pretraži
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="dropdown-ecom-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filtriraj <i class="fa fa-angle-down ml-1"></i>
                        </button>


                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-ecom-filters">
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Aktivno
                                <span class="badge badge-success badge-pill">26000</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Neaktivno
                                <span class="badge badge-danger badge-pill">10000</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Svi artikli
                                <span class="badge badge-secondary badge-pill">36000</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse" id="collapseExample">
            <div class="block-content bg-body-dark">

                <!-- Search Form -->
                <form action="db_booking.html" method="POST" onsubmit="return false;">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg py-3 text-center" id="dm-booking-destination" name="dm-booking-destination" placeholder="Upiši pojam pretraživanja">
                    </div>
                    <div class="form-group row items-push mb-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                <!-- For more info and examples you can check out https://github.com/select2/select2 -->

                                <select class="js-select2 form-control" id="category-select" name="category" style="width: 100%;" data-placeholder="Odaberi kategoriju">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    <option value="1">Knjige</option>
                                    <option value="2">Zemljovidi i vedute</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                <!-- For more info and examples you can check out https://github.com/select2/select2 -->

                                <select class="js-select2 form-control" id="author-select" name="author" style="width: 100%;" data-placeholder="Odaberi autora">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    <option value="1">Joža horvat</option>
                                    <option value="2">Miroslav Krleža</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                <!-- For more info and examples you can check out https://github.com/select2/select2 -->

                                <select class="js-select2 form-control" id="publisher-select" name="publisher" style="width: 100%;" data-placeholder="Odaberi izdavača">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    <option value="1">Algoritam</option>
                                    <option value="2">Ljevak</option>

                                </select>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Pretraži</button>
                        </div>
                    </div>
                </form>
                <!-- END Search Form -->
                </div>
            </div>
            <div class="block-content">
                <!-- All Products Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">Slika</th>
                            <th>Naziv</th>
                            <th>Šifra</th>
                            <th>Cijena</th>
                            <th>Dodano</th>

                            <th class="text-center font-size-sm">Status</th>

                            <th class="text-right" style="width: 100px;">Uredi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <tr>
                            <td class="text-center font-size-sm">
                                <img src="{{ asset('media/img/knjiga.jpg') }}" height="80px"/>
                            </td>
                            <td class="font-size-sm">
                                <a class="font-w600" href="{{ route('products.create') }}">Nove tajne sretne djece</a><br>
                                <span class="badge badge-secondary">Shaaron Biddulph</span>
                                <span class="badge badge-secondary">Mozaik knjiga</span>

                            </td>
                            <td class="font-size-sm">60593</td>
                            <td class="font-size-sm"><strong>120,00kn</strong></td>
                            <td class="font-size-sm">28/12/2019</td>
                            <td class="text-center font-size-sm">
                                <i class="fa fa-fw fa-check text-success"></i>
                            </td>
                            <td class="text-right font-size-sm">
                                <a class="btn btn-sm btn-alt-secondary" href="">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('products.create') }}">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- end row -->
                        <!-- row -->
                        <tr>
                            <td class="text-center font-size-sm">
                                <img src="{{ asset('media/img/knjiga2.jpg') }}" height="80px"/>
                            </td>
                            <td class="font-size-sm">
                                <a class="font-w600" href="{{ route('products.create') }}">Hrvatsko domobranstvo u Drugom svjetskom ratu II. dio</a><br>
                                <span class="badge badge-secondary">Shaaron Biddulph</span>
                                <span class="badge badge-secondary">Mozaik knjiga</span>
                            </td>
                            <td class="font-size-sm">60593</td>
                            <td class="font-size-sm"><strong>120,00kn</strong></td>
                            <td class="font-size-sm">28/12/2019</td>
                            <td class="text-center font-size-sm">
                                <i class="fa fa-fw fa-times text-danger"></i>
                            </td>
                            <td class="text-right font-size-sm">
                                <a class="btn btn-sm btn-alt-secondary" href="">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('products.create') }}">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- end row -->


                        </tbody>
                    </table>
                </div>
                <!-- END All Products Table -->

                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination justify-content-end mt-2">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-label="Previous">
                                Prev
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
                            <a class="page-link" href="javascript:void(0)" aria-label="Next">
                                Next
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END All Products -->
    </div>
    <!-- END Page Content -->

@endsection

@push('js_after')


    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#category-select').select2({
                placeholder: 'Odaberite kategoriju'
            });
            $('#author-select').select2({
                placeholder: 'Odaberite autora'
            });
            $('#publisher-select').select2({
                placeholder: 'Odaberite izdavača'
            });
        })
    </script>

@endpush
