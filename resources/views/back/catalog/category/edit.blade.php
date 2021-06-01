@extends('back.layouts.backend')

@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">


@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Kategorija edit</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('categories') }}">Kategorije</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nova kategorija</li>
                    </ol>
                </nav>
            </div>


        </div>
    </div>


    <!-- Page Content -->
    <div class="content content-full content-boxed">
        <!-- New Post -->
        <form action="be_pages_blog_post_edit.html" method="POST" enctype="multipart/form-data" onsubmit="return false;">
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ route('categories') }}">
                        <i class="fa fa-arrow-left mr-1"></i> Lista kategorija
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
                                <label for="dm-post-edit-title">Naziv kategorije</label>
                                <input type="text" class="form-control" id="dm-post-edit-title" name="dm-post-edit-title" placeholder="Enter a title.." value="An adventure of a lifetime">
                            </div>
                            <div class="form-group">
                                <!-- Select2 (.js-select2 class is initialized in Helpers.select2()) -->
                                <!-- For more info and examples you can check out https://github.com/select2/select2 -->
                                <label for="dm-ecom-product-category">Glavna kategorija</label>
                                <select class="js-select2 form-control" id="category-select" name="dm-ecom-product-category" style="width: 100%;" data-placeholder="Odaberi">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    <option value="1">Knjige</option>
                                    <option value="2">Zemljovidi i vedute</option>
                                  o
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dm-post-edit-slug">SEO link (url)</label>
                                <input type="text" class="form-control" id="dm-post-edit-slug" name="dm-post-edit-slug" value="an-adventure-of-a-lifetime" disabled>
                            </div>
                            <div class="form-group">
                                <label for="dm-post-edit-excerpt">Opis kategorije</label>
                                <textarea class="form-control" id="dm-post-edit-excerpt" name="dm-post-edit-excerpt" rows="3" placeholder="Enter an excerpt..">Etiam egestas fringilla enim, id convallis lectus laoreet at. Fusce purus nisi, gravida sed consectetur ut, interdum quis nisi. Quisque egestas nisl id lectus facilisis scelerisque? Proin rhoncus dui at ligula vestibulum ut facilisis ante sodales! Suspendisse potenti. Aliquam tincidunt sollicitudin sem nec ultrices.</textarea>
                                <div class="form-text text-muted font-size-sm font-italic">Meta Opis - bitno za google</div>
                            </div>


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
    <!-- END Page Content -->
    @include('back.layouts.partials.session')

@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
          $('#category-select').select2({
            placeholder: 'Odaberite...'
          });
        })
    </script>


@endpush
