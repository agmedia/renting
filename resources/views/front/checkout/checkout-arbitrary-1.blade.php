@extends('front.layouts.app')

@push('css_after')
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
@endpush

@section('content')

    <div class="page-banner full-row bg-white py-5">
        <div class="container">
            <div class="row row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <h3 class="page-name text-secondary m-0"> <a href="{{ route('index') }}"><i class="fas fa-angle-left me-5"></i></a>{{ __('front/checkout.special') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row bg-white pt-0">
        <div class="container">
            <div class="row">
                <form action="{{ route('checkout.arbitrary.select') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="col-lg-7 order-lg-1 mt-0">
                        <h5 class="mt-2 mb-0 text-primary">{{ __('front/checkout.arbitrary.title') }}</h5>

                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                    <input class="form-control bg-gray" id="checkindate" name="dates" placeholder="{{ __('front/apartment.checkin_title') }}" type="text">
                                    @if ($errors->has('dates'))
                                        <span class="ml-2 font-size-sm text-danger">{{ __('front/checkout.dates_error') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="input-group flex-nowrap select-arrow">
                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-map-marker-alt"></i></span>
                                    <select class="form-control bg-gray form-select" id="select-source" name="source">
                                        <option value="0" selected>{{ __('front/checkout.select_source') }}</option>
                                        <option value="airbnb">Airbnb.com</option>
                                        <option value="booking">Booking.com</option>
                                        <option value="selfcheckins">SelfCheckins.com</option>
                                    </select>
                                    @if ($errors->has('source'))
                                        <span class="ml-2 font-size-sm text-danger">{{ __('front/checkout.source_error') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 mt-4 mb-4">
                                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save" aria-hidden="true"></i> {{ __('front/checkout.arbitrary.btn_next') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        var pickerres = new easepick.create({
            element:     document.getElementById('checkindate'),
            css:         [
                'assets/css/reservation.css',
            ],
            grid:        1,
            calendars:   1,
            zIndex:      10,
            lang:        '{{ current_locale() }}',
            plugins:     ['LockPlugin', 'RangePlugin'],
            RangePlugin: {
                tooltipNumber(num) {
                    return num - 1;
                },
                locale: {
                    one:   'night',
                    other: 'nights',
                }
            },
            LockPlugin:  {
                minDays:     2,
                inseparable: true
            }
        });
    </script>
@endpush
