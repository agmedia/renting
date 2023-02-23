@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('google.maps-key') }}&libraries=places" ></script>
    <script type="text/javascript">

        var map;
        var geocoder;
        var mapOptions = { center: new google.maps.LatLng(0.0, 0.0), zoom: 2,
            mapTypeId: google.maps.MapTypeId.ROADMAP };

        function initialize() {
            var myOptions = {
                center: new google.maps.LatLng({{ (isset($apartment) && $apartment->latitude) ? $apartment->latitude : '45.8059448' }}, {{ (isset($apartment) && $apartment->longitude) ? $apartment->longitude : '15.9787596' }} ),
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            geocoder = new google.maps.Geocoder();
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            CurrentLocation = new google.maps.LatLng({{ (isset($apartment) && $apartment->latitude) ? $apartment->latitude : '45.8059448' }}, {{ (isset($apartment) && $apartment->longitude) ? $apartment->longitude : '15.9787596' }});

            defaultMarker(CurrentLocation);

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                      //  console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };


                    markers.push(new google.maps.Marker({
                        map: map,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    getAddress(place.geometry.location);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });

                map.fitBounds(bounds);
            });

            var marker;
            function placeMarker(location) {
                if (marker) { //on vérifie si le marqueur existe
                    marker.setPosition(location); //on change sa position
                } else {
                    marker = new google.maps.Marker({ //on créé le marqueur
                        position: location,
                        map: map
                    });
                }

                document.getElementById('txtLat').value=location.lat().toFixed(7);
                document.getElementById('txtLng').value=location.lng().toFixed(7);
                getAddress(location);
            }


            var marker;
            function defaultMarker(location) {
                if (marker) { //on vérifie si le marqueur existe
                    marker.setPosition(location); //on change sa position
                } else {
                    marker = new google.maps.Marker({ //on créé le marqueur
                        position: location,
                        map: map
                    });
                }
            }

            /**
             *
             * @param latLng
             */
            function getAddress(latLng) {
                geocoder.geocode( {'latLng': latLng},
                    function(results, status) {
                        if(status == google.maps.GeocoderStatus.OK) {
                            if(results[0]) {

                                document.getElementById("pac-input").value = '';
                             //   console.log(results[0].address_components);
                                var arrAddress = results[0].address_components;
                                var itemRoute='';
                                var itemLocality='';
                                var itemCountry='';
                                var itemPc='';
                                var itemSnumber='';

                                // iterate through address_component array
                                $.each(arrAddress, function (i, address_component) {
                                  //  console.log('address_component:'+i);

                                    if (address_component.types[0] == "route"){
                                      //  console.log(i+": route:"+address_component.long_name);
                                        itemRoute = address_component.long_name;
                                    }

                                    if (address_component.types[0] == "locality"){
                                     //   console.log("town:"+address_component.long_name);
                                        itemLocality = address_component.long_name;
                                    }

                                    if (address_component.types[0] == "country"){
                                    //    console.log("country:"+address_component.long_name);
                                        itemCountry = address_component.long_name;
                                    }

                                    if (address_component.types[0] == "postal_code"){
                                      //  console.log("pc:"+address_component.long_name);
                                        itemPc = address_component.long_name;
                                    }

                                    if (address_component.types[0] == "street_number"){
                                       // console.log("street_number:"+address_component.long_name);
                                        itemSnumber = address_component.long_name;
                                    }
                                    //return false; // break the loop
                                });


                                document.getElementById("address").value = itemRoute +', ' + itemSnumber;
                                document.getElementById("city").value = itemLocality;
                                document.getElementById("zip").value = itemPc;
                                document.getElementById("state").value = itemCountry;

                                document.getElementById('txtLat').value=latLng.lat().toFixed(7);
                                document.getElementById('txtLng').value=latLng.lng().toFixed(7);


                            }
                            else {
                                document.getElementById("address").value = "No results";
                            }
                        }
                        else {
                            document.getElementById("address").value = status;
                        }
                    });
            }
        }
    </script>

    @stack('gallery_css')

    @if (isset($js_lang))
        <script>
            window.trans = {!! $js_lang !!};
            window.locale = "{{ current_locale() }}";
        </script>
    @endif

