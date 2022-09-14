@extends('front.layouts.app')

@push('css_after')
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/js/dist/css/lightgallery-bundle.css') }}" />
@endpush

@section('content')
    <div class="page-banner bg-white py-3">
        <div class="container">
            @include('front.layouts.partials.session')
            <div class="row">
                <div class="col-md-6">
                    <h1 class="mt-2 h3 text-secondary">{{ $apartment->title }}  </h1>
                    <span class="d-block"><i class="fas fa-map-marker-alt text-primary font-12"></i> {{ $apartment->address }}, {{ $apartment->city }}</span>
                </div>
                <div class="col-md-6">
                    <div class="text-primary text-start h5 my-2 text-md-end">{{ number_format($apartment->cijena, 0, ',', '.') }} {{ config('settings.apartment_price_by')[$apartment->price_per]['title'][current_locale()] }}</div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="row" id="gallery">
                        <!-- Slide 1-->
                        <div class="col-xs-12 col-md-6 p-1 pe-0 overflow-hidden featured-thumb position-relative">
                            <a href="{{ asset($apartment->image) }}" class="link">
                                <img  src="{{ asset($apartment->image) }}" class="ls-bg" alt="" />
                                <div class="sale bg-secondary text-white"><i class="fas fa-search-plus"></i> View Full Gallery ({{ $apartment->images()->where('published', 1)->count() }})</div>
                            </a>
                        </div>
                        <div class="col-md-6 d-none d-md-block ps-3 p-0 pt-1">
                            <div class="row my-0">
                                @foreach ($apartment->images()->where('default', 0)->take(4)->get() as $image)
                                    <div class="col-md-6 mb-3 pe-2">
                                        <a href="{{ asset($image->image) }}" class="link">
                                            <img  src="{{ asset($image->image) }}" class="ls-bg" alt="{{ $image->alt }}" />
                                        </a>
                                    </div>
                                @endforeach

                                    @foreach ($apartment->images()->where('default', 0)->skip(5)->take(10)->get() as $image)

                                            <a href="{{ asset($image->image) }}" class="link d-none">
                                                <img  src="{{ asset($image->image) }}" class="ls-bg" alt="{{ $image->alt }}" />
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
    <div class=" bg-white" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row" >
                        <div class="col-lg-4 order-lg-2 content">
                            <div class="sidebar">
                                <div class="mt-4 p-4 shadow-one reservationbox">

                                    <h5 class="mt-2 mb-2 text-primary">Reserve your apartment stay</h5>

                                    <form class="bg-gray-input d-inline-block" action="{{ route('checkout') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="row row-cols-1">
                                            <div class="col mt-3">


                                                <div class="input-group ">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                    <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                                                    <input class="form-control" id="checkindate" name="dates" placeholder="Check-in -> Checkout" type="text">

                                                    <script>
                                                        const DateTime = easepick.DateTime;
                                                        const bookedDates = {!! collect($dates)->toJson() !!}
                                                        .map(d => {
                                                            if (d instanceof Array) {
                                                                const start = new DateTime(d[0], 'YYYY-MM-DD');
                                                                const end = new DateTime(d[1], 'YYYY-MM-DD');

                                                                return [start, end];
                                                            }

                                                            return new DateTime(d, 'YYYY-MM-DD');
                                                        });
                                                        const pickerres = new easepick.create({
                                                            element: document.getElementById('checkindate'),
                                                            css: [
                                                                'public/assets/css/reservation.css',
                                                            ],
                                                            grid: 1,
                                                            calendars: 1,
                                                            zIndex: 10,
                                                            plugins: ['LockPlugin','RangePlugin'],
                                                            RangePlugin: {
                                                                tooltipNumber(num) {
                                                                    return num - 1;
                                                                },
                                                                locale: {
                                                                    one: 'night',
                                                                    other: 'nights',
                                                                },
                                                            },
                                                            LockPlugin: {
                                                                minDate: new Date(),
                                                                minDays: 2,
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


                                                </div>




                                            </div>


                                            <div class="col-md-6  mt-3">
                                                <div class="input-group flex-nowrap select-arrow">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                    <select class="form-control form-select" name="adults">
                                                        <option value="0">Adults</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6  mt-3">
                                                <div class="input-group flex-nowrap select-arrow">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                    <select class="form-control form-select" name="children">
                                                        <option value="0">Children</option>
                                                        <option>0</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </div>
                                            </div>







                                            <div class="col mt-4">
                                                <button type="submit" id="send" value="submit" class="btn btn-primary w-100">Reserve</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 mb-5 order-lg-1 content">
                            <div class="property-details ">

                                <div class="row">
                                    <div class="col">
                                        <h4 class="text-secondary my-4">Description</h4>
                                        {!! $apartment->description !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                        <h4 class="text-secondary my-4">What this place offers</h4>
                                        <div>

                                                @foreach ($apartment->amenities()->get() as $group => $items)
                                                    <h5 class="text-secondary mb-3">{{ $group }}</h5>

                                                    <ul class="form-group row items-push mb-0">
                                                        @foreach ($items as $detail)
                                                            <ul class="row">
                                                                <li class="mb-3 col-md-4">
                                                                   <span class="text-secondary font-weight-bold">
                                                                   <img src="{{ asset('media/icons') }}/{{ $detail['icon'] }}" class="offer-icon"/> {{ $detail['title'] }}
                                                                   </span>
                                                                </li>
                                                            </ul>
                                                        @endforeach
                                                    </div>
                                                @endforeach

                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <h4 class="text-secondary my-4">Availability Calendar</h4>


                                    <div class="col-md-12">


                                        <input class="form-control d-none" id="datepicker" />
                                        <script>


                                            const picker = new easepick.create({
                                                element: document.getElementById('datepicker'),
                                                css: [
                                                    'public/assets/css/reservation.css',
                                                ],
                                                grid: 2,
                                                calendars: 2,
                                                inline: true,
                                                plugins: ['LockPlugin','RangePlugin'],
                                                RangePlugin: {
                                                    tooltipNumber(num) {
                                                        return num - 1;
                                                    },
                                                    locale: {
                                                        one: 'night',
                                                        other: 'nights',
                                                    },
                                                },
                                                LockPlugin: {
                                                    minDate: new Date(),
                                                    minDays: 2,
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

                                    </div>
                                </div>




                                <div class="row mb-4">
                                    <div class="col">
                                        <h4 class="text-secondary my-4">User Reviews</h4>
                                        <ul class="post-comments">
                                            <li class="py-4 d-flex">
                                                <div class="avata"><img src="assets/images/flags/de.webp" alt=""></div>
                                                <div class="comment-detail">
                                                    <div class="d-inline-block mb-3">
                                                        <h5 class="text-secondary">Rebecca D. Nagy</h5>
                                                        <ul class="text-primary d-flex font-13">
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="float-end"> <span class="me-4 text-ordinary">27-08-2022</span>  </div>
                                                    <p>The apartment was nicely clean. We enjoyed the balcony view very much! The host was super helpful. We were missing tablets for the washing machine tho. Grocery store in the same bulding, a café 2 mins walk, Jarun lake 20 mins walk, tram stop 5 mins walk. We had a nice stay:)
                                                    </p>
                                                </div>
                                            </li>
                                            <li class="py-4 d-flex">
                                                <div class="avata"><img src="assets/images/flags/de.webp" alt=""></div>
                                                <div class="comment-detail">
                                                    <div class="d-inline-block mb-3">
                                                        <h5 class="text-secondary">Rebecca D. Nagy</h5>
                                                        <ul class="text-primary d-flex font-13">
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="float-end"> <span class="me-4 text-ordinary">27-08-2022</span>  </div>
                                                    <p>The apartment was nicely clean. We enjoyed the balcony view very much! The host was super helpful. We were missing tablets for the washing machine tho. Grocery store in the same bulding, a café 2 mins walk, Jarun lake 20 mins walk, tram stop 5 mins walk. We had a nice stay:)
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col">
                                        <h4 class="text-secondary my-4 mb-2">Where you’ll be</h4>
                                        <span class="d-block"><i class="fas fa-map-marker-alt text-primary font-12"></i> 1a Vrbje ulica, Zagreb</span>

                                        <div id="map-single" class="single-map mt-4"></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                        <h4 class="text-secondary my-4">Things to know</h4>

                                        <div class="row ">
                                            <div class="col-md-4 mb-4">
                                                <h5 class="text-secondary">House rules</h5>
                                                <ul>
                                                    <li> <i class="far fa-clock font-13 text-primary me-1"></i> Check-in: 5:00 PM - 2:00 AM</li>
                                                    <li><i class="far fa-clock font-13 text-primary me-1"></i> Checkout: 10:00 AM</li>
                                                    <li><i class="fas fa-door-closed font-13 text-primary me-1"></i> Self check-in with lockbox</li>
                                                    <li><i class="fas fa-smoking-ban font-13 text-primary me-1"></i> No smoking</li>

                                                    <li><i class="fas fa-users-slash font-13 text-primary me-1"></i> No parties or events</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <h5 class="text-secondary">Health & safety</h5>
                                                <ul>
                                                    <li><i class="fas fa-shield-virus font-13 text-primary me-1"></i> COVID-19 safety practices apply</li>
                                                    <li><i class="fas fa-certificate font-13 text-primary me-1"></i> Carbon monoxide alarm </li>
                                                    <li><i class="fas fa-certificate font-13 text-primary me-1"></i> Smoke alarm </li>

                                                </ul>
                                            </div>
                                            <div class="col-md-4 ">
                                                <h5 class="text-secondary">Cancellation policy</h5>
                                                <ul>
                                                    <li>Free cancellation for 48 hours.</li>
                                                    <li>Review the Host’s full cancellation policy which applies even if you cancel for illness or disruptions caused by COVID-19.</li>

                                                </ul>
                                            </div>
                                        </div>
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
        jQuery(document).ready(function() {
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
            plugins: [lgZoom, lgThumbnail],
            selector: '.link',
            download: false,
            mobileSettings : [{ controls: true, showCloseIcon: true, download: false }],
            speed: 500,
            showZoomInOutIcons: true,
            actualSize: false,
            steps:4,
            licenseKey:'0000-0000-000-0000'
        });
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoB-nFyi-8EGpAmsNFREAWk3XzUK3RTOA"></script>
    <script src="{{ asset('assets/js/map/markerwithlabel_packed.js') }}"></script>
    <script src="{{ asset('assets/js/map/infobox.js') }}"></script>
    <script src="{{ asset('assets/js/map/property-map.js') }}"></script>
    <script>
        (function($) {
            var _latitude = {{ $apartment->latitude }};
            var _longitude = {{ $apartment->longitude }};
            createPropertyGoogleMap(_latitude, _longitude);
        })(jQuery);
    </script>
@endpush
