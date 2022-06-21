@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/apartment.titles') }}</h1>
                <a class="btn btn-hero-success my-2" href="{{ route('apartments.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> {{ __('back/apartment.new') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="content">
    @include('back.layouts.partials.session')

    <!-- All Products -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('back/apartment.all') }} {{ $apartments->total() }}</h3>
                <div class="block-options">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary mr-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-filter"></i> {{ __('back/layout.btn_filter') }}
                        </button>
                        <a class="btn btn-primary btn-inline-block" href="{{route('apartments')}}"><i class=" ci-trash"></i> {{ __('back/layout.btn_clean_filter') }}</a>
                    </div>
                </div>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="block-content bg-body-dark">
                    <form action="{{ route('apartments') }}" method="get">

                        <div class="form-group row items-push mb-0">
                            <div class="col-md-9 mb-0">
                                <div class="form-group">
                                    <div class="input-group flex-nowrap">
                                        <input type="text" class="form-control py-3 text-center" name="search" id="search-input" value="{{ request()->input('search') }}" placeholder="Upiši pojam pretraživanja">
                                        <button type="submit" class="btn btn-primary fs-base" onclick="setURL('search', $('#search-input').val());"><i class="fa fa-search"></i> </button>
                                    </div>
                                    <div class="form-text small">Pretraži po imenu, šifri, godini izdanja ili šifri police.</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="category-select" name="category" style="width: 100%;" data-placeholder="Odaberi kategoriju">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach ($categories as $group => $cats)
                                            @foreach ($cats as $id => $category)
                                                <option value="{{ $id }}" class="font-weight-bold small" {{ $id == request()->input('category') ? 'selected' : '' }}>{{ $group . ' >> ' . $category['title'] }}</option>
                                                @if ( ! empty($category['subs']))
                                                    @foreach ($category['subs'] as $sub_id => $subcategory)
                                                        <option value="{{ $sub_id }}" class="pl-3 text-sm" {{ $sub_id == request()->input('category') ? 'selected' : '' }}>{{ $subcategory['title'] }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row items-push mb-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    @livewire('back.layout.search.author-search', ['author_id' => request()->input('author') ?: '', 'list' => true])
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    @livewire('back.layout.search.publisher-search', ['publisher_id' => request()->input('publisher') ?: '', 'list' => true])
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="status-select" name="status" style="width: 100%;" data-placeholder="Odaberi Status">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="all" {{ 'all' == request()->input('status') ? 'selected' : '' }}>Svi artikli</option>
                                        <option value="active" {{ 'active' == request()->input('status') ? 'selected' : '' }}>Aktivni</option>
                                        <option value="inactive" {{ 'inactive' == request()->input('status') ? 'selected' : '' }}>Neaktivni</option>
                                        <option value="with_action" {{ 'with_action' == request()->input('status') ? 'selected' : '' }}>Sa akcijama</option>
                                        <option value="without_action" {{ 'without_action' == request()->input('status') ? 'selected' : '' }}>Bez akcija</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="sort-select" name="sort" style="width: 100%;" data-placeholder="Sortiraj artikle">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="new" {{ 'new' == request()->input('sort') ? 'selected' : '' }}>Najnovije</option>
                                        <option value="old" {{ 'old' == request()->input('sort') ? 'selected' : '' }}>Najstarije</option>
                                        <option value="price_up" {{ 'price_up' == request()->input('sort') ? 'selected' : '' }}>Cijena od manje</option>
                                        <option value="price_down" {{ 'price_down' == request()->input('sort') ? 'selected' : '' }}>Cijena od više</option>
                                        <option value="az" {{ 'az' == request()->input('sort') ? 'selected' : '' }}>Od A do Ž</option>
                                        <option value="za" {{ 'za' == request()->input('sort') ? 'selected' : '' }}>Od Ž do A</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="block-content">

            </div>
        </div>
    </div>
@endsection

@push('js_after')
    <script src="{{ asset('js/ag-input-field.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Page JS Helpers (Magnific Popup Plugin) -->
    <script>jQuery(function(){Dashmix.helpers('magnific-popup');});</script>

    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#category-select').select2({
                placeholder: 'Odaberite kategoriju',
                allowClear: true
            });
            $('#status-select').select2({
                placeholder: 'Odaberite status',
                allowClear: true
            });
            $('#sort-select').select2({
                placeholder: 'Sortiraj artikle',
                allowClear: true
            });

            //
            $('#category-select').on('change', (e) => {
                console.log(e.currentTarget.selectedOptions[0])
                setURL('category', e.currentTarget.selectedOptions[0]);
            });
            $('#status-select').on('change', (e) => {
                setURL('status', e.currentTarget.selectedOptions[0]);
            });
            $('#sort-select').on('change', (e) => {
                setURL('sort', e.currentTarget.selectedOptions[0]);
            });

            //
            Livewire.on('authorSelect', (e) => {
                setURL('author', e.author.id, true);
            });
            Livewire.on('publisherSelect', (e) => {
                setURL('publisher', e.publisher.id, true);
            });

            /*$('#btn-inactive').on('click', () => {
                setRegularURL('active', false);
            });
            $('#btn-today').on('click', () => {
                setRegularURL('today', true);
            });
            $('#btn-week').on('click', () => {
                setRegularURL('week', true);
            });*/

        });

        /**
         *
         * @param type
         * @param search
         */
        function setURL(type, search, isValue = false) {
            let url = new URL(location.href);
            let params = new URLSearchParams(url.search);
            let keys = [];

            for(var key of params.keys()) {
                if (key === type) {
                    keys.push(key);
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value);
                }
            })

            if (search.value) {
                params.append(type, search.value);
            }

            if (isValue && search) {
                params.append(type, search);
            }

            url.search = params;
            location.href = url;
        }

        /**
         *
         * @param type
         * @param search
         */
        function setRegularURL(type, search) {
            let searches = ['active', 'today', 'week'];
            let url = new URL(location.href);
            let params = new URLSearchParams(url.search);
            let keys = [];

            for(var key of params.keys()) {
                if (key === type) {
                    keys.push(key);
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value);
                }
            })

            params.append(type, search);

            url.search = params;
            location.href = url;
        }

        /**
         *
         * @param id
         */
        function setStatus(id) {
            let val = $('#status-' + id)[0].checked;

            axios.post("{{ route('apartments.change.status') }}", { id: id, value: val })
            .then((response) => {
                successToast.fire()
            })
            .catch((error) => {
                errorToast.fire()
            });
        }
    </script>

@endpush
