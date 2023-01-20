@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/settings.amenities.title') }}</h1>
                <button class="btn btn-hero-success my-2" onclick="event.preventDefault(); openModal();">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> {{ __('back/settings.amenities.new') }}</span>
                </button>
            </div>
        </div>
    </div>

    <div class="content content-full">
        @include('back.layouts.partials.session')

        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('back/layout.list') }}</h3>
            </div>
            <div class="block-content">
                <table class="table table-striped table-borderless table-vcenter">
                    <thead class="thead-light">
                    <tr>
                        <th style="width: 5%;">{{ __('back/layout.br') }}</th>
                        <th style="width: 45%;">{{ __('back/settings.amenities.table_title') }}</th>
                        <th>{{ __('back/settings.amenities.group_title') }}</th>
                        <th class="text-center">{{ __('back/settings.amenities.icon_title') }}</th>
                        <th class="text-center">{{ __('back/apartment.featured') }}</th>
                        <th style="width: 10%;" class="text-right">{{ __('back/layout.btn.edit') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td class="text-primary">{{ $item->title->{current_locale()} }}</td>
                            <td>{{ $item->group_title->{current_locale()} }}</td>
                            <td class="text-center"><img src="{{ asset('media/icons') }}/{{ $item->icon }}" class="icon"/></td>
                            <td class="text-center font-size-sm">
                                @include('back.layouts.partials.status', ['status' => $item->featured, 'simple' => true])
                            </td>
                            <td class="text-right font-size-sm">
                                <button class="btn btn-sm btn-alt-secondary" onclick="event.preventDefault(); openModal({{ json_encode($item) }});">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-alt-danger" onclick="event.preventDefault(); deleteItem({{ $item->id }});">
                                    <i class="fa fa-fw fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">{{ __('back/settings.amenities.empty_list') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="amenity-modal" tabindex="-1" role="dialog" aria-labelledby="amenity-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/settings.amenities.table_title') }}</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                <div class="form-group mb-4">
                                    <label for="amenity-title" class="w-100">{{ __('back/settings.amenities.input_title') }} <span class="text-danger">*</span>
                                        <ul class="nav nav-pills float-right">
                                            @foreach(ag_lang() as $lang)
                                                <li @if (current_locale() == $lang->code) class="active" @endif>
                                                    <a class="btn btn-sm btn-outline-secondary ml-2 @if (current_locale() == $lang->code) active @endif " data-toggle="pill" href="#{{ $lang->code }}">
                                                        <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </label>

                                    <div class="tab-content">
                                        @foreach(ag_lang() as $lang)
                                            <div id="{{ $lang->code }}" class="tab-pane @if (current_locale() == $lang->code) active @endif">
                                                <input type="text" class="form-control" id="amenity-title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="">
                                                @error('title')
                                                <span class="text-danger font-italic">Greška. Niste unijeli naslov.</span>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                <div class="form-group mb-4">
                                    <label for="group-select">{{ __('back/settings.amenities.group_title') }}</label>
                                    <select class="js-select2 form-control" id="group-select" name="group" style="width: 100%;" data-placeholder="{{ __('back/apartment.select') }}">
                                        <option></option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group['id'] }}">{{ $group['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="icon">{{ __('back/settings.amenities.icon_title') }}</label>
                                    <input type="text" class="form-control" id="icon" name="icon">
                                </div>

                                <div class="row">
                                    @foreach ($icons as $icon)
                                        <div class="col-md-2 my-1 mb-2">
                                            <button type="button" onclick="event.preventDefault(); selectIcon('{{ $icon }}');">
                                                <img src="{{ asset('media/icons') }}/{{ $icon }}" class="icon"/>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group mt-3">
                                    <label class="css-control css-control-sm css-control-success css-switch res">
                                        <input type="checkbox" class="css-control-input" id="featured" name="featured">
                                        <span class="css-control-indicator"></span> {{ __('back/apartment.featured') }}
                                    </label>
                                </div>

                                <input type="hidden" id="amenity-id" name="id" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/layout.btn.discard') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); createItem();">
                            {{ __('back/layout.btn.save') }} <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-amenity-modal" tabindex="-1" role="dialog" aria-labelledby="amenity-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Obriši pogodnost</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                <h4>Jeste li sigurni da želite obrisati pogodnost?<br>Pogodnost se briše i sa apartmana koji je imaju.</h4>
                                <input type="hidden" id="delete-amenity-id" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            Odustani <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirmDelete();">
                            Obriši <i class="fa fa-trash-alt ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#group-select').select2();
        });
        /**
         *
         * @param item
         * @param type
         */
        function openModal(item = {}) {
            $('#amenity-modal').modal('show');

            if (Object.keys(item).length !== 0) {
                editItem(item);
            }
        }


        function selectIcon(icon) {
            $('#icon').val(icon);
        }

        /**
         *
         */
        function createItem() {
            let values = {};

            {!! ag_lang() !!}.forEach(function(item) {
                values[item.code] = document.getElementById('amenity-title-' + item.code).value;
            });

            let item = {
                id: $('#amenity-id').val(),
                title: values,
                group: $('#group-select').val(),
                icon: $('#icon').val(),
                featured: $('#featured')[0].checked,
            };

            axios.post("{{ route('api.amenities.store') }}", { data: item })
            .then(response => {
                if (response.data.success) {
                    location.reload();
                } else {
                    return errorToast.fire(response.data.message);
                }
            });
        }

        /**
         *
         */
        function deleteItem(id) {
            $('#delete-amenity-modal').modal('show');
            $('#delete-amenity-id').val(id);
        }

        /**
         *
         */
        function confirmDelete() {
            let item = { id: $('#delete-amenity-id').val() };

            axios.post("{{ route('api.amenities.destroy') }}", { data: item })
            .then(response => {
                if (response.data.success) {
                    location.reload();
                } else {
                    return errorToast.fire(response.data.message);
                }
            });
        }

        /**
         *
         * @param item
         */
        function editItem(item) {
            $('#amenity-id').val(item.id);
            $('#icon').val(item.icon);
            $('#group-select').val(item.group).trigger('change');

            Object.keys(item.title).forEach((key) => {
                $('#amenity-title-' + key).val(item.title[key]);
            });

            if (item.featured) {
                $('#featured')[0].checked = item.featured ? true : false;
            }
        }
    </script>
@endpush
