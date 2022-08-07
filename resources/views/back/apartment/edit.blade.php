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
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">
                    <a class="btn btn-light js-tooltip-enabled" style="margin-bottom: 5px;" href="{{ route('apartments') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Top Tooltip">
                        <i class="fa fa-arrow-left mr-1"></i>
                    </a>
                    {{ __('back/apartment.edit') }}
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('apartments') }}">{{ __('back/apartment.titles') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('back/apartment.edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content content-full">
        @include('back.layouts.partials.session')


        <form action="{{ isset($apartment) ? route('apartments.update', ['apartment' => $apartment]) : route('apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($apartment))
                {{ method_field('PATCH') }}
            @endif


            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Osnovne informacije</h3>
                </div>

                <div class="block-content block-content-full">
                    <div class="row justify-content-center push">
                        <div class="col-md-11">
                            <div class="form-group row items-push">
                                <div class="col-md-4">
                                    <div class="row gutters-tiny">
                                        <div class="col-md-12 mb-2">
                                            <a class="img-thumb img-lightbox" href="{{ asset('media/photos/photo1.jpg') }}">
                                                <img class="img-fluid" src="{{ asset('media/photos/photo1.jpg') }}" alt="">
                                            </a>
                                        </div>
                                        @foreach ([2,3,4,5] as $photo)
                                            <div class="col-md-3">
                                                <a class="img-thumb img-lightbox" href="{{ asset('media/photos/photo' . $photo . '.jpg') }}">
                                                    <img class="img-fluid" src="{{ asset('media/photos/photo' . $photo . '.jpg') }}" alt="">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row gutters-tiny">
                                        <div class="col-md-12 mt-3">
                                            <button class="btn btn-block btn-outline-info" onclick="event.preventDefault(); openModal({{ json_encode(\Illuminate\Support\Facades\URL::previous()) }});">
                                                <i class="fa fa-fw fa-pencil-alt"></i> Editiraj fotografije
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8 pl-5">
                                    <div class="row">
                                        <div class="col-md-12 mt-3 mb-3">
                                            <label for="dm-post-edit-title">Naziv apartmana <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $product->title : old('title') }}">
                                            @error('name')
                                            <span class="text-danger font-italic">Naziv je potreban...</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="type-select">Tip <span class="text-danger">*</span></label>
                                            <select class="js-select2 form-control" id="type-select" name="type_id" style="width: 100%;">
                                                <option></option>
                                                @foreach (config('settings.apartment_types') as $select_item)
                                                    <option value="{{ $select_item['id'] }}" {{ ((isset($apartment)) and ($select_item['id'] == $apartment->type_id)) ? 'selected' : (( ! isset($apartment) and ($select_item['default'] == 1)) ? 'selected' : '') }}>{{ $select_item['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="target-select">Namjena <span class="text-danger">*</span></label>
                                            <select class="js-select2 form-control" id="target-select" name="target_id" style="width: 100%;">
                                                <option></option>
                                                @foreach (config('settings.apartment_targets') as $select_item)
                                                    <option value="{{ $select_item['id'] }}" {{ ((isset($apartment)) and ($select_item['id'] == $apartment->target_id)) ? 'selected' : (( ! isset($apartment) and ($select_item['default'] == 1)) ? 'selected' : '') }}>{{ $select_item['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dm-post-edit-title">Šifra <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $product->title : old('title') }}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <h2 class="content-heading">Lokacija</h2>

                            <div class="form-group row items-push">
                                <div class="col-md-6">
                                    <label for="dm-post-edit-title">Ulica <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $product->title : old('title') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">Grad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $product->title : old('title') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="dm-post-edit-title">Zip <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $product->title : old('title') }}">
                                </div>

                                <div class="col-md-6 text-right mt-4"><label for="dm-post-edit-title">Geografska duljina <span class="text-danger"></span></label></div>
                                <div class="col-md-6 mt-3">
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $product->title : old('title') }}">
                                </div>
                                <div class="col-md-6 text-right mt-2"><label for="dm-post-edit-title">Geografska širina <span class="text-danger"></span></label></div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $product->title : old('title') }}">
                                </div>
                            </div>


                            <h2 class="content-heading">Cijena, akcije i porez
                                <small class="text-gray-dark ml-3">Treba li možda više cijena. Kao pred/post sezonske cijene?...</small>
                            </h2>

                            <div class="form-group row items-push">
                                <div class="col-md-6">
                                    <label for="dm-post-edit-title">Cijena <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $product->title : old('title') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="dm-post-edit-title">Cijena prema <span class="text-danger"></span></label>
                                    <select class="js-select2 form-control" id="price-by-select" name="price_by" style="width: 100%;">
                                        <option></option>
                                        @foreach (config('settings.apartment_price_by') as $key => $select_item)
                                            <option value="{{ $key }}" {{ ((isset($apartment)) and ($key == $apartment->price_per)) ? 'selected' : (( ! isset($apartment) and ($select_item['default'] == 1)) ? 'selected' : '') }}>{{ $select_item['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="price-input">Porez</label>
                                    <select class="js-select2 form-control" id="tax-select" name="tax_id" style="width: 100%;" data-placeholder="Odaberite porez...">
                                        <option></option>
                                        @foreach ($data['taxes'] as $tax)
                                            <option value="{{ $tax->id }}" {{ ((isset($apartment)) and ($tax->id == $apartment->tax_id)) ? 'selected' : (( ! isset($apartment) and ($tax->id == 1)) ? 'selected' : '') }}>{{ $tax->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row items-push mb-3">
                                <div class="col-md-6">
                                    <label for="special-input">Akcija</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="special-input" name="special" placeholder="00.00" value="{{ isset($apartment) ? $apartment->special : old('special') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">kn</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="special-from-input">Akcija vrijedi</label>
                                    <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <input type="text" class="form-control" id="special-from-input" name="special_from" placeholder="od" value="{{ isset($apartment->special_from) ? \Carbon\Carbon::make($apartment->special_from)->format('d.m.Y') : '' }}" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <div class="input-group-prepend input-group-append">
                                            <span class="input-group-text font-w600"><i class="fa fa-fw fa-arrow-right"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="special-to-input" name="special_to" placeholder="do" value="{{ isset($apartment->special_to) ? \Carbon\Carbon::make($apartment->special_to)->format('d.m.Y') : '' }}" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    </div>
                                </div>
                            </div>


                            <h2 class="content-heading">Opis apartmana</h2>

                            <div class="form-group row mb-4">
                                <div class="col-md-12">
                                    <textarea id="description-editor" name="description">{!! isset($apartment) ? $apartment->description : old('description') !!}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Dodatne informacija</h3>
                </div>

                <div class="block-content block-content-full">
                    <div class="row justify-content-center push">
                        <div class="col-md-11">
                            <div class="form-group row items-push">
                                <div class="col-md-3">
                                    <label for="dm-post-edit-title">Kvadratnih metara</label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $apartment->title : old('title') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="dm-post-edit-title">Broj soba</label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $apartment->title : old('title') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="dm-post-edit-title">Broj kreveta</label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $apartment->title : old('title') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="dm-post-edit-title">Broj kupaonica</label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $apartment->title : old('title') }}">
                                </div>
                            </div>

                            <h2 class="content-heading">Brzi izbor dodatnih informacija</h2>

                            <div class="form-group row items-push">
                                @foreach (config('settings.apartment_details') as $detail)
                                    <div class="col-md-2">
                                        <div class="custom-control custom-switch custom-control-lg mb-2">
                                            <input type="checkbox" class="custom-control-input" id="example-sw-custom-lg1" name="example-sw-custom-lg1" {{ (isset($apartment->detail) and $apartment->detail) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="example-sw-custom-lg1">{{ $detail['title'] }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <h2 class="content-heading">Unos dodatnih informacija</h2>

                            <div class="form-group row items-push">
                                <div class="col-md-12 p-3 bg-gray-light text-gray-darker">
                                    <div class="row">
                                        <div class="col-md-8 mt-3">
                                            <p>Odaberite spremljeni info...<br>
                                                <small>U bazi spremljen kao favorit. Prikazuje se u listi zavisno od Tip-a.</small>
                                            </p>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <select class="js-select2 form-control" id="favorite-select" name="favorite_id" style="width: 100%;" data-placeholder="Odaberite...">
                                                <option></option>
                                                <option value="1">Favorit bazen</option>
                                                <option value="2">Favorit parking</option>
                                                <option value="3">Favorit roštilj</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <label for="dm-post-edit-title">Naslov ?</label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $apartment->title : old('title') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">Vrijednost</label>
                                    <input type="text" class="form-control" id="name-input" name="name" placeholder="" value="{{ isset($apartment) ? $apartment->title : old('title') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="dm-post-edit-title">Kratki opis informacije</label>
                                    <textarea class="form-control" id="name-input" name="name" placeholder="Opis..." rows="4">{{ isset($apartment) ? $apartment->title : old('title') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="dm-post-edit-title">Ikona</label>
                                            <select class="js-select2 form-control" id="icon-select" name="icon_id" style="width: 100%;" data-placeholder="Odaberite ikonu...">
                                                <option></option>
                                                <option value="1">Ikona bazen</option>
                                                <option value="2">Ikona parking</option>
                                                <option value="3">Ikona roštilj</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="dm-post-edit-title">Galerija</label>
                                            <select class="js-select2 form-control" id="gallery-select" name="gallery_id" style="width: 100%;" data-placeholder="Odaberite galeriju...">
                                                <option></option>
                                                <option value="1">Galerija Bazen mali</option>
                                                <option value="2">Galerija Bazen veliki</option>
                                                <option value="3">Galerija Parking Vila Ante 1</option>
                                                <option value="3">Galerija Parking Vila Mila 1</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <button type="submit" class="btn btn-outline-info btn-block my-2">Nova galerija</button>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <button type="submit" class="btn btn-outline-info btn-block my-2">Dodaj u favorite</button>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <button type="submit" class="btn btn-success btn-block my-2">
                                                <i class="fas fa-save mr-1"></i> Snimi
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <h2 class="content-heading">Lista unesenih dodatnih informacija</h2>

                            <div class="form-group row items-push">
                                <div class="col-md-12">

                                    <table class="table table-vcenter">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width: 50px;">#</th>
                                            <th>Naslov</th>
                                            <th class="d-none d-sm-table-cell" style="width: 25%;">Vrijednost</th>
                                            <th class="text-center" style="width: 100px;">Akcije</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th class="text-center" scope="row">1</th>
                                            <td class="font-w600">
                                                <a href="be_pages_generic_profile.html">Blizina bolnice</a>
                                                <p class="small text-gray-dark mb-0">Neki kratki opis informacije za bolnicu i zašto je super što je 450m.</p>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                450m
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-primary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-center" scope="row">2</th>
                                            <td class="font-w600">
                                                <a href="be_pages_generic_profile.html">VIP Organizirani izlet</a>
                                                <p class="small text-gray-dark mb-0">Neki kratki tekst o izletu. Može biti i prazno.</p>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                Besplatno
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-primary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
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
                            @include('back.catalog.product.edit-photos')
                        </div>
                    </div>
                </div>
            </div>


        </form>

        {{--@if (isset($product))
            <form id="delete-product-form{{ $product->id }}" action="{{ route('products.destroy', ['product' => $product]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif--}}
    </div>
@endsection

@push('modals')

    <div class="modal fade" id="images-modal" tabindex="-1" role="dialog" aria-labelledby="images-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-xl" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Fotografije</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                @include('back.catalog.product.edit-photos')
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            Odustani <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-success" onclick="event.preventDefault(); confirmDelete();">
                            Snimi <i class="fa fa-save ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
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

            $('#tax-select').select2({ minimumResultsForSearch: Infinity });
            $('#favorite-select').select2({ minimumResultsForSearch: Infinity });
            $('#icon-select').select2({ minimumResultsForSearch: Infinity });
            $('#gallery-select').select2({ minimumResultsForSearch: Infinity });

            $('#type-select').select2({ minimumResultsForSearch: Infinity });
            $('#target-select').select2({ minimumResultsForSearch: Infinity });
            $('#price-by-select').select2({ minimumResultsForSearch: Infinity });


            Livewire.on('success_alert', () => {

            });

            Livewire.on('error_alert', (e) => {

            });
        })
    </script>

    <script>
        function SetSEOPreview() {
            let title = $('#name-input').val();
            $('#slug-input').val(slugify(title));
        }


        /**
         *
         * @param item
         * @param type
         */
        function openModal(item = {}) {
            //console.log(item);

            $('#images-modal').modal('show');
            //editStatus(item);
        }
    </script>

    @stack('product_scripts')

@endpush
