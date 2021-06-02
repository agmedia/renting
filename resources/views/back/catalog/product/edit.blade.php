@extends('back.layouts.backend')

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
    <div class="content content-full content-boxed">

        <!-- END Page Content -->
    @include('back.layouts.partials.session')
    <!-- New Post -->
        <form action="be_pages_blog_post_edit.html" method="POST" enctype="multipart/form-data" onsubmit="return false;">
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
                                <label for="dm-post-edit-title">Naziv autora</label>
                                <input type="text" class="form-control" id="dm-post-edit-title" name="dm-post-edit-title" placeholder="Upišite naziv autora" value="Murkett Tracey">
                            </div>

                            <div class="form-group">
                                <label for="dm-post-edit-slug">SEO link (url)</label>
                                <input type="text" class="form-control" id="dm-post-edit-slug" name="dm-post-edit-slug" value="murkett-tracey" disabled>
                            </div>


                            <!-- CKEditor 5 Classic (js-ckeditor5-classic in Helpers.ckeditor5()) -->
                            <!-- For more info and examples you can check out http://ckeditor.com -->
                            <label for="dm-post-edit-slug">Opis autora</label>

                            <div class="form-group">
                                <!-- CKEditor 5 Classic Container -->
                                <div id="js-ckeditor5-classic"></div>
                            </div>


                            <!-- END CKEditor 5 Classic-->


                        </div>
                    </div>
                </div>

                <!-- Meta Data -->

                <!-- END Meta Data -->

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

                                <div class="form-group row">
                                    <div class="col-xl-6">
                                        <label>Open Graph slika</label>
                                        <div class="custom-file">

                                            <input type="file" class="custom-file-input" id="dm-post-edit-image" name="dm-post-edit-image" data-toggle="custom-file-input">
                                            <label class="custom-file-label" for="dm-post-edit-image">Odaberite sliku</label>
                                        </div>
                                        <div class="mt-2">
                                            <img class="img-fluid" src="{{ asset('media/img/lightslider.jpg') }}" alt="">
                                        </div>

                                        <div class="form-text text-muted font-size-sm font-italic">Slika koja se pokazuje kada se link dijeli (facebook, twitter, itd.)</div>
                                    </div>
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
        </form>
        <!-- END New Post -->
    </div>


@endsection

@push('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>

    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['ckeditor5']);});</script>


@endpush
