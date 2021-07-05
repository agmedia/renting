<div class="modal fade" id="payment-modal-payway" tabindex="-1" role="dialog" aria-labelledby="modal-payment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content rounded">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary">
                    <h3 class="block-title">Plaćanje karticama</h3>
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
                                        <label for="payway-title">Naslov</label>
                                        <input type="text" class="form-control" id="payway-title" name="title">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payway-min">Min. iznos narudžbe</label>
                                        <input type="text" class="form-control" id="payway-min" name="min">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="payway-short-description">Kratki opis <span class="small text-gray">(Prikazuje se prilikom odabira plaćanja.)</span></label>
                                <textarea class="js-maxlength form-control" id="payway-short-description" name="data['short_description']" rows="2" maxlength="160" data-always-show="true" data-placement="top"></textarea>
                                <small class="form-text text-muted">
                                    160 znakova max
                                </small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="payway-description">Detaljni opis <span class="small text-gray">(Ako je potreban. Prikazuje se ako je plaćanje odabrano prilikom kupnje.)</span></label>
                                <textarea class="form-control" id="payway-description" name="data['description']" rows="4"></textarea>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payway-price">Poredak</label>
                                        <input type="text" class="form-control" id="payway-sort-order" name="sort_order">
                                    </div>
                                </div>
                                <div class="col-md-6 text-right" style="padding-top: 37px;">
                                    <div class="form-group">
                                        <label class="css-control css-control-sm css-control-success css-switch res">
                                            <input type="checkbox" class="css-control-input" id="payway-status" name="status">
                                            <span class="css-control-indicator"></span> Status načina plaćanja
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="payway-code" name="code" value="payway">
                            <input type="hidden" id="payway-geo-zone" name="geo_zone" value="1">
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                        Odustani <i class="fa fa-times ml-2"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); create_payway();">
                        Snimi <i class="fa fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('payment-modal-js')
    <script>
        /**
         *
         */
        function create_payway() {
            let item = {
                title: $('#payway-title').val(),
                code: $('#payway-code').val(),
                min: $('#payway-min').val(),
                data: {
                    short_description: $('#payway-short-description').val(),
                    description: $('#payway-description').val(),
                },
                geo_zone: $('#payway-geo-zone').val(),
                status: $('#payway-status')[0].checked,
                sort_order: $('#payway-sort-order').val()
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
        function edit_payway(item) {
            $('#payway-title').val(item.title);
            $('#payway-min').val(item.min);
            $('#payway-short-description').val(item.data.short_description);
            $('#payway-description').val(item.data.description);
            $('#payway-sort-order').val(item.sort_order);
            $('#payway-code').val(item.code);

            if (item.status) {
                $('#payway-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush