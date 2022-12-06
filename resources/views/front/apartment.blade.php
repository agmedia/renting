@extends('front.layouts.app')

@push('css_after')
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/js/dist/css/lightgallery-bundle.css') }}"/>
@endpush

@push('meta_tags')
    <link rel="canonical" href="{{ request()->url() }}"/>
    <meta property="og:locale" content="{{ current_locale(true) }}"/>
    <meta property="og:type" content="{{ $meta['type'] }}"/>
    <meta property="og:title" content="{{ $meta['title'] }}"/>
    <meta property="og:description" content="{{ $meta['description'] }}"/>
    <meta property="og:url" content="{{ request()->url() }}"/>
    <meta property="og:site_name" content="{{ config('app.name') }}"/>
    <meta property="og:image" content="{{ $meta['image'] }}"/>
    <meta property="og:image:secure_url" content="{{ $meta['image'] }}"/>
    <meta property="og:image:width" content="{{ $meta['image_width'] }}"/>
    <meta property="og:image:height" content="{{ $meta['image_height'] }}"/>
    <meta property="og:image:type" content="{{ $meta['image_type'] }}"/>
    <meta property="og:image:alt" content="{{ $meta['image_alt'] }}"/>
@endpush

@section('title', $meta['title'])
@section('description', $meta['description'])

