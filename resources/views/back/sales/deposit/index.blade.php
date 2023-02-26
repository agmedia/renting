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
                    <div class="dropdown">
                        <button type="button" class="btn btn-light" id="dropdown-ecom-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('back/app.order.filter') }}
                            @if (request()->has('status'))
                                {{ $statuses->where('id', request()->query('status'))->first()->title->{current_locale()} }}
                            @endif
                            <i class="fa fa-angle-down ml-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-ecom-filters">
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:setURL('status', 0)">{{ __('back/app.order.all') }}</a>
                            @foreach ($statuses as $status)
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:setURL('status', {{ $status->id }})">
                                    <span class="badge badge-pill badge-{{ $status->color }}">{{ $status->title->{current_locale()} }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content bg-body-dark">
                <!-- Search Form -->
                <form action="{{ route('deposits') }}" method="GET">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control py-3 text-center" name="search" id="search-input" value="{{ request()->input('search') }}" placeholder="{{ __('back/app.order.search_placeholder') }}">
                                <button type="submit" class="btn btn-primary fs-base" onclick="setURL('search', $('#search-input').val());"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END Search Form -->
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
                            <th>{{ __('back/app.payments.title') }}</th>
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
                                <td class="text-center">{{ \Illuminate\Support\Carbon::make($deposit->created_at)->format('d.m.Y') }}</td>
                                <td>{{ $deposit->order->payment_fname }} {{ $deposit->order->payment_lname }}</td>
                                <td>{{ $deposit->payment_method }}</td>
                                <td>{{ config('settings.deposit_scopes')[$deposit->scope_id]['title'][current_locale()] }}</td>
                                <td class="text-right">{{ currency_main($deposit->amount, true) }}</td>
                                <td class="font-size-base text-center">
                                    <span class="badge badge-pill badge-{{ $deposit->status->color }}">{{ $deposit->status->title->{current_locale()} }}</span>
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
         */
        function setURL(type, search) {
            let url    = new URL(location.href);
            let params = new URLSearchParams(url.search);
            let keys   = [];

            for (var key of params.keys()) {
                if (key === type) {
                    keys.push(key);
                }
            }

            keys.forEach((value) => {
                if (params.has(value) || search == 0) {
                    params.delete(value);
                }
            })

            if (search) {
                params.append(type, search);
            }

            url.search    = params;
            location.href = url;
        }
    </script>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endpush
