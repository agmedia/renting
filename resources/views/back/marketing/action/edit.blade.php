@extends('back.layouts.backend')
@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">


    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">



@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Akcija edit</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('actions') }}">Akcije</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nova akcija</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content content-full ">

        <!-- END Page Content -->
    @include('back.layouts.partials.session')



        <div class="row">

            <div class="col-md-6">

            <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ back()->getTargetUrl() }}">
                    <i class="fa fa-arrow-left mr-1"></i> Povratak
                </a>
                <div class="block-options">
                    <div class="custom-control custom-switch custom-control-success">
                        <input type="checkbox" class="custom-control-input" id="dm-post-edit-active" name="dm-post-edit-active" >
                        <label class="custom-control-label" for="dm-post-edit-active">Aktiviraj</label>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-12">

                        <div class="form-group row items-push mb-2">
                            <div class="col-md-8">
                                <label for="dm-post-edit-title">Naziv akcije <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Upišite naziv akcije" value="20% na sve knjige">
                            </div>
                            <div class="col-md-4">
                                <label for="dm-post-edit-title">Tip akcije <span class="text-danger">*</span></label>
                                <select class="form-control" id="example-select" name="example-select">
                                    <option value="0">-- Molimo odaberite --</option>
                                    <option value="1" selected>Kategorija</option>
                                    <option value="2">Nakladnik</option>
                                    <option value="3">Autor</option>
                                    <option value="4">Artikl</option>

                                </select>

                            </div>
                        </div>


                        <div class="form-group row items-push mb-2">
                            <div class="col-md-6">
                                <label for="dm-post-edit-title">Vrsta popusta <span class="text-danger">*</span></label>
                                <select class="form-control" id="example-select" name="example-select">
                                    <option value="0">-- Molimo odaberite --</option>
                                    <option value="1" selected>Postotak</option>
                                    <option value="2">Fiksni</option>


                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="price">Akcija <span class="text-danger">*</span></label>
                                <div class="input-group">

                                    <input type="text" class="form-control" id="special" name="special" placeholder="Unesite popust" value="20">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row items-push mb-2">
                            <div class="col-md-12">
                                <label for="price">Akcija vrijedi<span class="text-danger">*</span></label>
                                <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    <input type="text" class="form-control" id="specialfrom" name="specialfrom" placeholder="od" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    <div class="input-group-prepend input-group-append">
                                        <span class="input-group-text font-w600">
                                            <i class="fa fa-fw fa-arrow-right"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="specialto" name="specialto" placeholder="do" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                </div>
                            </div>



                        </div>


                        <div class="form-group row items-push   mb-3">
                            <div class="col-md-12">

                                <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                <!-- For more info and examples you can check out https://github.com/select2/select2 -->
                                <label for="dm-post-edit-slug">Kategorija<span class="text-danger">*</span></label>
                                <select class="js-select2 form-control" id="category-select" name="category" style="width: 100%;" data-placeholder="Odaberi kategoriju">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    <option value="1" selected>Knjige</option>
                                    <option value="2">Zemljovidi i vedute</option>

                                </select>

                            </div>



                        </div>


                    </div>
                </div>
            </div>

            <!-- Meta Data -->

            <!-- END Meta Data -->

        </div>

            </div>

            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Akcije</h3>
                    </div>
                    <div class="block-content">
                        <!-- All Products Table -->
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped table-vcenter">
                                <thead>
                                <tr>

                                    <th>Naziv</th>



                                    <th class="text-right" style="width: 100px;">Izbriši</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- row -->
                                <tr>

                                    <td class="font-size-sm">
                                        <a class="font-w600" href="{{ route('products.create') }}">Nove tajne sretne djece</a><br>


                                    </td>


                                    <td class="text-right font-size-sm">

                                        <a class="btn btn-sm btn-alt-secondary" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-times text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- end row -->
                                <!-- row -->
                                <tr>

                                    <td class="font-size-sm">
                                        <a class="font-w600" href="{{ route('products.create') }}">Hrvatsko domobranstvo u Drugom svjetskom ratu II. dio</a><br>

                                    </td>

                                    <td class="text-right font-size-sm">

                                        <a class="btn btn-sm btn-alt-secondary" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-times text-danger"></i>
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
            </div>

        </div>


    </div>

@endsection

@push('js_after')
    <!-- Page JS Plugins -->
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
                placeholder: 'Odaberite autora',
                tags: true
            });
            $('#publisher-select').select2({
                placeholder: 'Odaberite izdavača',
                tags: true
            });
            $('#type-select').select2({
                placeholder: 'Odaberite pismo',
                tags: true
            });
            $('#binding-select').select2({
                placeholder: 'Odaberite pismo',
                tags: true
            });
            $('#condition-select').select2({
                placeholder: 'Odaberite pismo',
                tags: true
            });
        })
    </script>

@endpush
