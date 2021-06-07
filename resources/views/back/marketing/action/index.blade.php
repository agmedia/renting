@extends('back.layouts.backend')
@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">


@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Akcije</h1>

            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content">
    @include('back.layouts.partials.session')


        <!-- All Products -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Sve akcije (152)</h3>

            </div>

                <div class="block-content bg-body-dark">

                    <!-- Search Form -->
                    <form action="db_booking.html" method="POST" onsubmit="return false;">

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

                            <div class="col-md-2">

                                <div class="form-group">

                                    <select class="form-control" id="example-select" name="example-select">
                                        <option value="0">Vrsta akcije</option>
                                        <option value="1">Postotak</option>
                                        <option value="2">Fiksno</option>

                                    </select>
                                </div>
                            </div>



                            <div class="col-md-2">



                                    <input type="text" class="form-control" id="special" name="special" placeholder="Popust">


                            </div>

                            <div class="col-md-5">

                                <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    <input type="text" class="form-control" id="specialfrom" name="specialfrom" placeholder="Vrijedi od" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    <div class="input-group-prepend input-group-append">
                                        <span class="input-group-text font-w600">
                                            <i class="fa fa-fw fa-arrow-right"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="specialto" name="specialto" placeholder="Vrijedi do" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-block ">Dodaj akcije</button>
                            </div>
                        </div>
                    </form>
                    <!-- END Search Form -->
                </div>

            <div class="block-content">
                <!-- All Products Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 30px;">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="checkAll" name="status">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center" style="width: 100px;">Slika</th>
                            <th>Naziv</th>
                            <th>Šifra</th>
                            <th>Cijena</th>
                            <th>Akcija</th>

                            <th class="text-center font-size-sm">Status</th>

                            <th class="text-right" style="width: 100px;">Uredi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <tr>
                            <td class="text-center">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="019265" name="status">
                                    </div>
                                </div>
                            </td>
                            <td class="text-center font-size-sm">
                                <img src="{{ asset('media/img/knjiga.jpg') }}" height="80px"/>
                            </td>
                            <td class="font-size-sm">
                                <a class="font-w600" href="{{ route('products.create') }}">Nove tajne sretne djece</a><br>
                                <span class="badge badge-secondary">Shaaron Biddulph</span>
                                <span class="badge badge-secondary">Mozaik knjiga</span>

                            </td>
                            <td class="font-size-sm">60593</td>
                            <td class="font-size-sm"><strike>120,00kn</strike></td>
                            <td class="font-size-sm">80,00kn</td>
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
                            <td class="text-center">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="019265" name="status">
                                    </div>
                                </div>
                            </td>
                            <td class="text-center font-size-sm">
                                <img src="{{ asset('media/img/knjiga2.jpg') }}" height="80px"/>
                            </td>
                            <td class="font-size-sm">
                                <a class="font-w600" href="{{ route('products.create') }}">Hrvatsko domobranstvo u Drugom svjetskom ratu II. dio</a><br>
                                <span class="badge badge-secondary">Shaaron Biddulph</span>
                                <span class="badge badge-secondary">Mozaik knjiga</span>
                            </td>
                            <td class="font-size-sm">60593</td>
                            <td class="font-size-sm"><strike>120,00kn</strike></td>
                            <td class="font-size-sm">80,00kn</td>
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
        <!-- END All Products -->
    </div>
    <!-- END Page Content -->

@endsection

@push('js_after')


    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['select2','datepicker']);});</script>
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
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endpush
