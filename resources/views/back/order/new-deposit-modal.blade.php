@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
@endpush

@push('modals')
    <div class="modal fade" id="new-deposit-modal" tabindex="-1" role="dialog" aria-labelledby="new-deposit-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Create New Deposit</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-11">
                                <div class="form-group row items-push mb-0">
                                    <div class="col-md-12">
                                        <h2 class="content-heading">{{ __('back/app.order.select_payments') }} & {{ __('back/app.order.amount') }} @include('back.layouts.partials.required-star')</h2>
                                        <div class="row mb-4">
                                            <div class="col-md-8">
                                                <select class="js-select2 form-control" id="payment-deposit-select" name="payment_deposit_type" style="width: 100%;" data-placeholder="{{ __('back/app.order.payments') }}">
                                                    <option></option>
                                                    @foreach ($payments as $payment)
                                                        <option value="{{ $payment->code }}" {{ ((isset($order)) and ($order->payment_code == $payment->code)) ? 'selected' : '' }}>{{ $payment->title->{current_locale()} }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="payment-deposit-amount-input" name="payment_deposit_amount" placeholder="120" value="{{ old('payment_amount') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="fname-input">Comment</label>
                                        <textarea id="comment-textarea" class="form-control" name="deposit_comment" placeholder="Add comment to deposit payment..."></textarea>
                                    </div>
                                    <input type="hidden" id="order-id-input" value="{{ $order->id }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/app.currency.cancel') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); createNewOrderDeposit();">
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
            $('#payment-deposit-select').select2({});
        })
    </script>

    <script>

        /**
         *
         * @param item
         */
        function openNewDepositModal(item = {}) {
            $('#new-deposit-modal').modal('show');
        }

        /**
         *
         */
        function createNewOrderDeposit() {
            let item = {
                order_id:       $('#order-id-input').val(),
                payment_type:   $('#payment-deposit-select').val(),
                payment_amount: $('#payment-deposit-amount-input').val(),
                comment:        $('#comment-textarea').val()
            };

            axios.post("{{ route('api.order.new.deposit') }}", item)
            .then(response => {
                if (response.data.success) {
                    $('#new-deposit-modal').modal('hide');

                    location.reload();
                } else {
                    return errorToast.fire(response.data.message);
                }
            });
        }
    </script>

@endpush