@section('content')
    <div class="page-banner bg-white py-3">
        <div class="container">
            @include('front.layouts.partials.session')
            <div class="row">
                <div class="col-md-8">
                    <h1 class="mt-2 h4 text-secondary">{{ $apartment->title }}  </h1>
                    <span class="d-block"><i class="fas fa-map-marker-alt text-primary font-12"></i> {{ $apartment->address }}, {{ $apartment->city }}</span>
                </div>
                <div class="col-md-4">
                    <div class="text-primary text-start h5 my-2 text-md-end">{{ $apartment->price_text }} / {{ config('settings.apartment_price_by')[$apartment->price_per]['title'][current_locale()] }}</div>

                    <span class="d-block  text-md-end"><i class="fas fa-star text-primary"></i> {{ $apartment->m2 }}m² <i class="fas fa-door-open text-primary"></i> {{ $apartment->rooms }} {{ __('front/apartment.rooms') }}   <i
                                class="fas fa-users text-primary me-1"></i> {{ $apartment->regular_persons }}  {{ __('front/apartment.guests') }}</span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="row" id="gallery">
                        <!-- Slide 1-->
                        <div class="col-xs-12 col-md-6 p-1 pe-0 overflow-hidden featured-thumb position-relative">
                            <a href="{{ asset($apartment->image) }}" class="link">
                                <img src="{{ asset($apartment->image) }}" class="ls-bg" alt=""/>
                                <div class="sale bg-secondary text-white"><i class="fas fa-search-plus"></i> {{ __('front/apartment.view_gallery') }} ({{ $apartment->images()->where('published', 1)->count() }})</div>
                            </a>
                        </div>
                        <div class="col-md-6 d-none d-md-block ps-3 p-0 pt-1">
                            <div class="row my-0">
                                @foreach ($apartment->images()->where('default', 0)->take(4)->get() as $image)
                                    <div class="col-md-6 mb-3 pe-2">
                                        <a href="{{ asset($image->image) }}" class="link">
                                            <img src="{{ asset($image->image) }}" class="ls-bg" alt="{{ $image->alt }}"/>
                                        </a>
                                    </div>
                                @endforeach

                                @foreach ($apartment->images()->where('default', 0)->skip(5)->take(40)->get() as $image)
                                    <a href="{{ asset($image->image) }}" class="link d-none">
                                        <img src="{{ asset($image->image) }}" class="ls-bg" alt="{{ $image->alt }}"/>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--============== Property Single Section Start ==============-->
    <div class=" bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-4 order-lg-2 content">
                            <div class="sidebar">
                                <form class="bg-gray-input d-inline-block" action="{{ route('checkout') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="mt-4 p-4 shadow-one reservationbox">
                                        <h5 class="mt-2 mb-2 text-primary">{{ __('front/apartment.reserve_title') }}</h5>
                                        <div class="row row-cols-1">
                                            <div class="col mt-3">

                                                <div class="input-group ">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                    <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                                                    <input class="form-control" id="checkindate" name="dates" placeholder="{{ __('front/apartment.checkin_title') }}" type="text">
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="input-group flex-nowrap select-arrow">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                    <select class="form-control form-select" name="adults" id="adults-select"></select>
                                                </div>
                                            </div>

                                            <div class="col-md-6  mt-3">
                                                <div class="input-group flex-nowrap select-arrow">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                    <select class="form-control form-select" name="children" id="children-select"></select>
                                                </div>
                                            </div>

                                            <div class="col-md-6  mt-3">
                                                <div class="input-group flex-nowrap select-arrow">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                    <select class="form-control form-select" name="baby" id="baby-select"></select>
                                                </div>
                                            </div>

                                            <div class="col mt-4">
                                                <button type="submit" id="send" value="submit" class="btn btn-primary w-100">{{ __('front/apartment.reserve_btn_title') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-8 mb-5 order-lg-1 content">
                            <div class="property-details ">

                                <div class="row">
                                    <div class="col">
                                        <h4 class="text-secondary my-4">{{ __('front/apartment.description_title') }}</h4>
                                        {!! $apartment->description !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                        <h4 class="text-secondary my-4">{{ __('front/apartment.offer_title') }}</h4>
                                        <div>
                                            <ul class="row">
                                                @foreach ($apartment->amenities() as  $items)
                                                    @foreach ($items as $detail)
                                                        @if($detail['featured'])
                                                            <li class="mb-3 col-md-6">
                                                                   <span class="text-secondary font-weight-bold">
                                                                   <img src="{{ asset('media/icons') }}/{{ $detail['icon'] }}" class="offer-icon"/> {{ $detail['title'] }}
                                                                   </span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </ul>

                                            <a class="text-primary hover-text-secondary mt-3 mb-4 ps-3 position-relative plus-minus d-block" data-bs-toggle="collapse" href="#offer" role="button" aria-expanded="false"
                                               aria-controls="offer">{{ __('front/apartment.show_title') }}</a>

                                            <div class="collapse m-0" id="offer">
                                                @foreach ($apartment->amenities() as $group => $items)
                                                    <h5 class="text-secondary ">{{ $group }}</h5>
                                                    <ul class="row mb-3 mt-2">
                                                        @foreach ($items as $detail)
                                                            <li class="mb-3 col-md-4">
                                                                   <span class="text-secondary font-weight-bold">
                                                                   <img src="{{ asset('media/icons') }}/{{ $detail['icon'] }}" class="offer-icon"/> {{ $detail['title'] }}
                                                                   </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <h4 class="text-secondary my-4">{{ __('front/apartment.calendar_title') }}</h4>
                                    <div class="col-md-12">
                                        <input class="form-control d-none" id="datepicker"/>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                        <h4 class="text-secondary my-4 mb-2">{{ __('front/apartment.where_title') }}</h4>
                                        <span class="d-block"><i class="fas fa-map-marker-alt text-primary font-12"></i> {{ $apartment->address }}, {{ $apartment->city }} </span>
                                        <div id="map-single" class="single-map mt-4"></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                        <h4 class="text-secondary my-4">{{ __('front/apartment.things_title') }}</h4>
                                        {!! __('front/apartment.html_block') !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js_middle')
    <script type="text/javascript" src="{{ asset('assets/js/ResizeSensor.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/theia-sticky-sidebar.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.content, .sidebar').theiaStickySidebar({
                // Settings
                additionalMarginTop: 80
            });
        });
    </script>
@endpush

