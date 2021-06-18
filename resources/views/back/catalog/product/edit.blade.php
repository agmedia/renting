@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">

    @stack('product_css')
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
    <div class="content content-full">
        @include('back.layouts.partials.session')

        <form action="{{ isset($product) ? route('products.update', ['product' => $product]) : route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($product))
                {{ method_field('PATCH') }}
            @endif

            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ back()->getTargetUrl() }}">
                        <i class="fa fa-arrow-left mr-1"></i> Povratak
                    </a>
                    <div class="block-options">
                        <div class="custom-control custom-switch custom-control-success">
                            <input type="checkbox" class="custom-control-input" id="product-switch" name="status"{{ (isset($product->status) and $product->status) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="product-switch">Aktiviraj</label>
                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <div class="form-group row items-push mb-2">
                                <div class="col-md-8">
                                    <label for="dm-post-edit-title">Naziv <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="Upišite naziv artikla" value="{{ isset($product) ? $product->name : old('name') }}" onkeyup="SetSEOPreview()">
                                    @error('name')
                                    <span class="text-danger font-italic">Naziv je potreban...</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="sku-input">Šifra <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sku-input" name="sku" placeholder="Upišite šifru artikla" value="{{ isset($product) ? $product->sku : old('sku') }}">
                                    @error('sku')
                                    <span class="text-danger font-italic">Šifra je potrebna...</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row items-push mb-2">
                                <div class="col-md-3">
                                    <label for="price-input">Cijena <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="price-input" name="price" placeholder="00.00" value="{{ isset($product) ? $product->price : old('price') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">kn</span>
                                        </div>
                                    </div>
                                    @error('price')
                                    <span class="text-danger font-italic">Cijena je potrebna...</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="special-input">Akcija</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="special-input" name="special" placeholder="00.00" value="{{ isset($product) ? $product->special : old('special') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">kn</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="special-from-input">Akcija vrijedi</label>
                                    <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <input type="text" class="form-control" id="special-from-input" name="special_from" placeholder="od" value="{{ isset($product->special_from) ? \Carbon\Carbon::make($product->special_from)->format('d.m.Y') : '' }}" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <div class="input-group-prepend input-group-append">
                                            <span class="input-group-text font-w600"><i class="fa fa-fw fa-arrow-right"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="special-to-input" name="special_to" placeholder="do" value="{{ isset($product->special_to) ? \Carbon\Carbon::make($product->special_to)->format('d.m.Y') : '' }}" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    </div>
                                </div>
                            </div>
                            <!-- CKEditor 5 Classic (js-ckeditor5-classic in Helpers.ckeditor5()) -->
                            <!-- For more info and examples you can check out http://ckeditor.com -->
                            <div class="form-group row mb-4">
                                <div class="col-md-12">
                                    <label for="description-editor">Opis</label>
                                    <textarea id="description-editor" name="description">{!! isset($product) ? $product->description : old('description') !!}</textarea>
                                </div>
                            </div>

                            <div class="form-group row items-push mb-3">
                                <div class="col-md-4">
                                    <label for="dm-post-edit-slug">Kategorija</label>
                                    <select class="js-select2 form-control" id="category-select" name="category" style="width: 100%;" data-placeholder="Odaberite kategoriju">
                                        <option></option>
                                        @foreach ($data['categories'] as $group => $cats)
                                            @foreach ($cats as $id => $category)
                                                <option value="{{ $id }}" class="font-weight-bold small" {{ ((isset($product)) and (in_array($id, $product->categories()->pluck('id')->toArray()))) ? 'selected' : '' }}>{{ $group . ' >> ' . $category['title'] }}</option>
                                                @if ( ! empty($category['subs']))
                                                    @foreach ($category['subs'] as $sub_id => $subcategory)
                                                        <option value="{{ $sub_id }}" class="pl-3 text-sm" {{ ((isset($product)) and (in_array($id, $product->categories()->pluck('id')->toArray()))) ? 'selected' : '' }}>{{ $subcategory['title'] }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-slug">Autor</label>
                                    <select class="js-select2 form-control" id="author-select" name="author" style="width: 100%;" data-placeholder="Odaberite ili upišite novog">
                                        <option></option>
                                        @foreach ($data['authors'] as $id => $author)
                                            <option value="{{ $id }}" {{ ((isset($product)) and ($id == $product->author_id)) ? 'selected' : '' }}>{{ $author }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-slug">Izdavač</label>
                                    <select class="js-select2 form-control" id="publisher-select" name="publisher" style="width: 100%;" data-placeholder="Odaberite ili upišite novog">
                                        <option></option>
                                        @foreach ($data['publishers'] as $id => $publisher)
                                            <option value="{{ $id }}" {{ ((isset($product)) and ($id == $product->publisher_id)) ? 'selected' : '' }}>{{ $publisher }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row items-push mb-3">
                                <div class="col-md-4">
                                    <label for="pages-input">Broj stranica</label>
                                    <input type="text" class="form-control" id="pages-input" name="pages" placeholder="Upišite broj stranica" value="{{ isset($product) ? $product->pages : old('pages') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="dimensions-input">Dimenzije</label>
                                    <input type="text" class="form-control" id="dimensions-input" name="dimensions" placeholder="Upišite dimenzije" value="{{ isset($product) ? $product->dimensions : old('dimensions') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="origin-input">Mjesto izdavanja</label>
                                    <input type="text" class="form-control" id="origin-input" name="origin" placeholder="Upišite mjesto izdavanja" value="{{ isset($product) ? $product->origin : old('origin') }}">
                                </div>
                            </div>

                            <div class="form-group row items-push mb-3">
                                <div class="col-md-4">
                                    <label for="letter-select">Pismo</label>
                                    <select class="js-select2 form-control" id="letter-select" name="letter" style="width: 100%;" data-placeholder="Odaberite ili upišite pismo">
                                        <option></option>
                                        @if ($data['letters'])
                                            @foreach ($data['letters'] as $letter)
                                                <option value="{{ $letter }}" {{ ((isset($product)) and ($letter == $product->letter)) ? 'selected' : '' }}>{{ $letter }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-slug">Stanje</label>
                                    <select class="js-select2 form-control" id="condition-select" name="condition" style="width: 100%;" data-placeholder="Odaberite ili upišite stanje">
                                        <option></option>
                                        @if ($data['conditions'])
                                            @foreach ($data['conditions'] as $condition)
                                                <option value="{{ $condition }}" {{ ((isset($product)) and ($condition == $product->condition)) ? 'selected' : '' }}>{{ $condition }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-slug">Uvez</label>
                                    <select class="js-select2 form-control" id="binding-select" name="binding" style="width: 100%;" data-placeholder="Odaberite ili upišite uvez">
                                        <option></option>
                                        @if ($data['bindings'])
                                            @foreach ($data['bindings'] as $binding)
                                                <option value="{{ $binding }}" {{ ((isset($product)) and ($binding == $product->binding)) ? 'selected' : '' }}>{{ $binding }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Slike</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <!-- Dropzone (functionality is auto initialized by the plugin itself in js/plugins/dropzone/dropzone.min.js) -->
                            <!-- For more info and examples you can check out http://www.dropzonejs.com/#usage -->
<!--                            <div class="dropzone">
                                <div class="dz-message" data-dz-message><span>Klikni ovdje ili dovuci slike za uplad</span></div>
                            </div>-->
                            @include('back.catalog.product.edit-photos')
                        </div>
                    </div>
                </div>
            </div>

            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Meta Data - SEO</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="meta-title-input">Meta naslov</label>
                                <input type="text" class="js-maxlength form-control" id="meta-title-input" name="meta_title" value="{{ isset($product) ? $product->meta_title : old('meta_title') }}" maxlength="70" data-always-show="true" data-placement="top">
                                <small class="form-text text-muted">
                                    70 znakova max
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="meta-description-input">Meta opis</label>
                                <textarea class="js-maxlength form-control" id="meta-description-input" name="meta_description" rows="4" maxlength="160" data-always-show="true" data-placement="top">{{ isset($product) ? $product->meta_description : old('meta_description') }}</textarea>
                                <small class="form-text text-muted">
                                    160 znakova max
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="slug-input">SEO link (url)</label>
                                <input type="text" class="form-control" id="slug-input" name="slug" value="{{ isset($product) ? $product->slug : old('slug') }}" disabled>
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
    </div>
@endsection

@push('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>

    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['datepicker']);});</script>

    <script>
        $(() => {
            ClassicEditor
            .create(document.querySelector('#description-editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

            $('#category-select').select2({});
            $('#author-select').select2({
                tags: true
            });
            $('#publisher-select').select2({
                tags: true
            });
            $('#letter-select').select2({
                tags: true
            });
            $('#binding-select').select2({
                tags: true
            });
            $('#condition-select').select2({
                tags: true
            });
        })
    </script>

    <script>
        function SetSEOPreview() {
            let title = $('#name-input').val();
            $('#slug-input').val(slugify(title));
        }
    </script>

    @stack('product_scripts')

@endpush
