@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/app.order.orders') }}</h1>
                <button class="btn btn-hero-info my-2" onclick="event.preventDefault(); openNewModal();">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1">{{ __('back/app.order.new') }}</span>
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
                <h3 class="block-title">{{ __('back/app.order.list') }} <small class="font-weight-light">{{ $orders->total() }}</small></h3>
                <div class="block-options d-none d-xl-block">
                    <div class="form-group mb-0 mr-2">
                        <select class="js-select2 form-control" id="status-select" name="status" style="width: 100%;" data-placeholder="{{ __('back/app.order.change_status') }}">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->title->{current_locale()} }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="block-options d-none d-xl-block">
                    <div class="form-group mb-0">
                        <button class="btn btn-outline-primary mr-3" type="button" data-toggle="collapse" data-target="#orders-filter" aria-expanded="false" aria-controls="orders-filter">
                            <i class="fa fa-filter"></i> {{ __('back/layout.btn_filter') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="collapse" id="orders-filter">
                <div class="block-content bg-body-dark">
                    <div class="form-group row items-push mb-0">
                        <div class="col-12 col-md-6 mb-0">
                            <!-- Search Form -->
                            <form action="{{ route('orders') }}" method="GET">
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
                            <th class="text-center">{{ __('back/app.order.date') }}</th>
                            <th>{{ __('back/app.order.apartment') }}</th>
                            <th>{{ __('back/app.order.customer') }}</th>
                            <th class="text-center">{{ __('back/layout.status') }}</th>
                            <th class="text-right">{{ __('back/app.order.details') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($orders->sortByDesc('id') as $order)
                            <tr>
                                <td class="text-center">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $order->id }}" id="status[{{ $order->id }}]" name="status">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <strong>{{ $order->id }}</strong>
                                </td>
                                <td class="text-center">{{ carbon($order->date_from)->format('d.m.Y') }} - {{ carbon($order->date_to)->format('d.m.Y') }}</td>
                                <td>{{ $order->apartment->title }}</td>
                                <td>{{ $order->payment_fname }} {{ $order->payment_lname }}</td>
                                <td class="font-size-base text-center">
                                    <span class="badge badge-pill badge-{{ $statuses->where('id', $order->order_status_id)->first()->color }}">
                                        {{ $statuses->where('id', $order->order_status_id)->first()->title->{current_locale()} }}
                                    </span>
                                </td>
                                <td class="text-right font-size-base">
                                    <a class="btn btn-sm btn-alt-info" href="{{ route('orders.edit', ['order' => $order]) }}">
                                        <i class="fa fa-fw fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center font-size-sm" colspan="7">
                                    <label>{{ __('back/app.order.no_orders') }}</label>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{ $orders->links() }}
            </div>
        </div>
        <!-- END All Orders -->
    </div>

@endsection

@include('back.sales.order.new-order-modal')

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
                $('#orders-filter').collapse();
            }
            //
            //
            $('#status-select').on('change', (e) => {
                let selected = e.currentTarget.selectedOptions[0].value;
                let orders = '[';
                var checkedBoxes = document.querySelectorAll('input[name=status]:checked');

                for (let i = 0; i < checkedBoxes.length; i++) {
                    if (checkedBoxes.length - 1 == i) {
                        orders += checkedBoxes[i].value + ']';
                    } else {
                        orders += checkedBoxes[i].value + ','
                    }
                }

                axios.post("{{ route('api.order.status.change') }}", { selected: selected, orders: orders })
                .then(response => {
                    if (response.status == 200) {
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
            //
            //

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
                return new DateTime(reservation_date.from, 'YYYY-MM-DD');
            }
        }

        /**
         *
         * @returns {*}
         */
        function toDate() {
            if (reservation_date.to != '') {
                return new DateTime(reservation_date.to, 'YYYY-MM-DD');
            }
        }

        /**
         *
         * @returns {*}
         */
        function startDate() {
            if (reservation_dates.from != '') {
                return new DateTime(reservation_dates.from, 'YYYY-MM-DD');
            }
        }

        /**
         *
         * @returns {*}
         */
        function endDate() {
            if (reservation_dates.to != '') {
                return new DateTime(reservation_dates.to, 'YYYY-MM-DD');
            }
        }

    </script>

@endpush
