@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Widgets
            <small>
                <span class="pl-2">({{ $groups->total() }})</span>
                <span class="float-right">
                    <a href="{{ route('widget.group.create') }}" class="btn btn-sm btn-secondary ml-2" data-toggle="tooltip" title="Novi Widget">
                        <i class="si si-plus"></i> Nova Widget Grupa
                    </a>
                    <button type="button" class="btn btn-sm btn-secondary ml-2" data-toggle="modal" data-target="#modal-block-popout"><i class="si si-plus"></i> Novi Widget</button>
                </span>
            </small>
        </h2>


        <div class="row no-gutters flex-md-10-auto">
            <div class="col-md-12 order-md-0 bg-body-dark">
                <!-- Main Content -->
                <div class="content content-full">
                @include('back.layouts.partials.session')

                    <div id="accordion_q1" class="collapse show" role="tabpanel" aria-labelledby="accordion_h1" data-parent="#accordion">
                        <div class="block-content">

                            @forelse($groups as $group)
                                <div class="block block-rounded mb-2 animated fadeIn">
                                    <table class="table table-borderless bg-body table-vcenter mb-0">
                                        <tr>
                                            <td class="js-task-content font-w600 pl-3">
                                                {{ $group->title }}<br>
                                                <small class="text-gray-dark">++{{ $group->slug }}++ / ++{{ $group->id }}++</small>
                                            </td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <a href="{{ route('widget.group.edit', ['widget' => $group]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                @if ($group->widgets)
                                    @foreach($group->widgets()->get() as $widget)
                                        <div class="block block-rounded mb-2 ml-3 animated fadeIn" style="border: 1px solid #eaeaea">
                                            <table class="table table-borderless table-vcenter mb-0">
                                                <tr>
                                                    <td class="js-task-content font-w600 pl-3">
                                                        {{ $widget->title }}
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="btn-group">
                                                            <a href="{{ route('widget.edit', ['widget' => $widget]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                                                <i class="fa fa-pencil-alt"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    @endforeach
                                @endif
                            @empty
                                <h3>Widgeti su prazni. Napravite <a href="#" data-toggle="modal" data-target="#modal-block-popout">novi.</a></h3>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Pop Out Block Modal -->
    <div class="modal fade" id="modal-block-popout" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <form action="{{ route('widget.create') }}" method="get" enctype="multipart/form-data">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Odaberi Grupu Widgeta</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content mb-3">
                            <div class="form-group">
                                <label for="subtitle-input">Grupa widgeta</label>
                                <select class="js-select2 form-control" id="group-select" name="group" style="width: 100%;">
                                    <option></option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right bg-light">
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Poništi</button>
                            <button type="submit" class="btn btn-sm btn-primary">Nastavi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('#group-select').select2({
            placeholder: 'Odaberite grupu..'
        });

        /**
         *
         * @param type
         * @param search
         */
        function setURL(type, search) {
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

            url.search = params;
            location.href = url;
        }

        /**
         *
         * @param item
         */
        function shouldDeleteItem(item) {
            console.log(item)

            confirmPopUp.fire({
                title: 'Jeste li sigurni!?',
                text: 'Potvrdi brisanje ' + item.name,
                type: 'warning',
                confirmButtonText: 'Da, obriši!',
            }).then((result) => {
                if (result.value) {
                    deleteItem(item)
                }
            })
        }

        /**
         *
         * @param item
         */
        function deleteItem(item) {
            axios.post("{{ route('widget.destroy') }}", {data: item})
            .then(r => {
                if (r.data) {
                    location.reload()
                }
            })
            .catch(e => {
                errorToast.fire({
                    text: e,
                })
            })
        }
    </script>

@endpush
