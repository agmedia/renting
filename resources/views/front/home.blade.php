@extends('front.layouts.app')

@push('css_after')
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
@endpush

@push('meta_tags')
    <link rel="canonical" href="{{ request()->url() }}" />
    <meta property="og:locale" content="{{ current_locale(true) }}" />
    <meta property="og:type" content="product" />
    <meta property="og:title" content="SelfCheckIns" />
    <meta property="og:description" content="{{ __('front/common.home_description') }}" />
    <meta property="og:url" content="{{ request()->url() }}"  />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="og:image" content="{{ asset('media/img/apartment/2/jacuzzi-garage-flex-selfcheckins-20-star-ceiling-gzCM.jpg') }}" />
    <meta property="og:image:secure_url" content="{{ asset('media/img/apartment/2/jacuzzi-garage-flex-selfcheckins-20-star-ceiling-gzCM.jpg') }}" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="720" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:alt" content="SelfCheckIns" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="SelfCheckInsi" />
    <meta name="twitter:description" content="SelfCheckIns" />
    <meta name="twitter:image" content="{{ asset('media/img/apartment/2/jacuzzi-garage-flex-selfcheckins-20-star-ceiling-gzCM.jpg') }}" />


@endpush

@section ( 'title', 'SelfCheckIns' )
@section ( 'description', __('front/common.home_description') )