@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">
                    <a class="btn btn-light js-tooltip-enabled" style="margin-bottom: 5px;" href="{{ route('apartments') }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Top Tooltip">
                        <i class="fa fa-arrow-left mr-1"></i>
                    </a>
                    {{ __('back/apartment.edit') }}
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('apartments') }}">{{ __('back/apartment.titles') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('back/apartment.edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content content-full">
        @include('back.layouts.partials.session')

        <form action="{{ isset($apartment) ? route('apartments.update', ['apartman' => $apartment]) : route('apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($apartment))
                {{ method_field('PATCH') }}
            @endif

            <div id="main-content-block" class="block ">
                <div class="block-header block-header-default">
                    <h3 class="block-title" > <a href="#" onclick="Dashmix.block('content_toggle', '#main-content-block');">{{ __('back/apartment.osnovneinformacije') }}</a></h3>

                    <div class="block-options">
                        <button type="submit" class="btn btn-hero-success my-2">
                            <i class="fas fa-save mr-1"></i> {{ __('back/apartment.btnsnimi') }}
                        </button>
                        <div class="custom-control custom-switch custom-control-info block-options-item ml-4">
                            <input type="checkbox" class="custom-control-input" id="featured-switch" name="featured" @if (isset($apartment) and $apartment->featured) checked @endif>
                            <label class="custom-control-label" style="padding-top: 2px;" for="featured-switch">{{ __('back/apartment.featured') }}</label>
                        </div>
                        <div class="custom-control custom-switch custom-control-success block-options-item ml-4">
                            <input type="checkbox" class="custom-control-input" id="status-switch" name="status" @if (isset($apartment) and $apartment->status) checked @endif>
                            <label class="custom-control-label"style="padding-top: 2px;" for="status-switch">{{ __('back/apartment.status') }}</label>
                        </div>

                        <button type="button" class="btn btn-sm btn-alt-secundary" data-toggle="block-option" data-action="fullscreen_toggle"></button>

                        <button type="button" class="btn btn-sm btn-success" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
                </div>

                <div  class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-11">
                            <div class="form-group row items-push">
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <div class="col-md-12 mt-3 mb-3">
                                            <label for="dm-post-edit-title" class="w-100" >{{ __('back/apartment.nazivapartmana') }} @include('back.layouts.partials.required-star')
                                                <ul class="nav nav-pills float-right">
                                                    @foreach(ag_lang() as $lang)
                                                        <li @if ($lang->code == current_locale()) class="active" @endif>
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
                                                        <input type="text" class="form-control" id="title-input-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($apartment) ? $apartment->translation($lang->code)->title : old('title.*') }}">
                                                        @error('title.*')
                                                        <span class="text-danger font-italic">{{ __('back/apartment.nazivapartmana_error') }}</span>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="type-select">{{ __('back/apartment.tip') }} @include('back.layouts.partials.required-star')</label>
                                            <select class="js-select2 form-control" id="type-select" name="type" style="width: 100%;">
                                                <option></option>
                                                @foreach (config('settings.apartment_types') as $select_item)
                                                    <option value="{{ $select_item['id'] }}" {{ ((isset($apartment)) and ($select_item['id'] == $apartment->type)) ? 'selected' : (( ! isset($apartment) and ($select_item['default'] == 1)) ? 'selected' : '') }}>{{ $select_item['title'][app()->getLocale()] }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <span class="text-danger font-italic">{{ __('back/app.type_error') }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="target-select">{{ __('back/apartment.namjena') }} @include('back.layouts.partials.required-star')</label>
                                            <select class="js-select2 form-control" id="target-select" name="target" style="width: 100%;">
                                                <option></option>
                                                @foreach (config('settings.apartment_targets') as $select_item)
                                                    <option value="{{ $select_item['id'] }}" {{ ((isset($apartment)) and ($select_item['id'] == $apartment->target)) ? 'selected' : (( ! isset($apartment) and ($select_item['default'] == 1)) ? 'selected' : '') }}>{{ $select_item['title'][app()->getLocale()] }}</option>
                                                @endforeach
                                            </select>
                                            @error('target')
                                            <span class="text-danger font-italic">{{ __('back/app.type_error') }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="sku">{{ __('back/apartment.sifra') }}</label>
                                            <input type="text" class="form-control" name="sku" placeholder="" value="{{ isset($apartment) ? $apartment->sku : old('sku') }}">
                                        </div>

                                        <div class="col-sm-12 mt-4">
                                            <div class="row">
                                                <div class="col-md-6 col-xl-3">
                                                    <label for="dm-post-edit-title">{{ __('back/apartment.m2') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="m2-input" name="m2" placeholder="" value="{{ isset($apartment) ? $apartment->m2 : old('m2') }}">

                                                </div>
                                                <div class="col-md-6 col-xl-3">
                                                    <label for="dm-post-edit-title">{{ __('back/apartment.brojsoba') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="rooms-input" name="rooms" placeholder="" value="{{ isset($apartment) ? $apartment->rooms : old('rooms') }}">

                                                </div>
                                                <div class="col-md-6 col-xl-3">
                                                    <label for="dm-post-edit-title">{{ __('back/apartment.brojkreveta') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="beds-input" name="beds" placeholder="" value="{{ isset($apartment) ? $apartment->beds : old('beds') }}">

                                                </div>
                                                <div class="col-md-6 col-xl-3">
                                                    <label for="dm-post-edit-title">{{ __('back/apartment.brojkupaonica') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="baths-input" name="baths" placeholder="" value="{{ isset($apartment) ? $apartment->baths : old('baths') }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h2 class="content-heading">
                                        {{ __('back/apartment.opis') }}
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
                                    </h2>
                                    <div class="form-group row mb-4">
                                        <div class="col-md-12">
                                            <div class="tab-content">
                                                @foreach(ag_lang() as $lang)
                                                    <div id="description-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                                        <textarea id="description-editor-{{ $lang->code }}" name="description[{{ $lang->code }}]" placeholder="{{ $lang->code }}">{!! isset($apartment) ? $apartment->translation($lang->code)->description : old('description.*') !!}</textarea>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <h2 class="content-heading">{{ __('back/apartment.regularandmax') }}</h2>

                                    <div class="row justify-content-center push mb-0">
                                        <div class="col-md-12 pt-2">
                                            <div class="form-group row items-push mb-0">
                                                <div class="col-md-6 col-xl-3">
                                                    <label for="regular-person-input">{{ __('back/apartment.regular') }} @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control" id="regular-person-input" name="regular_persons" placeholder="" value="{{ isset($apartment) ? $apartment->regular_persons : old('regular_persons') }}">
                                                </div>
                                                <div class="col-md-6 col-xl-3">
                                                    <label for="max-adults-input">{{ __('back/apartment.max') }}. {{ __('back/apartment.adults') }} @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control" id="max-adults-input" name="max_adults" placeholder="" value="{{ isset($apartment) ? $apartment->max_adults : old('max_adults') }}">
                                                </div>
                                                <div class="col-md-6 col-xl-3">
                                                    <label for="max-children-input">{{ __('back/apartment.max') }}. {{ __('back/apartment.children') }} @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control" id="max-children-input" name="max_children" placeholder="" value="{{ isset($apartment) ? $apartment->max_children : old('max_children') }}">
                                                </div>
                                                <div class="col-md-6 col-xl-3">
                                                    <label for="max-persons-input">{{ __('back/apartment.max') }}. {{ __('back/apartment.person') }}  @include('back.layouts.partials.required-star')</label>
                                                    <input type="text" class="form-control" id="max-persons-input" name="max_persons" placeholder="" value="{{ isset($apartment) ? $apartment->max_persons : old('max_persons') }}">
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <h2 class="content-heading">{{ __('back/apartment.sync_url') }}</h2>

                                    <div class="form-group row justify-content-center push mb-0">
                                        <div class="col-md-12 pt-2">
                                            <label for="airbnb-input">Airbnb</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="airbnb-input" name="links[airbnb]" placeholder="Airbnb ics or iCal URL..." value="{{ isset($apartment->airbnb['link']) ? $apartment->airbnb['link'] : '' }}">
                                                @if (isset($apartment->airbnb['link']) && $apartment->airbnb['link'] != '')
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-alt-dark" id="airbnb-sync-btn">{{ __('back/apartment.sync') }}</button>
                                                    </div>
                                                @endif
                                            </div>
                                            @if (isset($apartment->airbnb['link']) && $apartment->airbnb['link'] != '')
                                                <p class="font-size-sm float-right">
                                                    {{ isset($apartment->airbnb['updated']) ? $apartment->airbnb['updated'] : '' }}
                                                    <i class="fa {{ isset($apartment->airbnb['icon']) ? $apartment->airbnb['icon'] : '' }} ml-2"></i>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-12 pt-2">
                                            <label for="booking-input">Booking</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="booking-input" name="links[booking]" placeholder="Booking ics or iCal URL..." value="{{ isset($apartment->booking['link']) ? $apartment->booking['link'] : '' }}">
                                                @if (isset($apartment->booking['link']) && $apartment->booking['link'] != '')
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-alt-dark" id="booking-sync-btn">{{ __('back/apartment.sync') }}</button>
                                                    </div>
                                                @endif
                                            </div>
                                            @if (isset($apartment->booking['link']) && $apartment->booking['link'] != '')
                                                <p class="font-size-sm float-right">
                                                    {{ isset($apartment->booking['updated']) ? $apartment->booking['updated'] : '' }}
                                                    <i class="fa {{ isset($apartment->booking['icon']) ? $apartment->booking['icon'] : '' }} ml-2"></i>
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div id="location-block" class="block ">
                <div class="block-header block-header-default ">
                    <h3 class="block-title"><a href="#" onclick="Dashmix.block('content_toggle', '#location-block');">{{ __('back/apartment.lokacija') }}</a></h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-secundary" data-toggle="block-option" data-action="fullscreen_toggle"></button>

                        <button type="button" class="btn btn-sm btn-success" data-toggle="block-option" data-action="content_toggle"></button>

                    </div>
                </div>

                <div class="block-content block-content-full">
                    <div class="row justify-content-center push">
                        <div class="col-md-11">
                            <div class="form-group row items-push mt-3">
                                <div class="col-md-12">
                                    <label for="dm-post-edit-title">{{ __('back/apartment.ulica') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="" value="{{ isset($apartment) ? $apartment->address : old('address') }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">{{ __('back/apartment.grad') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="" value="{{ isset($apartment) ? $apartment->city : old('city') }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">{{ __('back/apartment.zip') }}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="" value="{{ isset($apartment) ? $apartment->zip : old('zip') }}" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="dm-post-edit-title">{{ __('back/apartment.drzava') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="state" name="state" placeholder="" value="{{ isset($apartment) ? $apartment->state : old('state') }}" readonly>
                                </div>

                                <div class="col-md-6 ">
                                    <label for="dm-post-edit-title">{{ __('back/apartment.latitude') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtLat" name="latitude" placeholder="" value="{{ isset($apartment) ? $apartment->latitude : old('latitude') }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="dm-post-edit-title">{{ __('back/apartment.longitude') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtLng" name="longitude" placeholder="" value="{{ isset($apartment) ? $apartment->longitude : old('longitude') }}" readonly>
                                </div>
                                <div class="col-md-12">
                                    <div class="alert alert-info mb-0" role="alert">
                                        <i class="fa fa-info-circle"></i> {{ __('back/apartment.porukakarta') }}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <input
                                            id="pac-input"
                                            class="controls form-control "
                                            type="text"
                                            placeholder="{{ __('back/apartment.searchaddress') }}" style="height:42px;margin-top:9px;width:400px;border-radius:0"
                                    />
                                    <div id="map_canvas" style="width: auto; height: 500px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prices -->
            <div id="prices-block" class="block ">
                <div class="block-header block-header-default">
                    <h3 class="block-title"><a href="#" onclick="Dashmix.block('content_toggle', '#prices-block');">{{ __('back/apartment.cijenetitle') }}</a></h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-secundary" data-toggle="block-option" data-action="fullscreen_toggle"></button>

                        <button type="button" class="btn btn-sm btn-success" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
                </div>

                <div class="block-content block-content-full">
                    <div class="row justify-content-center push">
                        <div class="col-md-11">
                            <div class="form-group row items-push mt-3">
                                <div class="col-md-5">
                                    <label for="dm-post-edit-title">{{ __('back/apartment.price_regular') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="price-regular-input" name="price_regular" placeholder="" value="{{ isset($apartment) ? $apartment->price_regular : old('price_regular') }}">
                                    @error('price')
                                    <span class="text-danger font-italic">{{ __('back/app.type_error') }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="dm-post-edit-title">{{ __('back/apartment.price_weekends') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="price-weekends-input" name="price_weekends" placeholder="" value="{{ isset($apartment) ? $apartment->price_weekends : old('price_weekends') }}">
                                    @error('price')
                                    <span class="text-danger font-italic">{{ __('back/app.type_error') }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="price-input">{{ __('back/apartment.tax') }}</label>
                                    <select class="js-select2 form-control" id="tax-select" name="tax_id" style="width: 100%;" data-placeholder="{{ __('back/apartment.select') }}">
                                        <option></option>
                                        @foreach ($data['taxes'] as $tax)
                                            <option value="{{ $tax->id }}" {{ ((isset($product)) and ($tax->id == $product->tax_id)) ? 'selected' : (( ! isset($product) and ($tax->id == 1)) ? 'selected' : '') }}>{{ $tax->title->{current_locale()} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <h2 class="content-heading">{{ __('back/apartment.discount') }}
                                <a class="btn btn-sm btn-secondary float-right" href="{{ route('actions.create') }}">
                                    <i class="far fa-fw fa-plus-square"></i>
                                </a>
                            </h2>

                            <div class="form-group row items-push mb-3">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        @if (isset($apartment))
                                            @foreach ($apartment->action()->get() as $action)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $action->title }}</strong><br>
                                                        <small>{{ __('back/apartment.duration') }}:</small> {{ $action->date_start ? \Illuminate\Support\Carbon::make($action->date_start)->format('d.m.Y') : 'From Begining' }} - {{ $action->date_end ? \Illuminate\Support\Carbon::make($action->date_end)->format('d.m.Y') : 'To Indefinitly' }}
                                                    </td>
                                                    <td>
                                                        <small>{{ __('back/apartment.amount') }}:</small>
                                                        @if ($action->type == 'P')
                                                            @if ($action->discount > 0)
                                                                <strong>-{{ number_format($action->discount) }}%</strong> {{ __('back/apartment.title_discount') }}
                                                            @else
                                                                <strong>+{{ number_format($action->extra) }}%</strong> {{ __('back/apartment.extra') }}
                                                            @endif
                                                        @endif
                                                        @if ($action->type == 'F')
                                                            <strong>{{ number_format(($action->discount > 0) ? $action->discount : $action->extra, 2) }} kn</strong> Fixed
                                                        @endif
                                                        <br>
                                                        <small>Status: </small>
                                                        @include('back.layouts.partials.status', ['status' => $action->status, 'simple' => true])
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-sm btn-alt-secondary" href="{{ route('actions.edit', ['action' => $action]) }}">
                                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <!-- -->
                            <h2 class="content-heading">{{ __('back/apartment.apo_title') }}
                                <a class="btn btn-sm btn-secondary float-right" href="{{ route('options.create') }}">
                                    <i class="far fa-fw fa-plus-square"></i>
                                </a>
                            </h2>

                            <div class="form-group row items-push mb-3">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        @if (isset($apartment))
                                            @foreach ($apartment->options()->get() as $item)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $item->title }}</strong><br>
                                                    </td>
                                                    <td>
                                                        <small>{{ __('back/apartment.price') }}:</small>
                                                        {{ number_format($item->price, 2, ',', '.') }}
                                                        <br>
                                                        <small>{{ __('back/apartment.status') }}: </small>
                                                        @include('back.layouts.partials.status', ['status' => $item->status, 'simple' => true])
                                                        <small>{{ __('back/apartment.featured') }}: </small>
                                                        @include('back.layouts.partials.status', ['status' => $item->featured, 'simple' => true])
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-sm btn-alt-secondary" href="{{ route('options.edit', ['option' => $item]) }}">
                                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amenities -->
            <div id="amenities-block" class="block ">
                <div class="block-header block-header-default">
                    <h3 class="block-title"><a href="#" onclick="Dashmix.block('content_toggle', '#amenities-block');">{{ __('back/apartment.amenities') }}</a></h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-secundary" data-toggle="block-option" data-action="fullscreen_toggle"></button>

                        <button type="button" class="btn btn-sm btn-success" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
                </div>

                <div class="block-content block-content-full">
                    <div class="row justify-content-center push">
                        <div class="col-md-11">

                            @foreach ($data['amenities'] as $group => $items)
                                <h2 class="content-heading">{{ $group }}</h2>

                                <div class="form-group row items-push mb-0">
                                    @foreach ($items as $detail)
                                        <div class="col-md-4">
                                            <div class="custom-control custom-switch custom-control-lg mb-2">
                                                <input type="checkbox" class="custom-control-input" name="amenity[{{ $detail['id'] }}]" @if($detail['status']) checked @endif>
                                                <label class="custom-control-label" for="example-sw-custom-lg1"><img src ="{{ asset('media/icons') }}/{{ $detail['icon'] }}" class="icon"/> {{ $detail['title'] }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Input -->
            <div id="details-block" class="block ">
                <div class="block-header block-header-default">
                    <h3 class="block-title"><a href="#" onclick="Dashmix.block('content_toggle', '#details-block');">{{ __('back/apartment.dodatneinformacije') }}</a></h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-secundary" data-toggle="block-option" data-action="fullscreen_toggle"></button>

                        <button type="button" class="btn btn-sm btn-success" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
                </div>

                <div class="block-content block-content-full">
                    <div class="row justify-content-center push" id="placeholder-ag-apartment-details-input">
                        <ag-apartment-details-input
                                favorites="{{ $data['favorites']->toJson() }}"
                                details="{{ $data['details']->toJson() }}"
                                galleries="{{ $data['galleries']->toJson() }}"
                                languages="{{ ag_lang() }}"
                                locale="{{ current_locale() }}"></ag-apartment-details-input>
                    </div>
                </div>
            </div>

            <!-- Gallery -->
            <div id="gallery-block" class="block ">
                <div class="block-header block-header-default">
                    <h3 class="block-title"><a href="#" onclick="Dashmix.block('content_toggle', '#gallery-block');">{{ __('back/apartment.galerijainfo') }}</a><span class="text-sm ml-3">{{ count($data['images']) }}</span></h3>
                    <div class="block-options">
                        @if (isset($apartment))
                            <a href="{{ route('apartments.image.fix', ['apartman' => $apartment]) }}" class="btn btn-sm btn-alt-info mr-3">Fix Images</a>
                        @endif
                        <button type="button" class="btn btn-sm btn-alt-secundary" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            @include('back.apartment.edit-photos', ['resource' => isset($apartment) ? $apartment : null, 'existing' => $data['images'], 'delete_url' => route('apartments.destroy.image')])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="block">
                <div class="block-content">
                    <div class="row justify-content-center push">

                        <div class="col-md-6 ">
                            @if (isset($apartment))
                                <a href="{{ route('apartments.destroy', ['apartman' => $apartment]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Obriši" onclick="event.preventDefault(); document.getElementById('delete-gallery-form{{ $apartment->id }}').submit();">
                                    <i class="fa fa-trash-alt"></i> {{ __('back/apartment.delete') }}
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-hero-success my-2">
                                <i class="fas fa-save mr-1"></i> {{ __('back/apartment.btnsnimi') }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </form>

        @if (isset($apartment))
            <form id="delete-gallery-form{{ $apartment->id }}" action="{{ route('apartments.destroy', ['apartman' => $apartment]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>
@endsection

@push('modals')

    <div class="modal fade" id="images-modal" tabindex="-1" role="dialog" aria-labelledby="images-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-xl" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/apartment.slike') }}</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">

                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/apartment.btnodustani') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-success" onclick="event.preventDefault(); confirmDelete();">
                            {{ __('back/apartment.btnsnimi') }} <i class="fa fa-save ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>

    <script src="{{ asset('js/ag-apartment-details-input.js') }}"></script>

    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['datepicker']);});</script>

    <script>
        /**
         *
         * @param target
         * @param url
         * @param apartment
         */
        function syncUrlWith(target, url, apartment) {
            let item = {
                apartment: apartment,
                target: target,
                url:url
            };

            axios.post("{{ route('api.apartments.sync.url') }}", item)
            .then(response => {
                if (response.data.success) {
                    successToast.fire(response.data.success).then(() => {
                        location.reload();
                    })

                } else {
                    errorToast.fire(response.data.error);
                }
            });
        }

        /**
         * @__constructor
         */
        $(() => {
            initialize();

            {!! ag_lang() !!}.forEach(function(item) {
                ClassicEditor
                .create(document.querySelector('#description-editor-' + item.code))
                .then(editor => {
                    //console.log(editor);
                })
                .catch(error => {
                    //console.error(error);
                });
            });

            $('#tax-select').select2({ minimumResultsForSearch: Infinity });

            $('#favorite-select').select2();
            $('#size-select').select2({ minimumResultsForSearch: Infinity });
            $('#icon-select').select2({ tags: true });
            $('#gallery-select').select2();

            $('#type-select').select2({ minimumResultsForSearch: Infinity });
            $('#target-select').select2({ minimumResultsForSearch: Infinity });
            $('#price-by-select').select2({ minimumResultsForSearch: Infinity });

            $('#airbnb-sync-btn').on('click', (e) => {
                syncUrlWith('airbnb', $('#airbnb-input').val(), {{ isset($apartment) ? $apartment->id : 0 }});
            });
            $('#booking-sync-btn').on('click', (e) => {
                syncUrlWith('booking', $('#booking-input').val(), {{ isset($apartment) ? $apartment->id : 0 }});
            });

        });
    </script>

    <script>

        /**
         *
         * @param item
         * @param type
         */
        function openModal(item = {}) {
            //console.log(item);

            $('#images-modal').modal('show');
            //editStatus(item);
        }
    </script>

    @stack('gallery_scripts')

@endpush
