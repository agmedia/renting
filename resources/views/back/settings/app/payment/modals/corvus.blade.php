<div class="modal fade" id="payment-modal-corvus" tabindex="-1" role="dialog" aria-labelledby="modal-payment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content rounded">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary">
                    <h3 class="block-title">{{ __('back/app.payments.corvus') }}</h3>
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
                                        <label for="corvus-title" class="w-100">{{ __('back/app.payments.input_title') }}
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
                                                    <input type="text" class="form-control" id="corvus-title-{{ $lang->code }}" name="corvus-title[{{ $lang->code }}]" placeholder="{{ $lang->code }}"  >
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="corvus-min">{{ __('back/app.payments.min_order_amount') }}</label>
                                        <input type="text" class="form-control" id="corvus-min" name="min">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="corvus-geo-zone">{{ __('back/app.payments.geo_zone') }} <span class="small text-gray">{{ __('back/app.payments.geo_zone_label') }}</span></label>
                                    <select class="js-select2 form-control" id="corvus-geo-zone" name="corvus_geo_zone" style="width: 100%;" data-placeholder="{{ __('back/app.payments.select_geo') }}">
                                        <option></option>
                                        @foreach ($geo_zones as $geo_zone)
                                            <option value="{{ $geo_zone->id }}" {{ ((isset($shipping)) and ($shipping->geo_zone == $geo_zone->id)) ? 'selected' : '' }}>{{ isset($geo_zone->title->{current_locale()}) ? $geo_zone->title->{current_locale()} : $geo_zone->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="corvus-price">{{ __('back/app.payments.fee_amount') }}</label>
                                        <input type="text" class="form-control" id="corvus-price" name="data['price']">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="bank-short-description" class="w-100">{{ __('back/app.payments.short_desc') }} <span class="small text-gray">{{ __('back/app.payments.short_desc_label') }}</span>
                                    <div class="float-right">
                                        <ul class="nav nav-pills float-right">
                                            @foreach(ag_lang() as $lang)
                                                <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#corvus-description-{{ $lang->code }}">
                                                    <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </label>
                                <div class="tab-content">
                                    @foreach(ag_lang() as $lang)
                                        <div id="corvus-description-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                            <textarea id="corvus-short-description-{{ $lang->code }}" class=" form-control"  name="data['short_description'][{{ $lang->code }}]" placeholder="{{ $lang->code }}" ></textarea>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="form-text text-muted">
                                    160 {{ __('back/app.payments.chars') }} max
                                </small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="corvus-description" class="w-100">{{ __('back/app.payments.long_desc') }}<span class="small text-gray"> {{ __('back/app.payments.long_desc_label') }}</span>
                                    <div class="float-right">
                                        <ul class="nav nav-pills float-right">
                                            @foreach(ag_lang() as $lang)
                                                <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#corvus-long-description-{{ $lang->code }}">
                                                    <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </label>

                                <div class="tab-content">
                                    @foreach(ag_lang() as $lang)
                                        <div id="corvus-long-description-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                            <textarea id="corvus-description-{{ $lang->code }}" class="form-control" rows="4" maxlength="160" data-always-show="true" name="data['description'][{{ $lang->code }}]" placeholder="{{ $lang->code }}" data-placement="top"></textarea>
                                        </div>
                                    @endforeach
                                </div>

                            </div>



                            <div class="block block-themed block-transparent mb-4">
                                <div class="block-content bg-body pb-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-11">
                                            <div class="form-group">
                                                <label for="corvus-shop-id">ShopID:</label>
                                                <input type="text" class="form-control" id="corvus-shop-id" name="data['shop_id']">
                                            </div>
                                            <div class="form-group">
                                                <label for="corvus-secret-key">SecretKey:</label>
                                                <input type="text" class="form-control" id="corvus-secret-key" name="data['secret_key']">
                                            </div>

                                            <div class="form-group">
                                                <label for="corvus-callback">CallbackURL: </label>
                                                <input type="text" class="form-control" id="corvus-callback" name="data['callback']" value="{{ url('/') }}">
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="d-block">Test mod.</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                            <input type="radio" class="custom-control-input" id="corvus-test-on" name="test" checked="" value="1">
                                                            <label class="custom-control-label" for="corvus-test-on">On</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                            <input type="radio" class="custom-control-input" id="corvus-test-off" name="test" value="0">
                                                            <label class="custom-control-label" for="corvus-test-off">Off</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="corvus-price">{{ __('back/app.payments.sort_order') }}</label>
                                        <input type="text" class="form-control" id="corvus-sort-order" name="sort_order">
                                    </div>
                                </div>
                                <div class="col-md-6 text-right" style="padding-top: 37px;">
                                    <div class="form-group">
                                        <label class="css-control css-control-sm css-control-success css-switch res">
                                            <input type="checkbox" class="css-control-input" id="corvus-status" name="status">
                                            <span class="css-control-indicator"></span> {{ __('back/app.payments.status_title') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="corvus-code" name="code" value="corvus">
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                        {{ __('back/app.payments.cancel') }} <i class="fa fa-times ml-2"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); create_corvus();">
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
            $('#corvus-type').select2({
                minimumResultsForSearch: Infinity
            });

            $('#corvus-geo-zone').select2({
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
        });
        /**
         *
         */
        function create_corvus() {
            let titles = {};
            let short = {};
            let desc = {};

            {!! ag_lang() !!}.forEach(function(lang) {
                titles[lang.code] = document.getElementById('corvus-title-' + lang.code).value;
                short[lang.code] = document.getElementById('corvus-short-description-' + lang.code).value;
                desc[lang.code] = document.getElementById('corvus-description-' + lang.code).value;
            });

            let item = {
                title: titles,
                code: $('#corvus-code').val(),
                min: $('#corvus-min').val(),
                data: {
                    price: $('#corvus-price').val(),
                    short_description: short,
                    description: desc,
                    shop_id: $('#corvus-shop-id').val(),
                    secret_key: $('#corvus-secret-key').val(),
                    type: $('#corvus-type').val(),
                    callback: $('#corvus-callback').val(),
                    test: $("input[name='test']:checked").val(),
                },
                geo_zone: $('#corvus-geo-zone').val(),
                status: $('#corvus-status')[0].checked,
                sort_order: $('#corvus-sort-order').val()
            };

            axios.post("{{ route('api.payment.store') }}", {data: item})
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
        function edit_corvus(item) {
            $('#corvus-min').val(item.min);
            $('#corvus-price').val(item.data.price);

            $('#corvus-shop-id').val(item.data.shop_id);
            $('#corvus-secret-key').val(item.data.secret_key);
            $('#corvus-callback').val(item.data.callback);

            $("input[name=test][value='" + item.data.test + "']").prop("checked",true);

            $('#corvus-type').val(item.data.type);
            $('#corvus-type').trigger('change');
            $('#corvus-geo-zone').val(item.geo_zone);
            $('#corvus-geo-zone').trigger('change');

            $('#corvus-sort-order').val(item.sort_order);
            $('#corvus-code').val(item.code);

            {!! ag_lang() !!}.forEach((lang) => {
                if (typeof item.title[lang.code] !== undefined) {
                    $('#corvus-title-' + lang.code).val(item.title[lang.code]);
                }
                if (typeof item.data.short_description[lang.code] !== undefined) {
                    $('#corvus-short-description-' + lang.code).val(item.data.short_description[lang.code]);
                }
                if (typeof item.data.description[lang.code] !== undefined) {
                    $('#corvus-description-' + lang.code).val(item.data.description[lang.code]);
                }
            });

            if (item.status) {
                $('#corvus-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush
