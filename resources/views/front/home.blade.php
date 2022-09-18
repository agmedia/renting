@extends('front.layouts.app')

@section('content')
    <div class="full-row bg-white p-0">
        <div class="container-fluid">
            <div class="row">

                <!-- listings -->
                <div class="col-xl-6 ">
                    <div class="row property-search mt-2 mt-0">
                        <div class="col-md-12">
                            <div class="row pb-0 mt-3">
                                <div class="col-6 ">
                                    <form class="selecting-command d-flex flex-wrap" method="get">
                                        <div class="select-arrow me-30 d-none d-sm-block">
                                            <select class="form-control form-select bg-gray">
                                                <option>Default Order</option>
                                                <option>Newest First</option>
                                                <option>Oldest First</option>
                                                <option>Top Rated</option>
                                                <option>Most Popular</option>
                                            </select>
                                        </div>
                                        <label>25 results</label>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <a class="checkbox-collapse btn btn-light bg-gray btn-sm float-end" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" title="Grid" class="active">
                                        <i class="fa fa-search" aria-hidden="true"></i> {{ __('front/apartment.search_box_title') }}
                                    </a>
                                </div>
                            </div>

                            <!---filters -->
                            <div class="row">
                                <div class="col">
                                    <div class="collapse font-14" id="multiCollapseExample1">
                                        <div class="card card-body pb-0 px-0 border-0">
                                            <div class="mb-0 p-4 shadow-one reservationbox">
                                                <h5 class="mt-2 mb-2 text-primary">{{ __('front/apartment.search_box_title') }}</h5>
                                                <form class="bg-gray-input d-inline-block" action="http://127.0.0.1:8000/en/checkout" method="post">
                                                    <div class="row row-cols-1">

                                                        <div class="col-md-6 mt-3">
                                                            <div class="input-group flex-nowrap select-arrow">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                                <select class="form-control form-select ">
                                                                    <option selected >{{ __('front/apartment.select_city') }}</option>
                                                                    <option >Zagreb</option>
                                                                    <option>Split</option>
                                                                    <option>Rijeka</option>

                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mt-3">

                                                            <div class="input-group ">
                                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                                <input type="hidden" name="apartment_id" value="">
                                                                <input class="form-control" id="checkindate" name="dates" placeholder="{{ __('front/apartment.checkin_title') }}" type="text">

                                                            </div>

                                                        </div>

                                                        <div class="col-md-4  mt-3">
                                                            <div class="input-group flex-nowrap select-arrow">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                                <select class="form-control form-select" name="adults">
                                                                    <option value="0">{{ __('front/apartment.adults_title') }}</option>
                                                                    <option>1</option>
                                                                    <option>2</option>
                                                                    <option>3</option>
                                                                    <option>4</option>
                                                                    <option>5</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4  mt-3">
                                                            <div class="input-group flex-nowrap select-arrow">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-alt"></i></span>
                                                                <select class="form-control form-select" name="children">
                                                                    <option value="0">{{ __('front/apartment.children_title') }}</option>
                                                                    <option>0</option>
                                                                    <option>1</option>
                                                                    <option>2</option>
                                                                    <option>3</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mt-3">
                                                            <button type="submit" id="send" value="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> {{ __('front/apartment.search_title') }}</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!---listings -->
                            <div class="row mt-0 row-cols-md-2 row-cols-1 g-4">
                                @foreach ($apartments as $apartment)
                                    <div class="col">
                                        <div class="featured-thumb hover-zoomer">
                                            <div class="overflow-hidden position-relative">
                                                <a href="{{ route('apartment', ['apartment' => $apartment->translation()->first()->slug]) }}"> <img src="{{ asset($apartment->image) }}" alt="{{ $apartment->title }}"></a>
                                                <div class="featured bg-primary text-white">{{ $apartment->price_text }} / {{ config('settings.apartment_price_by')[$apartment->price_per]['title'][current_locale()] }}</div>
                                                <div class="starmark text-white"><i class="far fa-star"></i></div>
                                            </div>
                                            <div class="featured-thumb-data shadow-one">
                                                <div class="p-4 pb-2">
                                                    <h5 class="text-secondary hover-text-primary mb-2"><a href="{{ route('apartment', ['apartment' => $apartment->translation()->first()->slug]) }}">{{ $apartment->title }}</a></h5>
                                                    <span class="location"><i class="fas fa-map-marker-alt text-primary"></i> {{ $apartment->address }}, {{ $apartment->city }}</span> </div>
                                                <div class="ps-4 pb-2">
                                                    <span class="location"><i class="fas fa-star text-primary"></i> {{ $apartment->m2 }} m² - {{ $apartment->rooms }} rooms - {{ $apartment->beds }} beds</span>
                                                </div>

                                                <div class="px-4 pb-4 d-inline-block w-100">
                                                    <div class="float-start"><i class="fas fa-user text-primary me-1"></i> Apartments Repinc</div>
                                                    <div class="float-end"><i class="far fa-calendar-alt text-primary me-1"></i> 2 Months Ago</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row justify-content-center my-5">
                                <div class="col-auto">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li class="page-item disabled"> <span class="page-link">Previous</span> </li>
                                            <li class="page-item active" aria-current="page"> <span class="page-link"> 1 <span class="sr-only">(current)</span> </span>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">...</li>
                                            <li class="page-item"><a class="page-link" href="#">45</a></li>
                                            <li class="page-item"> <a class="page-link" href="#">Next</a> </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--map -->
                <div class="col-xl-6  pe-0 2">
                    <div id="map" class="map-2"></div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js_after')
    <script src="{{ asset('https://maps.googleapis.com/maps/api/js?key=AIzaSyBoB-nFyi-8EGpAmsNFREAWk3XzUK3RTOA') }}"></script>
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

                console.log(locations)

                for (i = 0; i < locations.length; i++) {
                    var pictureLabel = document.createElement("img");
                    pictureLabel.src = locations[i].image;
                    var boxText = document.createElement("div");
                    infoboxOptions = {
                        content: boxText,
                        disableAutoPan: false,
                        //maxWidth: 150,
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


                    newMarkers.push(marker);
                    boxText.innerHTML =
                        '<div class="featured-thumb hover-zoomer shadow-one">' +
                        '<div class=" overflow-hidden position-relative">' +
                        '<a href="#">' +
                        '<img src="' + locations[i].image + '" alt="">' +
                        '</a>' +

                        '<div class="price bg-primary text-white p-2">' + locations[i].price + ' <span>' + locations[i].for  + '</span></div>' +
                        '</div>' +
                        '<div class="featured-thumb-data">' +
                        '<div class="p-4">' +
                        '<h5 class="text-secondary hover-text-primary mb-2"><a href="' + locations[i].url + '">' + locations[i].title + '</a></h5>' +
                        '<span class="location font-13"><i class="fas fa-map-marker-alt text-primary mr-1" aria-hidden="true"></i> ' + locations[i].address + '</span>' +
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
        (function($) {
            var _latitude = 45.8150107380416;
            var _longitude = 15.981403769351106;
            createHomepageGoogleMap(_latitude, _longitude);
        })(jQuery);
    </script>

@endpush
