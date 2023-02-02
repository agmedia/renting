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
                        <button class="btn btn-outline-primary mr-3" type="button" data-toggle="collapse" data-target="#apartments-filter" aria-expanded="false" aria-controls="apartments-filter">
                            <i class="fa fa-filter"></i> {{ __('back/layout.btn_filter') }}
                        </button>
                        <a class="btn btn-primary btn-inline-block" href="{{route('apartments')}}"><i class="ci-trash"></i> {{ __('back/layout.btn_clean_filter') }}</a>
                    </div>
                </div>
            </div>
            <div class="collapse" id="apartments-filter">
                <div class="block-content bg-body-dark">
                    <div class="form-group row items-push mb-0">
                        <div class="col-md-6 mb-0">
                            <div class="form-group">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control py-3 text-center" name="search" id="search-input" value="{{ request()->input('search') }}" placeholder="{{ __('back/apartment.searchname') }}">
                                    <button type="submit" id="btn-search" class="btn btn-primary fs-base" onclick="setURL('search', $('#search-input').val(), true);"><i class="fa fa-search"></i> </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-0">
                            <div class="form-group">
                                <select class="js-select2 form-control" id="status-select" name="status" style="width: 100%;" data-placeholder="{{ __('back/apartment.select_status') }}">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach (config('settings.apartment_select_status') as $status)
                                        <option value="{{ $status }}" {{ $status == request()->input('status') ? 'selected' : '' }}>{{ __('back/apartment.select_' . $status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-0">
                            <div class="form-group">
                                <select class="js-select2 form-control" id="sort-select" name="sort" style="width: 100%;" data-placeholder="{{ __('back/apartment.sort') }}">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach (config('settings.apartment_select_sort') as $sort)
                                        <option value="{{ $sort }}" {{ $sort == request()->input('sort') ? 'selected' : '' }}>{{ __('back/apartment.sort_' . $sort) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <!-- All Products Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 36px;">{{ __('back/apartment.br') }}</th>
                            <th class="text-left"></th>
                            <th class="text-left">{{ __('back/apartment.nazivapartmana') }}</th>
                            <th>{{ __('back/apartment.grad') }}</th>
                            <th>{{ __('back/apartment.action') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('back/apartment.featured') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('back/apartment.status') }}</th>
                            <th class="text-right" style="width: 10%;">{{ __('back/apartment.uredi') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($apartments as $apartment)
                            <tr>
                                <td class="font-size-sm">{{ $loop->iteration }}</td>
                                <td class="text-left">
                                    <a href="{{ route('apartments.edit', ['apartman' => $apartment]) }}"> <img src="{{ asset($apartment->image) }}" style="max-height:100px" alt="{{ $apartment->title }}"></a>
                                </td>
                                <td class="font-size-sm">
                                    <a class="font-w600" href="{{ route('apartments.edit', ['apartman' => $apartment]) }}">{{ $apartment->title }}</a>
                                </td>
                                <td class="font-size-sm">
                                    {{ $apartment->city }}
                                </td>
                                <td class="font-size-sm">@include('back.layouts.partials.status', ['status' => $apartment->special, 'simple' => true])</td>
                                <td class="text-center font-size-sm">
                                    @include('back.layouts.partials.status', ['status' => $apartment->featured, 'simple' => true])
                                </td>
                                <td class="text-center font-size-sm">
                                    @include('back.layouts.partials.status', ['status' => $apartment->status, 'simple' => true])
                                </td>
                                <td class="text-right font-size-sm">
                                    <a class="btn btn-sm btn-alt-secondary" href="{{ route('apartments.edit', ['apartman' => $apartment]) }}">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn btn-sm btn-alt-danger" onclick="event.preventDefault(); deleteItem({{ $apartment->id }}, '{{ route('apartments.destroy.api') }}');"><i class="fa fa-fw fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-size-sm text-center" colspan="8">
                                    <label for="">{{ __('back/apartment.empty') }}...</label>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $apartments->links() }}
            </div>
        </div>
    </div>
@endsection

@push('js_after')

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Page JS Helpers (Magnific Popup Plugin) -->
    <script>jQuery(function(){Dashmix.helpers('magnific-popup');});</script>

    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#status-select').select2({
                placeholder: '{{ __('back/app.select_status') }}',
                allowClear: true
            });
            $('#sort-select').select2({
                placeholder: '{{ __('back/app.sort') }}',
                allowClear: true
            });

            //
            $('#status-select').on('change', (e) => {
                setURL('status', e.currentTarget.selectedOptions[0]);
            });
            $('#sort-select').on('change', (e) => {
                setURL('sort', e.currentTarget.selectedOptions[0]);
            });

            //
            let url = new URL(location.href);
            if (url.search != '') {
                $('#apartments-filter').collapse();
            }

            //
            let input = document.getElementById("search-input");

            input.addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    document.getElementById("btn-search").click();
                }
            });
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

    </script>

@endpush
