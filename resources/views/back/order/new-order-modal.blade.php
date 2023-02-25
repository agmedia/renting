@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
@endpush

@push('modals')
    <div class="modal fade" id="new-modal" tabindex="-1" role="dialog" aria-labelledby="new-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Create New Order</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-11 mt-3">
                                <div class="form-group row items-push mb-0">
                                    <div class="col-md-12 mb-3">
                                        <select class="js-select2 form-control" id="apartment-select" style="width: 100%;" data-placeholder="To apartment...">
                                            <option></option>
                                            @foreach ($apartments as $apartment)
                                                <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-5">
                                        <h2 class="content-heading">{{ __('back/app.order.date') }} @include('back.layouts.partials.required-star')</h2>
                                        <div class="input-group mt-2 mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                            <input class="form-control" id="checkindate" name="dates" placeholder="Check-in -> Checkout" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <h2 class="content-heading">{{ __('back/app.order.select_payments') }} @include('back.layouts.partials.required-star')</h2>
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <select class="js-select2 form-control" id="payment-select" name="payment_type" style="width: 100%;" data-placeholder="{{ __('back/app.order.payments') }}">
                                                    <option></option>
                                                    @foreach ($payments as $payment)
                                                        <option value="{{ $payment->code }}" {{ ((isset($order)) and ($order->payment_code == $payment->code)) ? 'selected' : '' }}>{{ $payment->title->{current_locale()} }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
<!--                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="payment-amount-input" name="payment_amount" placeholder="120" value="{{ old('payment_amount') }}">
                                            </div>-->
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <h2 class="content-heading mb-0 pt-1">{{ __('back/app.order.customer') }}</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="fname-input">{{ __('back/app.order.name') }} @include('back.layouts.partials.required-star')</label>
                                        <input type="text" class="form-control" id="fname-input" name="firstname" placeholder="{{ __('back/app.order.name') }}" value="{{ old('fname') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lname-input">{{ __('back/app.order.lastname') }} @include('back.layouts.partials.required-star')</label>
                                        <input type="text" class="form-control" id="lname-input" name="lastname" placeholder="{{ __('back/app.order.lastname') }}" value="{{ old('lname') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email-input">{{ __('back/app.order.email') }} @include('back.layouts.partials.required-star')</label>
                                        <input type="text" class="form-control" id="email-input" name="email" placeholder="{{ __('back/app.order.email') }}" value="{{ old('email') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone-input">{{ __('back/app.order.phone') }}</label>
                                        <input type="text" class="form-control" id="phone-input" name="phone" placeholder="{{ __('back/app.order.phone') }}" value="{{ old('phone') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="adults-input">{{ __('back/app.order.adults') }} @include('back.layouts.partials.required-star')</label>
                                        <input type="text" class="form-control" id="adults-input" name="adults" placeholder="{{ __('back/app.order.adults') }}" value="{{ old('adults') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="children-input">{{ __('back/app.order.children') }}</label>
                                        <input type="text" class="form-control" id="children-input" name="children" placeholder="{{ __('back/app.order.children') }}" value="{{ old('children') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="babies-input">{{ __('back/app.order.babies') }}</label>
                                        <input type="text" class="form-control" id="babies-input" name="babies" placeholder="{{ __('back/app.order.babies') }}" value="{{ old('babies') }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/app.currency.cancel') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); createNewOrder();">
                            {{ __('back/app.currency.save') }} <i class="fa fa-arrow-right ml-2"></i>
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
            $('#apartment-select').select2({});
            $('#payment-select').select2({});
        })
    </script>

    <script>
        const DateTime = easepick.DateTime;

        const pickerres = new easepick.create({
            element:     document.getElementById('checkindate'),
            css:         ['{{ config('app.url') }}assets/css/reservation.css',],
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
            }
        });
    </script>

    <script>

        /**
         *
         * @param item
         */
        function openNewModal(item = {}) {
            $('#new-modal').modal('show');
        }

        /**
         *
         */
        function createNewOrder() {
            let item = {
                apartment_id:   $('#apartment-select').val(),
                dates:          $('#checkindate')[0].value,
                payment_type:   $('#payment-select').val(),
                payment_amount: $('#payment-amount-input').val(),
                firstname:      $('#fname-input').val(),
                lastname:       $('#lname-input').val(),
                email:          $('#email-input').val(),
                phone:          $('#phone-input').val(),
                adults:         $('#adults-input').val(),
                children:       $('#children-input').val(),
                babies:         $('#babies-input').val(),
            };

            axios.post("{{ route('api.order.new') }}", item)
            .then(response => {
                if (response.data.success) {
                    $('#new-modal').modal('hide');

                    location.reload();
                } else {
                    return errorToast.fire(response.data.message);
                }
            });
        }
    </script>

@endpush