<div class="modal fade" id="payment-modal-bank" tabindex="-1" role="dialog" aria-labelledby="modal-payment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content rounded">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary">
                    <h3 class="block-title">{{ __('back/app.payments.bank') }}</h3>
                    <div class="block-options">
                        <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10">

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="bank-title" class="w-100">{{ __('back/app.payments.input_title') }}
                                            <ul class="nav nav-pills float-right">
                                                @foreach(ag_lang() as $lang)
                                                    <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                    <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#title-{{ $lang->code }}">
                                                        <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                    </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </label>
                                        <div class="tab-content">
                                            @foreach(ag_lang() as $lang)
                                                <div id="title-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                                    <input type="text" class="form-control" id="bank-title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}"  >
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bank-min">{{ __('back/app.payments.min_order_amount') }}</label>
                                        <input type="text" class="form-control" id="bank-min" name="min">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bank-price">{{ __('back/app.payments.fee_amount') }}</label>
                                        <input type="text" class="form-control" id="bank-price" name="data['price']">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="bank-geo-zone">{{ __('back/app.payments.geo_zone') }} <span class="small text-gray">{{ __('back/app.payments.geo_zone_label') }}</span></label>
                                    <select class="js-select2 form-control" id="bank-geo-zone" name="geo_zone" style="width: 100%;" data-placeholder="Odaberite geo zonu">
                                        <option></option>
                                        @foreach ($geo_zones as $geo_zone)
                                            <option value="{{ $geo_zone->id }}" {{ ((isset($payment)) and ($payment->geo_zone == $geo_zone->id)) ? 'selected' : '' }}>{{ $geo_zone->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="bank-short-description" class="w-100">{{ __('back/app.payments.short_desc') }} <span class="small text-gray">{{ __('back/app.payments.short_desc_label') }}</span>


                                    <div class="float-right">
                                        <ul class="nav nav-pills float-right">
                                            @foreach(ag_lang() as $lang)
                                                <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#description-{{ $lang->code }}">
                                                    <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </label>


                                <div class="tab-content">
                                    @foreach(ag_lang() as $lang)
                                        <div id="description-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                            <textarea id="bank-short-description-{{ $lang->code }}" class="js-maxlength form-control" rows="2" maxlength="160" data-always-show="true" name="data['short_description'][{{ $lang->code }}]" placeholder="{{ $lang->code }}" data-placement="top"></textarea>
                                        </div>
                                    @endforeach
                                </div>




                                <small class="form-text text-muted">
                                    160 {{ __('back/app.payments.chars') }} max
                                </small>




                            </div>

                            <div class="form-group mb-4">
                                <label for="bank-description" class="w-100">{{ __('back/app.payments.long_desc') }}<span class="small text-gray"> {{ __('back/app.payments.long_desc_label') }}</span>
                                    <div class="float-right">
                                        <ul class="nav nav-pills float-right">
                                            @foreach(ag_lang() as $lang)
                                                <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#long-description-{{ $lang->code }}">
                                                    <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </label>

                                <div class="tab-content">
                                    @foreach(ag_lang() as $lang)
                                        <div id="long-description-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                            <textarea id="bank-description-{{ $lang->code }}" class="form-control" rows="2" maxlength="160" data-always-show="true" name="data['description'][{{ $lang->code }}]" placeholder="{{ $lang->code }}" data-placement="top"></textarea>
                                        </div>
                                    @endforeach
                                </div>




                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank-price">{{ __('back/app.payments.sort_order') }}</label>
                                        <input type="text" class="form-control" id="bank-sort-order" name="sort_order">
                                    </div>
                                </div>
                                <div class="col-md-6 text-right" style="padding-top: 37px;">
                                    <div class="form-group">
                                        <label class="css-control css-control-sm css-control-success css-switch res">
                                            <input type="checkbox" class="css-control-input" id="bank-status" name="status">
                                            <span class="css-control-indicator"></span> {{ __('back/app.payments.status_title') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="bank-code" name="code" value="bank">
                            <input type="hidden" id="bank-geo-zone" name="geo_zone" value="1">
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                        {{ __('back/app.payments.cancel') }} <i class="fa fa-times ml-2"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); create_bank();">
                        {{ __('back/app.payments.save') }} <i class="fa fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('payment-modal-js')
    <script>
        $(() => {
            $('#bank-geo-zone').select2({
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
        });
        /**
         *
         */
        function create_bank() {
            let item = {
                title: $('#bank-title').val(),
                code: $('#bank-code').val(),
                min: $('#bank-min').val(),
                data: {
                    price: $('#bank-price').val(),
                    short_description: $('#bank-short-description').val(),
                    description: $('#bank-description').val(),
                },
                geo_zone: $('#bank-geo-zone').val(),
                status: $('#bank-status')[0].checked,
                sort_order: $('#bank-sort-order').val()
            };

            axios.post("{{ route('api.payment.store') }}", {data: item})
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
         * @param item
         */
        function edit_bank(item) {
            $('#bank-title').val(item.title);
            $('#bank-min').val(item.min);
            $('#bank-price').val(item.data.price);
            $('#bank-short-description').val(item.data.short_description);
            $('#bank-description').val(item.data.description);
            $('#bank-sort-order').val(item.sort_order);
            $('#bank-code').val(item.code);

            if (item.status) {
                $('#bank-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush
