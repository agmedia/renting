@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/layout.sidebar.deposits') }}</h1>
                <button class="btn btn-hero-info my-2" onclick="event.preventDefault(); openNewDepositModal();">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1">{{ __('back/app.deposit.new') }}</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content">
        @include('back.layouts.partials.session')
        <!-- All Orders -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('back/app.deposit.list') }} <small class="font-weight-light">{{ $deposits->total() }}</small></h3>
                <div class="block-options d-none d-xl-block">
                    <div class="form-group mb-0 mr-2" style="min-width: 13rem;">
                        <select class="js-select2 form-control" id="status-select" name="status" style="width: 100%;" data-placeholder="{{ __('back/app.order.change_status') }}">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->title->{current_locale()} }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="block-options">
                    <div class="form-group mb-0">
                        <button class="btn btn-outline-primary mr-3" type="button" data-toggle="collapse" data-target="#deposits-filter" aria-expanded="false" aria-controls="deposits-filter">
                            <i class="fa fa-filter"></i> {{ __('back/layout.btn_filter') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="collapse" id="deposits-filter">
                <div class="block-content bg-body-dark">
                    <div class="form-group row items-push mb-0">
                        <div class="col-12 col-md-6 mb-0">
                            <!-- Search Form -->
                            <form action="{{ route('deposits') }}" method="GET">
                                <div class="form-group">
                                    <div class="input-group flex-nowrap">
                                        <input type="text" class="form-control py-3" name="search" id="search-input" value="{{ request()->input('search') }}" placeholder="{{ __('back/app.order.search_placeholder') }}">
                                        <button type="button" class="btn btn-outline-info fs-base" id="btn-search" onclick="setURL('search', $('#search-input').val(), true);"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <!-- END Search Form -->
                        </div>
                        <div class="col-md-2 mb-0">
                            <select class="js-select2 form-control" id="filter-origin-select" name="filter_origin" style="width: 100%;" data-placeholder="{{ __('back/app.order.origin_select') }}">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach (config('settings.order.origin') as $key => $origin)
                                    <option value="{{ $origin }}" {{ $origin == request()->input('origin') ? 'selected' : '' }}>{{ __('back/app.order.' . $origin) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-0">
                            <select class="js-select2 form-control" id="filter-status-select" name="filter_status" style="width: 100%;" data-placeholder="{{ __('back/app.order.status_select') }}">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == request()->input('status') ? 'selected' : '' }}>{{ $status->title->{current_locale()} }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-0">
                            <select class="js-select2 form-control" id="sort-select" name="sort" style="width: 100%;" data-placeholder="{{ __('back/apartment.sort') }}">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach (config('settings.order.sort') as $sort)
                                    <option value="{{ $sort }}" {{ $sort == request()->input('sort') ? 'selected' : '' }}>{{ __('back/apartment.sort_' . $sort) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-0">
                            <div class="input-group mt-2 mb-3">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input class="form-control" id="search-dates" placeholder="Search by Check-in -> Check-out" type="text" style="background-color: #f5f5f5;">
                            </div>
                        </div>
                        <div class="col-md-3 mb-0">
                            <div class="input-group mt-2 mb-3">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input class="form-control" id="from-date" placeholder="Search Check-in" type="text" style="background-color: #f5f5f5;">
                            </div>
                        </div>
                        <div class="col-md-3 mb-0">
                            <div class="input-group mt-2 mb-3">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input class="form-control" id="to-date" placeholder="Search Check-out" type="text" style="background-color: #f5f5f5;">
                            </div>
                        </div>
                        <div class="col-md-2 mb-0 mt-2 mb-3">
                            <button type="button" class="btn btn-outline-info btn-block" id="btn-clear" onclick="setURL('clear', '');"><i class="fa fa-filter"></i> Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <!-- All Orders Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter font-size-sm">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 30px;">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="checkAll" name="status">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center" style="width: 36px;">{{ __('back/layout.br') }}</th>
                            <th class="text-center">{{ __('back/app.order.title') }}</th>
                            <th class="text-center">{{ __('back/app.order.date') }}</th>
                            <th>{{ __('back/app.order.customer') }}</th>
                            <th>{{ __('back/app.order.apartment') }}</th>
                            <th>{{ __('back/app.deposit.scope') }}</th>
                            <th class="text-right">{{ __('back/app.order.amount') }}</th>
                            <th class="text-center">{{ __('back/layout.status') }}</th>
                            <th class="text-right">{{ __('back/app.order.details') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($deposits->sortByDesc('id') as $deposit)

                            <tr>
                                <td class="text-center">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $deposit->id }}" id="status[{{ $deposit->id }}]" name="status">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <strong>{{ $deposit->id }}</strong>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('orders.edit', ['order' => $deposit->order]) }}"><strong>{{ $deposit->order->id }}</strong></a>
                                </td>
                                <td class="text-center">{{ carbon($deposit->order->date_from)->format('d.m.Y') }} - {{ carbon($deposit->order->date_to)->format('d.m.Y') }}</td>
                                <td>{{ $deposit->order->payment_fname }} {{ $deposit->order->payment_lname }}</td>
                                <td>{{ $deposit->order->apartment->title }}</td>
                                @if ($deposit->scope_id)
                                    <td>{{ config('settings.deposit_scopes')[$deposit->scope_id]['title'][current_locale()] }}</td>
                                @else
                                    <td></td>
                                @endif

                                <td class="text-right">{{ currency_main($deposit->amount, true) }}</td>
                                <td class="font-size-base text-center">
                                    <span class="badge badge-pill badge-{{ $statuses->where('id', $deposit->status_id)->first()->color }}">
                                        {{ $statuses->where('id', $deposit->status_id)->first()->title->{current_locale()} }}
                                    </span>
                                </td>
                                <td class="text-right font-size-base">
                                    <button type="button" class="btn btn-sm btn-alt-info"
                                            onclick="event.preventDefault(); copyToClipboard('{{ route('checkout.special', ['signature' => $deposit->signature]) }}');"
                                            data-toggle="tooltip" data-placement="top" title="{{ __('back/app.deposit.copy_url') }}">
                                        <i class="fa fa-fw fa-copy"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center font-size-sm" colspan="10">
                                    <label>{{ __('back/app.deposit.no_deposits') }}</label>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{ $deposits->links() }}
            </div>
        </div>
        <!-- END All Orders -->
    </div>

@endsection

@include('back.sales.deposit.new-deposit-modal')

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#status-select').select2({
                placeholder: '{{ __('back/app.order.change_status') }}'
            });

            $('#filter-origin-select').select2({
                placeholder: '{{ __('back/app.order.origin_select') }}',
                allowClear: true
            });
            $('#filter-origin-select').on('change', (e) => {
                setURL('origin', e.currentTarget.selectedOptions[0]);
            });
            //
            $('#filter-status-select').select2({
                placeholder: '{{ __('back/app.order.status_select') }}',
                allowClear: true
            });
            $('#filter-status-select').on('change', (e) => {
                setURL('status', e.currentTarget.selectedOptions[0]);
            });
            //
            $('#sort-select').select2({
                placeholder: '{{ __('back/app.sort') }}',
                allowClear: true
            });
            $('#sort-select').on('change', (e) => {
                setURL('sort', e.currentTarget.selectedOptions[0]);
            });
            //
            //
            let url = new URL(location.href);
            if (url.search != '') {
                $('#deposits-filter').collapse();
            }

            $('#status-select').on('change', (e) => {
                let selected     = e.currentTarget.selectedOptions[0].value;
                let deposits       = '[';
                var checkedBoxes = document.querySelectorAll('input[name=status]:checked');

                for (let i = 0; i < checkedBoxes.length; i++) {
                    if (checkedBoxes.length - 1 == i) {
                        deposits += checkedBoxes[i].value + ']';
                    } else {
                        deposits += checkedBoxes[i].value + ','
                    }
                }

                axios.post("{{ route('api.deposit.status.change') }}", {selected: selected, deposits: deposits})
                .then(response => {
                    if (response.data.success) {
                        location.reload();
                    } else {
                        return errorToast.fire(response.data.message);
                    }
                });
            });
            //
            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });

        /**
         *
         * @param text
         * @returns {*}
         */
        function copyToClipboard(text) {
            if (window.isSecureContext) {
                navigator.clipboard.writeText(text);

                return successToast.fire('OK');
            }

            return warningToast.fire('Whoops.!!');
        }

        /**
         *
         * @param type
         * @param search
         * @param isValue
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
            });

            if (search.value) {
                params.append(type, search.value);
            }

            if (isValue && search) {
                params.append(type, search);
            }

            url.search = params;

            if (type == 'clear') {
                url.search = '';
            }

            location.href = url;
        }
    </script>

    <script>
        const reservation_dates = getReservationDates();
        const reservation_date = getReservationDate();

        const picker   = new easepick.create({
            element:     document.getElementById('search-dates'),
            css:         [
                '{{ asset('assets/css/reservation.css') }}',
            ],
            zIndex:      10,
            autoApply: true,
            plugins:     ['LockPlugin', 'RangePlugin'],
            setup(picker) {
                picker.on('select', (e) => {
                    let start = new Date(e.detail.start);
                    let start_str = start.getFullYear() + '-' + ("0"+(start.getMonth()+1)).slice(-2) + '-' + ("0"+(start.getDate())).slice(-2);
                    let end = new Date(e.detail.end);
                    let end_str = end.getFullYear() + '-' + ("0"+(end.getMonth()+1)).slice(-2) + '-' + ("0"+(end.getDate())).slice(-2);
                    let date_string = start_str + ' - ' + end_str;

                    setURL('dates', date_string, true);
                });
            },
            RangePlugin: {
                tooltipNumber(num) {
                    return num - 1;
                },
                locale: {
                    one:   'night',
                    other: 'nights',
                },
                startDate: startDate(),
                endDate: endDate()
            },
            LockPlugin:  {
                minDays:     1,
                inseparable: true
            }
        });

        const from_picker = new easepick.create({
            element: "#from-date",
            css: [
                '{{ asset('assets/css/reservation.css') }}'
            ],
            zIndex: 10,
            date: fromDate(),
            setup(from_picker) {
                from_picker.on('select', (e) => {
                    let start = new Date(e.detail.date);
                    let start_str = start.getFullYear() + '-' + ("0"+(start.getMonth()+1)).slice(-2) + '-' + ("0"+(start.getDate())).slice(-2);

                    setURL('from', start_str, true);
                });
            },
        })

        const to_picker = new easepick.create({
            element: "#to-date",
            css: [
                '{{ asset('assets/css/reservation.css') }}'
            ],
            zIndex: 10,
            date: toDate(),
            setup(to_picker) {
                to_picker.on('select', (e) => {
                    let end = new Date(e.detail.date);
                    let end_str = end.getFullYear() + '-' + ("0"+(end.getMonth()+1)).slice(-2) + '-' + ("0"+(end.getDate())).slice(-2);

                    setURL('to', end_str, true);
                });
            },
        })

        /**
         *
         */
        function getReservationDates() {
            let url = new URL(location.href);
            let params = new URLSearchParams(url.search);

            if (params.has('dates')) {
                let dates = params.get('dates').split(' - ');

                return {from: dates[0].replace('-', '/'), to: dates[1].replace('-', '/')};
            }

            return {from: '', to: ''};
        }

        /**
         *
         */
        function getReservationDate() {
            let url = new URL(location.href);
            let params = new URLSearchParams(url.search);
            let date = {from: '', to: ''};

            if (params.has('from')) {
                let from = params.get('from');

                date.from = from;
            }

            if (params.has('to')) {
                let to = params.get('to');

                date.to = to;
            }

            return date;
        }

        /**
         *
         * @returns {*}
         */
        function fromDate() {
            if (reservation_date.from != '') {
                return new Date(reservation_date.from);
            }
        }

        /**
         *
         * @returns {*}
         */
        function toDate() {
            if (reservation_date.to != '') {
                return new Date(reservation_date.to);
            }
        }

        /**
         *
         * @returns {*}
         */
        function startDate() {
            if (reservation_dates.from != '') {
                return new Date(reservation_dates.from);
            }
        }

        /**
         *
         * @returns {*}
         */
        function endDate() {
            if (reservation_dates.to != '') {
                return new Date(reservation_dates.to);
            }
        }

    </script>

@endpush
