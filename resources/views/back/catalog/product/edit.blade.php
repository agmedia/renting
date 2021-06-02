@extends('back.layouts.backend')

@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">

    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">



@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Artikl edit</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('products') }}">Artikli</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Novi artikl</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Content -->
    <div class="content content-full ">

        <!-- END Page Content -->
    @include('back.layouts.partials.session')
    <!-- New Post -->

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
                        <div class="col-md-10">

                            <div class="form-group row items-push mb-2">
                                <div class="col-md-8">
                                    <label for="dm-post-edit-title">Naziv <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Upišite naziv artikla" value="Vukovi jedu pse">
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">Šifra <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sku" name="sku" placeholder="Upišite šifru artikla" value="65908">
                                </div>
                            </div>


                            <div class="form-group row items-push mb-2">
                                <div class="col-md-3">
                                    <label for="price">Cijena <span class="text-danger">*</span></label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="price" name="price" placeholder="00.00">
                                        <div class="input-group-append">
                                            <span class="input-group-text">kn</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="price">Akcija </label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="special" name="special" placeholder="00.00">
                                        <div class="input-group-append">
                                            <span class="input-group-text">kn</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="price">Akcija vrijedi</label>
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




                            <!-- CKEditor 5 Classic (js-ckeditor5-classic in Helpers.ckeditor5()) -->
                            <!-- For more info and examples you can check out http://ckeditor.com -->


                            <div class="form-group row  mb-4">
                                <div class="col-md-12">
                                <label for="dm-post-edit-slug">Opis</label>
                                <!-- CKEditor 5 Classic Container -->
                                <div id="js-ckeditor5-classic" name="description">Peti nastavak serijala o Arkadiju Renku “Vukovi jedu pse” iz pera Martina Cruza Smitha pokazati će da melankolični, beskompromisni, povučeni Renko nije izgubio ništa od svojega šarma kojim je opsjeo čitatelje u doba hladnog rata, još tamo daleke 1981. kada je objavljen prvi roman u seriji, “Park Gorkoga”.</div>
                                </div>
                            </div>


                            <!-- END CKEditor 5 Classic-->


                            <div class="form-group row items-push   mb-3">
                                <div class="col-md-4">

                                        <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                        <!-- For more info and examples you can check out https://github.com/select2/select2 -->
                                        <label for="dm-post-edit-slug">Kategorija</label>
                                        <select class="js-select2 form-control" id="category-select" name="category" style="width: 100%;" data-placeholder="Odaberi kategoriju">
                                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                            <option value="1">Knjige</option>
                                            <option value="2">Zemljovidi i vedute</option>

                                        </select>

                                </div>
                                <div class="col-md-4">

                                        <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                        <!-- For more info and examples you can check out https://github.com/select2/select2 -->
                                        <label for="dm-post-edit-slug">Autor</label>
                                        <select class="js-select2 form-control" id="author-select" name="author" style="width: 100%;" data-placeholder="Odaberi ili upiši novog">
                                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                            <option value="1">Smith Martin Cruz</option>
                                            <option value="2">Miroslav Krleža</option>

                                        </select>


                                </div>
                                <div class="col-md-4">


                                        <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                        <!-- For more info and examples you can check out https://github.com/select2/select2 -->
                                        <label for="dm-post-edit-slug">Izdavač</label>
                                        <select class="js-select2 form-control" id="publisher-select" name="publisher" style="width: 100%;" data-placeholder="Odaberi ili upiši novog">
                                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                            <option value="1">Algoritam</option>
                                            <option value="2">Ljevak</option>

                                        </select>



                                </div>

                            </div>


                            <div class="form-group row items-push mb-3">
                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">Broj stranica </label>
                                    <input type="text" class="form-control" id="title" name="numpages" placeholder="Upišite broj stranica" value="354">
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">Dimenzije </label>
                                    <input type="text" class="form-control" id="sku" name="dimensions" placeholder="Upišite dimenzije" value="6×24">
                                </div>

                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">Mjesto izdavanja </label>
                                    <input type="text" class="form-control" id="sku" name="publishcity" placeholder="Upišite mjesto izdavanja" value="Zagreb">
                                </div>
                            </div>


                            <div class="form-group row items-push   mb-3">
                                <div class="col-md-4">

                                    <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                    <!-- For more info and examples you can check out https://github.com/select2/select2 -->
                                    <label for="dm-post-edit-slug">Pismo</label>
                                    <select class="js-select2 form-control" id="type-select" name="type" style="width: 100%;" data-placeholder="Odaberi ili upiši">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="1">Latinica</option>
                                        <option value="2">Ćirilica</option>
                                        <option value="3">Glagoljica</option>

                                    </select>

                                </div>
                                <div class="col-md-4">

                                    <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                    <!-- For more info and examples you can check out https://github.com/select2/select2 -->
                                    <label for="dm-post-edit-slug">Stanje</label>
                                    <select class="js-select2 form-control" id="condition-select" name="condition" style="width: 100%;" data-placeholder="Odaberi ili upiši">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="1">Odlično</option>
                                        <option value="2">Oštećeno</option>

                                    </select>


                                </div>
                                <div class="col-md-4">


                                    <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                    <!-- For more info and examples you can check out https://github.com/select2/select2 -->
                                    <label for="dm-post-edit-slug">Uvez</label>
                                    <select class="js-select2 form-control" id="binding-select" name="binding" style="width: 100%;" data-placeholder="Odaberi ili upiši">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="1">Tvrdi</option>
                                        <option value="2">Meki</option>

                                    </select>



                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <!-- Meta Data -->

                <!-- END Meta Data -->

            </div>
            <div class="block ">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Slike</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="row justify-content-center">
                        <div class="col-md-10 ">
                            <!-- Dropzone (functionality is auto initialized by the plugin itself in js/plugins/dropzone/dropzone.min.js) -->
                            <!-- For more info and examples you can check out http://www.dropzonejs.com/#usage -->
                            <form class="dropzone" action="be_pages_ecom_product_edit.html">

                                <div class="dz-message" data-dz-message><span>Klikni ovdje ili dovuci slike za uplad</span></div>

                            </form>



                        </div>
                    </div>
                </div>

            </div>
            <div class="block ">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Meta Data - SEO</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 ">
                            <form action="be_pages_ecom_product_edit.html" method="POST" onsubmit="return false;">
                                <div class="form-group">
                                    <!-- Bootstrap Maxlength (.js-maxlength class is initialized in Helpers.maxlength()) -->
                                    <!-- For more info and examples you can check out https://github.com/mimo84/bootstrap-maxlength -->
                                    <label for="dm-ecom-product-meta-title">Meta naslov</label>
                                    <input type="text" class="js-maxlength form-control" id="dm-ecom-product-meta-title" name="dm-ecom-product-meta-title" value="" maxlength="70" data-always-show="true" data-placement="top">
                                    <small class="form-text text-muted">
                                        70 znakova max
                                    </small>
                                </div>

                                <div class="form-group">
                                    <!-- Bootstrap Maxlength (.js-maxlength class is initialized in Helpers.maxlength()) -->
                                    <!-- For more info and examples you can check out https://github.com/mimo84/bootstrap-maxlength -->
                                    <label for="dm-ecom-product-meta-description">Meta opis</label>
                                    <textarea class="js-maxlength form-control" id="dm-ecom-product-meta-description" name="dm-ecom-product-meta-description" rows="4" maxlength="160" data-always-show="true" data-placement="top"></textarea>
                                    <small class="form-text text-muted">
                                        160 znakova max
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="dm-post-edit-slug">SEO link (url)</label>
                                    <input type="text" class="form-control" id="dm-post-edit-slug" name="dm-post-edit-slug" value="murkett-tracey" disabled>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-hero-success my-2">
                                <i class="fas fa-save mr-1"></i> Snimi
                            </button>
                        </div>
                    </div>
                </div>

            </div>


        <!-- END New Post -->
    </div>


@endsection

@push('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['select2','ckeditor5','datepicker']);});</script>



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
