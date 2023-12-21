@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                @if (isset($order))
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/app.order.edit') }} <small class="font-weight-light">#_</small><strong>{{ $order->id }}</strong></h1>
                    <h4 class="mb-1"><span class="badge badge-pill badge-{{ $order->status->color }}">{{ $order->status->title->{current_locale()} }} {{ __('back/app.order.title') }}</span></h4>
                    <button class="btn btn-hero-info my-2 ml-4" onclick="event.preventDefault(); openNewDepositModal();">
                        <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1">{{ __('back/app.deposit.new') }}</span>
                    </button>
                @else
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/app.order.new') }}</h1>
                @endif
            </div>
        </div>
    </div>


    <!-- Page Content -->
    <div class="content">
        @include('back.layouts.partials.session')

        <form action="{{ isset($order) ? route('orders.update', ['order' => $order]) : route('orders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($order))
                {{ method_field('PATCH') }}
            @endif

            <!-- Products -->
            <div class="row">
                <div class="col-sm-7">
                    <div class="block block-rounded" id="ag-order-products-app">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.order.info') }}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center push">
                                <div class="col-md-5">
                                    <img class="img-thumbnail" src="{{ asset($order->apartment->image) }}" alt="">
                                    <!--                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <select class="js-select2 form-control" id="apartment-select" name="apartment_id" style="width: 100%;" data-placeholder="Odaberite drugi apartman...">
                                                <option></option>
                                                @foreach ($apartments as $apartment)
                                        <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>


                                    @endforeach
                                    </select>
                                </div>
                            </div>-->
                                </div>
                                <div class="col-md-7">
                                    <h3 class="mb-0">{{ $order->apartment->title }}</h3>
                                    <p>
                                        {{ $order->apartment->address }}, {{ $order->apartment->city }}
                                    </p>

                                    <table class="table-borderless" style="width: 100%;">
                                        <tr>
                                            <td class="font-weight-bold" style="width: 30%;">{{ __('back/app.order.customer') }}:<br><br><br><br></td>
                                            <td>{{ $order->payment_fname }} {{ $order->payment_lname }}<br>
                                                {{ $order->payment_email }}<br>
                                                {{ $order->payment_phone }}<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('back/app.order.persons') }}:</td>
                                            <td>{{ $order->checkout['adults'] }} {{ __('back/app.order.adults') }},<br>
                                                {{ $order->checkout['children'] }} {{ __('back/app.order.children') }}
                                                @if (isset($order->checkout['babies']))
                                                    <br>{{ $order->checkout['babies'] }} {{ __('back/app.order.babies') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Dani:<br><br></td>
                                            <td>{{ $order->checkout['regular_days'] }} {{ __('back/app.order.regular_days') }}, {{ $order->checkout['weekends'] }} {{ __('back/app.order.weekends') }}<br><br></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('back/app.order.date') }}:<br><br><br></td>
                                            <td>{{ \Illuminate\Support\Carbon::make($order->date_from)->format('d.m.Y') }} – {{ \Illuminate\Support\Carbon::make($order->date_to)->format('d.m.Y') }}<br><br><br></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold" colspan="2">{{ __('back/app.order.change_date') }}:<br>
                                                <div class="input-group mt-2 mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                    <input class="form-control" id="checkindate" name="dates" placeholder="Check-in -> Checkout" type="text">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <!-- Billing Address -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.order.customer') }}</h3>
                            <div class="block-options">
                                @if (isset($order) && $order->user_id)
                                    <span class="small text-gray mr-3">{{ __('back/app.order.customer_registered') }}</span><i class="fa fa-user text-success"></i>
                                @else
                                    <span class="small font-weight-light mr-3">{{ __('back/app.order.customer_not_registered') }}</span><i class="fa fa-user text-danger-light"></i>
                                @endif
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center push">
                                <div class="col-md-11">
                                    <div class="form-group row items-push mb-0">
                                        <div class="col-md-6">
                                            <label for="fname-input">{{ __('back/app.order.name') }} @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control" id="fname-input" name="firstname" placeholder="{{ __('back/app.order.name') }}" value="{{ isset($order) ? $order->payment_fname : old('fname') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lname-input">{{ __('back/app.order.lastname') }} @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control" id="lname-input" name="lastname" placeholder="{{ __('back/app.order.lastname') }}" value="{{ isset($order) ? $order->payment_lname : old('lname') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email-input">{{ __('back/app.order.email') }} @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control" id="email-input" name="email" placeholder="{{ __('back/app.order.email') }}" value="{{ isset($order) ? $order->payment_email : old('email') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone-input">{{ __('back/app.order.phone') }} @include('back.layouts.partials.required-star')</label>
                                            <input type="text" class="form-control" id="phone-input" name="phone" placeholder="{{ __('back/app.order.phone') }}" value="{{ isset($order) ? $order->payment_phone : old('phone') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="adults-input">{{ __('back/app.order.adults') }} <small>({{ $order->apartment->max_adults }})</small></label>
                                            <input type="number" class="form-control" id="adults-input" name="adults" value="{{ isset($order) ? $order->checkout['adults'] : old('adults') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="children-input">{{ __('back/app.order.children') }} <small>({{ $order->apartment->max_children }})</small></label>
                                            <input type="number" class="form-control" id="children-input" name="children" value="{{ isset($order) ? $order->checkout['children'] : old('children') }}">
                                        </div>
                                        @if (isset($order->checkout['babies']))
                                            <div class="col-md-4">
                                                <label for="babies-input">{{ __('back/app.order.babies') }}</label>
                                                <input type="number" class="form-control" id="babies-input" name="babies" value="{{ isset($order) ? $order->checkout['babies'] : old('babies') }}">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payments -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.payments.title') }}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row mb-5 mt-2">
                                <div class="col-md-12">
                                    <label for="payment-select">{{ __('back/app.order.payments') }}</label>
                                    <select class="js-select2 form-control" id="payment-select" name="payment_type" style="width: 100%;" data-placeholder="{{ __('back/app.order.select_payments') }}">
                                        <option></option>
                                        @foreach ($payments as $payment)
                                            <option value="{{ $payment->code }}" {{ ((isset($order)) and ($order->payment_code == $payment->code)) ? 'selected' : '' }}>{{ $payment->title->{current_locale()} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--                                <div class="col-md-4">
                                    <label for="payment-amount-input">{{ __('back/app.order.amount') }}</label>
                                    <input type="text" class="form-control" id="payment-amount-input" name="payment_amount" placeholder="Upišite iznos" value="{{ isset($order) ? $order->total : old('payment_amount') }}">
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="block block-rounded" id="ag-order-products-app">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.order.items_title') }}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center push">
                                <div class="col-md-11">
                                    <table class="table" style="width: 100%;">
                                        @foreach ($order->checkout['total']['items'] as $item)
                                            <!-- Items -->
                                            @if ($item['code'] != 'additional_options')
                                                <tr style="height: 36px;">
                                                    <td style="width: 4%;"></td>
                                                    <td>{{ $item['price_text'] }} * {{ $item['count'] }} {!! $item['title'] !!}</td>
                                                    <td class="text-right">{{ $item['total_text'] }}</td>
                                                </tr>
                                            @endif
                                            @if ($item['code'] == 'additional_options')
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" checked="checked" name="options_{{ isset($item['id']) ? $item['id'] : '0' }}">
                                                    </td>
                                                    <td>{{ $item['price_text'] }} * {{ $item['count'] }} {{ $item['title'] }}</td>
                                                    <td class="text-right">{{ (is_string($item['total_text']) ? $item['total_text'] : '') }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <!-- Total -->
                                        @foreach ($order->checkout['total']['total'] as $item)
                                            <tr style="height: 36px;">
                                                <td colspan="2" class="text-right pr-3">{!! $item['title'] !!}</td>
                                                <td class="text-right">{{ $item['total_text'] }}</td>
                                            </tr>
                                        @endforeach
                                        <!-- Deposit -->
                                        @if (isset($order->checkout['forced_paid_amount']) && $order->checkout['forced_paid_amount'])
                                            <tr style="height: 36px;">
                                                <td colspan="2" class="text-danger text-right pr-3">{{ __('back/app.order.paid_amount') }} - {{ number_format($order->checkout['paid_percentage'], 1) }} %</td>
                                                <td class="text-danger text-right">{{ currency_main($order->checkout['forced_paid_amount'], true) }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.order.payment_url') }}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center push mb-3">
                                <div class="col-md-4">
                                    <h4 class="mb-1">{{ __('back/app.order.amount') }}: {{ currency_main($order->total, true) }}</h4>
                                    <p>
                                        {{ __('back/app.order.payments') }}: {{ $payments->where('code', $order->payment_code)->first()->title->{current_locale()} }}<br>
                                    </p>
                                </div>
                                <div class="col-md-1 text-right">
                                    <button type="button" class="btn btn-icon"
                                            data-toggle="tooltip" data-placement="top" title="Copy"
                                            onclick="event.preventDefault(); copyToClipboard('order-url-{{ $order->id }}');">
                                        <i class="fa fa-copy fa-2x ml-1 text-info-light"></i>
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <p class="font-size-sm" id="order-url-{{ $order->id }}">
                                        {{ route('checkout.special', ['signature' => $order->hash]) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (isset($order) && $order->deposits->count())
                <div class="row">
                    <div class="col-sm-12">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">{{ __('back/app.deposit.title') }}</h3>
                                <div class="block-options">
                                    <button class="btn btn-sm btn-info" onclick="event.preventDefault(); openNewDepositModal();">
                                        <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1">{{ __('back/app.deposit.new') }}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">
                                @foreach ($order->deposits as $deposit)
                                    <div class="row justify-content-center push mb-3">
                                        <div class="col-md-4">
                                            <h4 class="mb-1">{{ __('back/app.order.amount') }}: {{ currency_main($deposit->amount, true) }}</h4>
                                            <p>
                                                {{ __('back/app.order.payments') }}: {{ $payments->where('code', $deposit->payment_code)->first()->title->{current_locale()} }}<br>
                                                {{ __('back/app.order.comment') }}: {!! $deposit->comment !!}<br>
                                                {{ __('back/app.deposit.scope') }}: <strong>{{ config('settings.deposit_scopes')[$deposit->scope_id]['title'][current_locale()] }}</strong><br>
                                            </p>
                                        </div>
                                        <div class="col-md-1 text-right">
                                            <button type="button" class="btn btn-icon"
                                                    data-toggle="tooltip" data-placement="top" title="Copy"
                                                    onclick="event.preventDefault(); copyToClipboard('deposit-url-{{ $deposit->id }}');">
                                                <i class="fa fa-copy fa-2x ml-1 text-info-light"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="font-size-sm" id="deposit-url-{{ $deposit->id }}">
                                                {{ route('checkout.special', ['signature' => $deposit->signature]) }}
                                            </p>
                                            <p class="mb-1"><span class="badge badge-pill badge-{{ $deposit->status->color }}">{{ $deposit->status->title->{current_locale()} }}</span></p>
                                        </div>
                                        <div class="col-md-11">
                                            <hr>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- History Messages -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('back/app.order.history') }}</h3>
                    <div class="block-options">
                        <div class="dropdown">
                            <button type="button" class="btn btn-alt-secondary" id="btn-add-comment">
                                {{ __('back/app.order.add_comment') }}
                            </button>
                            <button type="button" class="btn btn-light" id="dropdown-ecom-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('back/app.order.change_status') }}
                                <i class="fa fa-angle-down ml-1"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-ecom-filters">
                                @foreach ($statuses as $status)
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:setStatus({{ $status->id }});">
                                        <span class="badge badge-pill badge-{{ $status->color }}">{{ $status->title->{current_locale()} }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block-content">
                    <table class="table table-borderless table-striped table-vcenter font-size-sm">
                        <tbody>
                        @foreach ($order->history as $record)
                            <tr>
                                <td class="font-size-base">
                                    @if ($record->status)
                                        <span class="badge badge-pill badge-{{ $record->status->color }}">{{ $record->status->title->{current_locale()} }}</span>
                                    @else
                                        <small>{{ __('back/app.order.comment') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="font-w600">{{ \Illuminate\Support\Carbon::make($record->created_at)->locale(current_locale(true))->diffForHumans() }}</span> /
                                    <span class="font-weight-light">{{ \Illuminate\Support\Carbon::make($record->created_at)->format('d.m.Y - h:i') }}</span>
                                </td>
                                <td>
                                    <a href="javascript:void(0)">{{ $record->user ? $record->user->name : $record->order->payment_fname . ' ' . $record->order->payment_lname }}</a>
                                </td>
                                <td>{{ $record->comment }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="block">
                <div class="block-content">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-hero-success mb-3">
                                <i class="fas fa-save mr-1"></i> {{ __('back/layout.btn.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <!-- END Page Content -->

@endsection

@if (isset($order))
    @include('back.sales.deposit.new-deposit-modal')
@endif

@push('modals')
    <div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-labelledby="comment--modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.order.add_comment') }}</h3>
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
                                    <label for="status-select">{{ __('back/app.order.change_status') }}</label>
                                    <select class="js-select2 form-control" id="status-select" name="status" style="width: 100%;" data-placeholder="{{ __('back/app.order.change_status') }}..">
                                        <option value="0">{{ __('back/app.order.no_change_status') }}...</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->title->{current_locale()} }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="comment-input">{{ __('back/app.order.comment') }}</label>
                                    <textarea class="form-control" name="comment" id="comment-input" rows="7"></textarea>
                                </div>

                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/layout.btn.discard') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); changeStatus();">
                            {{ __('back/layout.btn.save') }} <i class="fa fa-arrow-right ml-2"></i>
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
            $('#payment-select').select2({});
            $('#apartment-select').select2({});
            $('#status-select').select2({});

            $('#btn-add-comment').on('click', () => {
                $('#comment-modal').modal('show');
                $('#status-select').val(0);
                $('#status-select').trigger('change');
            });
        })

        /**
         *
         * @param status
         */
        function setStatus(status) {
            $('#comment-modal').modal('show');
            $('#status-select').val(status);
            $('#status-select').trigger('change');
        }

        /**
         *
         * @param tag_id
         * @returns {*}
         */
        function copyToClipboard(tag_id = 'url-input') {
            let text = document.getElementById(tag_id);

            if (window.isSecureContext) {
                navigator.clipboard.writeText(text.innerText)

                return successToast.fire('OK');
            }

            return warningToast.fire('Whoops.!!');
        }

        /**
         *
         */
        function changeStatus() {
            let item = {
                order_id: {{ $order->id }},
                comment:  $('#comment-input').val(),
                status:   $('#status-select').val()
            };

            axios.post("{{ route('api.order.status.change') }}", item)
            .then(response => {
                console.log(response.data)
                if (response.data.message) {
                    $('#comment-modal').modal('hide');

                    successToast.fire({
                        timer: 1500,
                        text:  response.data.message,
                    }).then(() => {
                        location.reload();
                    })

                } else {
                    return errorToast.fire(response.data.error);
                }
            });
        }
    </script>


    <script>
        const DateTime    = easepick.DateTime;
        const bookedDates = {!! collect($order->apartment->dates())->toJson() !!}
        .map(d => {
            if (d instanceof Array) {
                const start = new DateTime(d[0], 'YYYY-MM-DD');
                const end   = new DateTime(d[1], 'YYYY-MM-DD');

                return [start, end];
            }

            return new DateTime(d, 'YYYY-MM-DD');
        });
        const pickerres   = new easepick.create({
            element:     document.getElementById('checkindate'),
            css:         [
                '{{ config('app.url') }}assets/css/reservation.css',
            ],
            grid:        1,
            calendars:   1,
            zIndex:      10,
            plugins:     ['LockPlugin', 'RangePlugin'],
            RangePlugin: {
                tooltipNumber(num) {
                    return num - 1;
                },
                locale: {
                    one:   'night',
                    other: 'nights',
                },
            },
            LockPlugin:  {
                minDate:     new Date(),
                minDays:     2,
                inseparable: true,
                filter(date, picked) {
                    if (picked.length === 1) {
                        const incl = date.isBefore(picked[0]) ? '[)' : '(]';
                        return !picked[0].isSame(date, 'day') && date.inArray(bookedDates, incl);
                    }

                    return date.inArray(bookedDates, '[)');
                },
            }
        });
    </script>

@endpush
