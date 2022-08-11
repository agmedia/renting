@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/app.languages.title') }}</h1>
                <button class="btn btn-hero-secondary my-2 mr-2" onclick="event.preventDefault(); openMainModal();">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> {{ __('back/app.languages.main_select') }}</span>
                </button>
                <button class="btn btn-hero-success my-2" onclick="event.preventDefault(); openModal();">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> {{ __('back/app.languages.new') }}</span>
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
                        <th style="width: 60%;">{{ __('back/app.languages.table_title') }}</th>
                        <th class="text-center">{{ __('back/app.languages.code_title') }}</th>
                        <th class="text-center">{{ __('back/app.languages.status_title') }}</th>
                        <th class="text-right">{{ __('back/layout.btn.edit') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td class="text-primary">{{ $item->title }}
                                @if (isset($item->main) && $item->main)
                                    <span class="small font-weight-bold text-info">&nbsp;({{ __('back/app.languages.main_lang') }})</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->code }}</td>
                            <td class="text-center">@include('back.layouts.partials.status', ['status' => $item->status])</td>
                            <td class="text-right font-size-sm">
                                <button class="btn btn-sm btn-alt-secondary" onclick="event.preventDefault(); openModal({{ json_encode($item) }});">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-alt-danger" onclick="event.preventDefault(); deleteCurrency({{ $item->id }});">
                                    <i class="fa fa-fw fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">{{ __('back/app.languages.empty_list') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="language-modal" tabindex="-1" role="dialog" aria-labelledby="language-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.languages.table_title') }}</h3>
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
                                    <label for="language-title">{{ __('back/app.languages.input_title') }}</label>
                                    <input type="text" class="form-control" id="language-title" name="title">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="language-code">{{ __('back/app.languages.code_title') }}</label>
                                    <input type="text" class="form-control" id="language-code" name="code">
                                </div>

                                <div class="form-group">
                                    <label class="css-control css-control-sm css-control-success css-switch res">
                                        <input type="checkbox" class="css-control-input" id="language-status" name="status">
                                        <span class="css-control-indicator"></span> {{ __('back/app.languages.status_title') }}
                                    </label>
                                </div>

                                <input type="hidden" id="language-id" name="id" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/layout.btn.discard') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); createCurrency();">
                            {{ __('back/layout.btn.save') }} <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="main-language-modal" tabindex="-1" role="dialog" aria-labelledby="main-language-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Odaberite glavnu valutu</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10 mt-3">
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="language-main-select" name="currency_main_select" style="width: 100%;" data-placeholder="Odaberite glavnu valutu">
                                        <option></option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}" {{ ((isset($main)) and ($main->id == $item->id)) ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            Odustani <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); storeMainCurrency();">
                            Snimi <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-language-modal" tabindex="-1" role="dialog" aria-labelledby="language-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Obriši valutu</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                <h4>Jeste li sigurni da želite obrisati valutu?</h4>
                                <input type="hidden" id="delete-language-id" value="0">
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
            $('#language-main-select').select2({
                minimumResultsForSearch: Infinity
            });
        });
        /**
         *
         * @param item
         * @param type
         */
        function openModal(item = {}) {
            $('#language-modal').modal('show');
            editCurrency(item);
        }

        /**
         *
         * @param item
         * @param type
         */
        function openMainModal(item = {}) {
            $('#main-language-modal').modal('show');
        }

        /**
         *
         */
        function createCurrency() {
            let item = {
                id: $('#language-id').val(),
                title: $('#language-title').val(),
                code: $('#language-code').val(),
                status: $('#language-status')[0].checked,
                main: $('#language-main')[0].checked,
            };

            axios.post("{{ route('api.languages.store') }}", { data: item })
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
        function storeMainCurrency() {
            let item = { main: $('#language-main-select').val() };

            axios.post("{{ route('api.languages.store.main') }}", { data: item })
            .then(response => {
                console.log(response.data)
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
        function deleteCurrency(id) {
            $('#delete-language-modal').modal('show');
            $('#delete-language-id').val(id);
        }

        /**
         *
         */
        function confirmDelete() {
            let item = { id: $('#delete-language-id').val() };

            axios.post("{{ route('api.languages.destroy') }}", { data: item })
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
        function editCurrency(item) {
            $('#language-id').val(item.id);
            $('#language-title').val(item.title);
            $('#language-code').val(item.code);

            if (item.status) {
                $('#language-status')[0].checked = item.status ? true : false;
            }

            if (item.main) {
                $('#language-main')[0].checked = item.main ? true : false;
            }
        }
    </script>
@endpush