@section('content')
    <div class="full-row bg-white p-0">
        <div class="container-fluid">
            <div class="row">

                <!-- listings -->
                <div class="col-12 ">
                    <div class="row property-search mt-2 mt-0">
                        <div class="col-md-12">


                            <!---filters -->
                            <div class="row">
                                <div class="col">

                                        <div class="card card-body pb-0 px-0 border-0">
                                            <div class="mb-0 p-4 pt-2 shadow-one reservationbox">

                                                <div class="row row-cols-1">

                                                    <div class="col-md-6 mt-3">
                                                        <div class="input-group flex-nowrap select-arrow">
                                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-map-marker-alt"></i></span>
                                                            <select class="form-control bg-gray form-select" id="select-city">
                                                                <option value="0" selected>{{ __('front/apartment.select_city') }}</option>
                                                                @foreach($cities as $city)
                                                                    <option @if ($loop->first) selected @endif >{{ $city }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mt-3">
                                                        <div class="input-group ">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                            <input class="form-control bg-gray" id="checkindate" name="dates" placeholder="{{ __('front/apartment.checkin_title') }}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mt-3">
                                                        <div class="input-group flex-nowrap select-arrow">
                                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                            <select class="form-control bg-gray form-select" id="select-max_adults">
                                                                <option value="0">{{ __('front/apartment.adults_title') }}</option>
                                                                @for ($i = 1; $i < 8; $i++)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4  mt-3">
                                                        <div class="input-group flex-nowrap select-arrow">
                                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                            <select class="form-control bg-gray form-select" id="select-max_children">
                                                                <option value="0">{{ __('front/apartment.children_title') }}</option>
                                                                @for ($i = 0; $i < 6; $i++)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mt-3">
                                                        <button type="button" onclick="updateQueryParams()" id="send" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> {{ __('front/apartment.search_box_title') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                            </div>

                            <div class="row pb-0 mt-3">
                                <div class="col-4 col-md-6">
                                    <form class="selecting-command d-flex flex-wrap" method="get">
                                        <div class="select-arrow me-30 d-none d-sm-block">
                                            <select class="form-control form-select bg-gray" id="select-sort">
                                                <option value="0">{{ __('front/apartment.order_default') }}</option>
                                                <option value="new">{{ __('front/apartment.order_newest') }}</option>
                                                <option value="old">{{ __('front/apartment.order_oldest') }}</option>
                                                <option value="top">{{ __('front/apartment.order_top') }}</option>
                                                <option value="popular">{{ __('front/apartment.order_popular') }}</option>
                                            </select>
                                        </div>

                                    </form>
                                </div>
                                <div class="col-8 col-md-6">
                                    <a class="checkbox-collapse btn btn-light bg-gray btn-sm float-end" >
                                        {{ $apartments->total() }} {{ __('pagination.results') }}
                                    </a>
                                </div>
                            </div>

                            <!---listings -->
                            <div class="row mt-0  row-cols-xl-4 row-cols-md-4 row-cols-1 g-4">
                                @foreach ($apartments as $apartment)
                                    <div class="col" >
                                        <div class="featured-thumb hover-zoomer ">
                                            <div class="overflow-hidden position-relative">
                                                <a href="{{ route('apartment', ['apartment' => $apartment->translation->slug]) }}"> <img id="apartment-image-{{ $apartment->id }}" src="{{ asset($apartment->image()) }}" alt="{{ $apartment->title }}"></a>
                                                <div class="featured bg-primary text-white">{{ currency_main($apartment->price_regular, true) }} / {{ config('settings.apartment_price_by')[$apartment->price_per]['title'][current_locale()] }}</div>

                                                @if ($apartment->featured)
                                                    <div class="starmark text-white"><i class="far fa-star"></i></div>
                                                @endif
                                            </div>
                                            <div class="featured-thumb-data shadow-one">
                                                <div class="p-4 pb-2">
                                                    <h5 class="text-secondary hover-text-primary mb-2"><a href="{{ route('apartment', ['apartment' => $apartment->translation->slug]) }}">{{ $apartment->title }}</a></h5>
                                                </div>
                                                <div class="ps-4 pb-2">
                                                    <span class="location"><i class="fas fa-star text-primary"></i> {{ $apartment->m2 }}m² <i class="fas fa-door-open text-primary"></i> {{ $apartment->rooms }} {{ __('front/apartment.rooms') }}   <i class="fas fa-users text-primary me-1"></i> {{ $apartment->max_persons }}  {{ __('front/apartment.guests') }}</span>
                                                </div>

                                                <div class="px-4 pb-4 d-inline-block w-100">
                                                    <div class="float-start">
                                                        {{--@foreach ($apartment->amenity()->take(6)->get() as $item)
                                                            <span class="location list">
                                                                <img src="{{ asset('media/icons') }}/{{ $item->icon }}" class="offer-icon list" /> {{ $item->title }}
                                                            </span>
                                                        @endforeach--}}
                                                        @if (collect(json_decode($apartment->featured_amenities))->count())
                                                            @foreach (collect(json_decode($apartment->featured_amenities))->random(4) as $item)
                                                                <span class="location list">
                                                                    <img src="{{ asset('media/icons') }}/{{ $item->icon }}" class="offer-icon list" /> {{ $item->title->{current_locale()} }}
                                                                </span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="float-end"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!--- pagination -->
                            <div class="row justify-content-center my-5">
                                <div class="col-auto">
                                    {{ $apartments->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--map -->
                <div class="col-12  pe-0 2">
                    <div id="map" class="map-2" style="max-height:600px"></div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js_after')
    <script src="{{ asset('https://maps.googleapis.com/maps/api/js?key=' . config('google.maps-key')) }}"></script>
    <script src="{{ asset('assets/js/map/markerwithlabel_packed.js') }}"></script>
    <script src="{{ asset('assets/js/map/markerclusterer_packed.js') }}"></script>
    <script src="{{ asset('assets/js/map/infobox.js') }}"></script>
    <script src="{{ asset('assets/js/map/custom-map.js') }}"></script>

    <script>
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Google Map - Homepage
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        function createHomepageGoogleMap(_latitude,_longitude) {
            /* setMapHeight(); */
            if (document.getElementById('map') != null) {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    scrollwheel: false,
                    center: new google.maps.LatLng(_latitude, _longitude),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                        position: google.maps.ControlPosition.TOP_CENTER,
                    },
                    zoomControl: true,
                    zoomControlOptions: {
                        position: google.maps.ControlPosition.LEFT_CENTER,
                    },
                    scaleControl: true,
                    streetViewControl: true,
                    streetViewControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_TOP,
                    },
                    fullscreenControl: true,
                    fullscreenControlOptions: {
                        position: google.maps.ControlPosition.LEFT_TOP,
                    },
                    styles: mapStyles
                });

                var i;
                var newMarkers = [];
                let locations = {!! $apartments->toJson() !!}.data;

                for (i = 0; i < locations.length; i++) {
                    var pictureLabel = document.createElement("img");
                    pictureLabel.src = 'assets/images/map/house.png';
                    var boxText = document.createElement("div");
                    infoboxOptions = {
                        content: boxText,
                        disableAutoPan: false,
                       // maxWidth: 150,
                        pixelOffset: new google.maps.Size(-100, 0),
                        zIndex: null,
                        alignBottom: true,
                        boxClass: "infobox-wrapper",
                        enableEventPropagation: true,
                        closeBoxMargin: "0px 0px -8px 0px",
                        closeBoxURL: "assets/images/map/close.png",
                        infoBoxClearance: new google.maps.Size(1, 1)
                    };
                    var marker = new MarkerWithLabel({
                        title: locations[i].title,
                        position: new google.maps.LatLng(locations[i].latitude, locations[i].longitude),
                        map: map,
                        icon: 'assets/images/map/marker.png',
                        labelContent: pictureLabel,
                        labelAnchor: new google.maps.Point(50, 0),
                        labelClass: "marker-style"
                    });

                    locations[i].image = $('#apartment-image-' + locations[i].id).attr('src');

                    console.log(locations[i])

                    newMarkers.push(marker);
                        boxText.innerHTML =
                            '<div class="featured-thumb hover-zoomer shadow-one">' +
                            '<div class=" overflow-hidden position-relative">' +
                            '<a href="{{current_locale()}}' + locations[i].url + '">' +
                            '<img src="' + locations[i].image + '" alt="">' +
                            '</a>' +
                            '<div class="price bg-primary text-white p-2">' + Number(locations[i].price_regular).toFixed(2) + ' {{ $main_currency_symbol }}</div>' +
                            '</div>' +
                            '<div class="featured-thumb-data">' +
                            '<div class="p-0 bg-white">' +


                            '</div>' +
                            '</div>' +
                            '</div>';
                    //Define the infobox
                    newMarkers[i].infobox = new InfoBox(infoboxOptions);
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            for (h = 0; h < newMarkers.length; h++) {
                                newMarkers[h].infobox.close();
                            }
                            newMarkers[i].infobox.open(map, this);
                        }
                    })(marker, i));

                }
                var clusterStyles = [
                    {
                        url: 'assets/images/map/cluster.png',
                        height: 60,
                        width: 60,
                        textColor: '#fff',
                        textSize:15
                    }
                ];
                var markerCluster = new MarkerClusterer(map, newMarkers, {styles: clusterStyles, maxZoom: 14});
                $('body').addClass('loaded');
                setTimeout(function() {
                    $('body').removeClass('has-fullscreen-map');
                }, 1000);
                $('#map').removeClass('fade-map');

                //  Dynamically show/hide markers --------------------------------------------------------------

                google.maps.event.addListener(map, 'idle', function() {

                    for (var i=0; i < locations.length; i++) {
                        if ( map.getBounds().contains(newMarkers[i].getPosition()) ){
                            newMarkers[i].setVisible(true); // <- Uncomment this line to use dynamic displaying of markers

                            newMarkers[i].setMap(map);
                            markerCluster.setMap(map);
                        } else {
                            newMarkers[i].setVisible(false); // <- Uncomment this line to use dynamic displaying of markers

                            newMarkers[i].setMap(null);
                            markerCluster.setMap(null);
                        }
                    }
                });

                // Function which set marker to the user position
                function success(position) {
                    var center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    map.panTo(center);
                    $('#map').removeClass('fade-map');
                }
                // Enable Geo Location on button click
                $('.geo-location').on("click", function() {
                    if (navigator.geolocation) {
                        $('#map').addClass('fade-map');
                        navigator.geolocation.getCurrentPosition(success);
                    } else {
                        error('Geo Location is not supported');
                    }
                });
            }
        }
    </script>

    <script>
        /**
         *
         * @type {URLSearchParams}
         */
        var searchParams = new URLSearchParams(window.location.search);
        /**
         *
         * @type {string[]}
         */
        var selectParams = ['city', 'max_adults', 'max_children'];
        /**
         *
         * @type {P.DateTime|*}
         */
        var DateTime = easepick.DateTime;
        /**
         *
         */
        var pickerres = new easepick.create({
            element:     document.getElementById('checkindate'),
            css:         [
                'assets/css/reservation.css',
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
                startDate: startDate(),
                endDate: endDate()
            },
            LockPlugin:  {
                minDate:     new Date(),
                minDays:     2,
                inseparable: true
            }
        });

        /**
         *
         */
        $(() => {
            var _latitude = 45.8150107380416;
            var _longitude = 15.981403769351106;
            createHomepageGoogleMap(_latitude, _longitude);

            //
            $('#select-sort').on('change', (e) => {
                searchParams.set('sort', e.currentTarget.value);
                window.location.search = searchParams.toString();
            });

            setInputParams();

          /*  $('.property-search').scroll((e) => {
                let div = e.currentTarget;

                if (div.scrollTop > (div.scrollHeight - div.offsetHeight)) {
                    document.body.style.removeProperty('overflow');
                }
            });*/
        });

        /**
         *
         * @returns {*}
         */
        function startDate() {
            if (searchParams.has('from')) {
                return new DateTime(searchParams.get('from'), 'YYYY-MM-DD');
            }
        }

        /**
         *
         * @returns {*}
         */
        function endDate() {
            if (searchParams.has('to')) {
                return new DateTime(searchParams.get('to'), 'YYYY-MM-DD');
            }
        }

        /**
         *
         */
        function setInputParams() {
            searchParams.forEach((item, key) => {
                if (selectParams.indexOf(key) != -1) {
                    document.getElementById('select-' + key).value = item;
                }
            })
        }

        /**
         *
         */
        function updateQueryParams() {
            selectParams.forEach((item) => {
                resolveSelectParam(item);
            });

            let dates = document.getElementById('checkindate').value.split(' - ');

            if (dates.length < 2) {
                searchParams.delete('from');
                searchParams.delete('to');
            } else {
                searchParams.set('from', dates[0]);
                searchParams.set('to', dates[1]);
            }

            window.location.search = searchParams.toString();
        }


        /**
         *
         * @param param
         */
        function resolveSelectParam(param) {
            console.log(param)
            let target = document.getElementById('select-' + param);
            target = target.options[target.selectedIndex].value;

            if (target != 0) {
                return searchParams.set(param, target);
            }

            return searchParams.delete(param);
        }

    </script>

@endpush
