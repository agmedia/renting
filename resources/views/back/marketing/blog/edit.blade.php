@extends('back.layouts.backend')
@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">


    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">



@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Blog edit</h1>
            </div>
        </div>
    </div>



    <!-- Page Content -->
    <div class="content content-full content-boxed">
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

                            <div class="form-group">
                                <label for="dm-post-edit-title">Naziv</label>
                                <input type="text" class="form-control" id="dm-post-edit-title" name="dm-post-edit-title" placeholder="Unesite naslov..." value="Dvostruki je užitak spasiti vrijednu staru knjigu i još zaraditi na tome">
                            </div>

                            <div class="form-group">
                                <label for="dm-post-edit-excerpt">Sažetak</label>
                                <textarea class="form-control" id="dm-post-edit-excerpt" name="dm-post-edit-excerpt" rows="3" placeholder="Enter an excerpt..">Etiam egestas fringilla enim, id convallis lectus laoreet at. Fusce purus nisi, gravida sed consectetur ut, interdum quis nisi. Quisque egestas nisl id lectus facilisis scelerisque? Proin rhoncus dui at ligula vestibulum ut facilisis ante sodales! Suspendisse potenti. Aliquam tincidunt sollicitudin sem nec ultrices.</textarea>
                                <div class="form-text text-muted font-size-sm font-italic">Vidljivo na početnoj stranici</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xl-6">
                                    <label>Glavna slika</label>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" id="dm-post-edit-image" name="dm-post-edit-image" data-toggle="custom-file-input">
                                        <label class="custom-file-label" for="dm-post-edit-image">Prenesite sliku</label>
                                    </div>
                                    <div class="mt-2">
                                        <img class="img-fluid" src="{{ asset('media/img/novosti.jpg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row  mb-4">
                                <div class="col-md-12">
                                    <label for="dm-post-edit-slug">Opis</label>
                                    <!-- CKEditor 5 Classic Container -->
                                    <div id="js-ckeditor5-classic" name="description">Peti nastavak serijala o Arkadiju Renku “Vukovi jedu pse” iz pera Martina Cruza Smitha pokazati će da melankolični, beskompromisni, povučeni Renko nije izgubio ništa od svojega šarma kojim je opsjeo čitatelje u doba hladnog rata, još tamo daleke 1981. kada je objavljen prvi roman u seriji, “Park Gorkoga”.</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xl-6">
                                    <!-- Flatpickr Datetimepicker (.js-flatpickr class is initialized in Helpers.flatpickr()) -->
                                    <!-- For more info and examples you can check out https://github.com/flatpickr/flatpickr -->
                                    <label for="dm-post-edit-publish-date">Datum objave</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="dm-post-edit-publish-date" name="dm-post-edit-publish-date" data-enable-time="true" placeholder="Y-m-d H:i" value="2020-01-15 12:22">
                                </div>
                            </div>
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
    <!-- END Page Content -->

@endsection

@push('js_after')

    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/flatpickr/flatpickr.min.js') }}"></script>

    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['select2','ckeditor5','flatpickr']);});</script>

@endpush