@push('js_after')
    <script src="{{ asset('assets/js/dist/lightgallery.min.js') }}"></script>

    <!-- lightgallery plugins -->
    <script src="{{ asset('assets/js/dist/plugins/thumbnail/lg-thumbnail.min.js') }}"></script>
    <script src="{{ asset('assets/js/dist/plugins/zoom/lg-zoom.min.js') }}"></script>

    <script type="text/javascript">
        lightGallery(document.getElementById('gallery'), {
            plugins:            [lgZoom, lgThumbnail],
            selector:           '.link',
            download:           false,
            mobileSettings:     [{controls: true, showCloseIcon: true, download: false}],
            speed:              500,
            showZoomInOutIcons: true,
            actualSize:         false,
            steps:              4,
            licenseKey:         '0000-0000-000-0000'
        });
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7hOSRQTL76Yb5ffPF7ecWG-K-nz6Jmek"></script>
    <script src="{{ asset('assets/js/map/markerwithlabel_packed.js') }}"></script>
    <script src="{{ asset('assets/js/map/infobox.js') }}"></script>
    <script src="{{ asset('assets/js/map/property-map.js') }}"></script>
    <script>
        (function ($) {
            var _latitude  = {{ $apartment->latitude }};
            var _longitude = {{ $apartment->longitude }};
            createPropertyGoogleMap(_latitude, _longitude);
        })(jQuery);
    </script>

    <script>
        const DateTime    = easepick.DateTime;
        const bookedDates = {!! collect($dates)->toJson() !!}
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
                '{{ asset('assets/css/reservation.css') }}',
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

        const picker = new easepick.create({
            element:   document.getElementById('datepicker'),
            css:       [
                '{{ asset('assets/css/reservation.css') }}',
            ],
            grid:      2,
            calendars: 2,
            inline:    true,
            plugins:   ['LockPlugin', 'RangePlugin'],
            setup(picker) {
                picker.on('select', (e) => {
                    const range = pickerres.PluginManager.getInstance('RangePlugin');
                    range.setStartDate(e.detail.start);
                    range.setEndDate(e.detail.end);
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

    <script>
        var max_adults   = {{ $apartment->max_adults }};
        var max_children = {{ $apartment->max_children }};
        var max_persons  = {{ $apartment->max_persons }};

        var adults_title   = '{{ __('front/apartment.adults_title') }}';
        var children_title = '{{ __('front/apartment.children_title') }}';
        var baby_title     = '{{ __('front/apartment.baby_title') }}';

        /**
         *
         * @param selected_count
         * @param max_target
         * @returns {number}
         */
        function countRemainingBeds(selected_count, max_target) {
            let count = max_target;

            if ((max_persons - selected_count) < max_target) {
                count = max_persons - selected_count;
            }

            return count;
        }

        /**
         *
         * @param select
         * @param max
         * @param title
         */
        function changeSelect(select, max, title, index = 0) {
            select.options.length = 0;
            max_allowed           = getMaxPersons(max, title);

            for (let i = 0; i < max_allowed; i++) {
                let opt = document.createElement('option');
                opt.setAttribute('value', i);
                opt.innerText = i ? i : title;

                select.appendChild(opt);
                select.selectedIndex = index;
            }
        }

        /**
         *
         * @param max
         * @param title
         * @returns {number|*}
         */
        function getMaxPersons(max, title) {
            if (title == baby_title && max > 0) {
                return max;
            }

            return max + 1;
        }

        /**
         *
         */
        $(() => {
            let adults_select   = document.getElementById('adults-select');
            let children_select = document.getElementById('children-select');
            let baby_select     = document.getElementById('baby-select');

            changeSelect(adults_select, max_adults, adults_title);
            changeSelect(children_select, max_children, children_title);
            changeSelect(baby_select, max_children, baby_title);

            $('#children-select').on('change', event => {
                let max = countRemainingBeds(event.currentTarget.value, max_adults);

                changeSelect(adults_select, max, adults_title, adults_select.selectedIndex);
            });

            $('#adults-select').on('change', event => {
                let max = countRemainingBeds(event.currentTarget.value, max_children);

                changeSelect(children_select, max, children_title, children_select.selectedIndex);
            });

        })
    </script>

@endpush
