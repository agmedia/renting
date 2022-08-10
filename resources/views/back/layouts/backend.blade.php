<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>{{ config('app.name') }}</title>

        <meta name="description" content="{{ config('app.description') }}">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('media/img/faviconbiblos.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/img/faviconbiblos.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/img/faviconbiblos.png') }}">

        <!-- Fonts and Styles -->
        @stack('css_before')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/dashmix.css') }}">

        <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="{{ asset('css/themes/xwork.css') }}"> -->
        @stack('css_after')

        <!-- Scripts -->
        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>



        @livewireStyles

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDb7BR7bJL5O1ABqq9q3ZACc1Rt7eLCii8&libraries=places" ></script>


        <script type="text/javascript">

                var map;
                var geocoder;
                var mapOptions = { center: new google.maps.LatLng(0.0, 0.0), zoom: 2,
                    mapTypeId: google.maps.MapTypeId.ROADMAP };

                function initialize() {
                    var myOptions = {
                        center: new google.maps.LatLng(45.80594482207321, 15.978759628343616 ),
                        zoom: 15,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };




                    geocoder = new google.maps.Geocoder();
                    var map = new google.maps.Map(document.getElementById("map_canvas"),
                        myOptions);
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
                                console.log("Returned place contains no geometry");
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
                        if(marker){ //on vérifie si le marqueur existe
                            marker.setPosition(location); //on change sa position
                        }else{
                            marker = new google.maps.Marker({ //on créé le marqueur
                                position: location,
                                map: map
                            });
                        }
                        document.getElementById('txtLat').value=location.lat();
                        document.getElementById('txtLng').value=location.lng();
                        getAddress(location);
                    }



                    function getAddress(latLng) {
                        geocoder.geocode( {'latLng': latLng},
                            function(results, status) {
                                if(status == google.maps.GeocoderStatus.OK) {
                                    if(results[0]) {

                                        document.getElementById("pac-input").value = '';
                                        console.log(results[0].address_components);
                                        var arrAddress = results[0].address_components;
                                        var itemRoute='';
                                        var itemLocality='';
                                        var itemCountry='';
                                        var itemPc='';
                                        var itemSnumber='';

                                        // iterate through address_component array
                                        $.each(arrAddress, function (i, address_component) {
                                            console.log('address_component:'+i);

                                            if (address_component.types[0] == "route"){
                                                console.log(i+": route:"+address_component.long_name);
                                                itemRoute = address_component.long_name;
                                            }

                                            if (address_component.types[0] == "locality"){
                                                console.log("town:"+address_component.long_name);
                                                itemLocality = address_component.long_name;
                                            }

                                            if (address_component.types[0] == "country"){
                                                console.log("country:"+address_component.long_name);
                                                itemCountry = address_component.long_name;
                                            }

                                            if (address_component.types[0] == "postal_code"){
                                                console.log("pc:"+address_component.long_name);
                                                itemPc = address_component.long_name;
                                            }

                                            if (address_component.types[0] == "street_number"){
                                                console.log("street_number:"+address_component.long_name);
                                                itemSnumber = address_component.long_name;
                                            }
                                            //return false; // break the loop
                                        });


                                        document.getElementById("address").value = itemRoute +', ' + itemSnumber;
                                        document.getElementById("city").value = itemLocality;
                                        document.getElementById("zip").value = itemPc;
                                        document.getElementById("country").value = itemCountry;

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
    </head>
    <body onload="initialize();">

        <div id="page-container" class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">

            @include('back.layouts.partials.aside')

            @include('back.layouts.partials.sidebar')

            @include('back.layouts.partials.topbar')

            <!-- Main Container -->
            <main id="main-container">
                @yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-body-light">
                <div class="content py-0">
                    <div class="row font-size-sm">
                        <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-right">
                            Crafted with <i class="fa fa-heart text-danger"></i> by <a class="font-w600" href="https://www.agmedia.hr" target="_blank">AG media</a>
                        </div>
                        <div class="col-sm-6 order-sm-1 text-center text-sm-left">
                            <a class="font-w600" href="https://www.antikvarijat-biblos.hr" target="_blank">{{ config('app.name') }}</a> &copy; <span data-toggle="year-copy"></span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>

        @stack('modals')

        @livewireScripts

        <!-- END Page Container -->
        <script src="{{ asset('js/dashmix.app.js') }}"></script>
        <script src="{{ asset('/js/laravel.app.js') }}"></script>



        <script>
            const confirmPopUp = Swal.mixin({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success m-5',
                    cancelButton: 'btn btn-danger m-5',
                    input: 'form-control'
                }
            })

            const successToast = Swal.mixin({
                position: 'top-end',
                icon: 'success',
                width: 270,
                showConfirmButton: false,
                timer: 1500
            })

            const errorToast = Swal.mixin({
                type: 'error',
                timer: 3000,
                position: 'top-end',
                showConfirmButton:false,
                toast: true,
            })

        </script>

        <script>
            function slugify(string) {
                const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
                const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
                const p = new RegExp(a.split('').join('|'), 'g')

                return string.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/[^\w\-]+/g, '') // Remove all non-word characters
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, '') // Trim - from end of text
            }
        </script>

        <script>
            /**
             *
             */
            function deleteItem(id, url) {
                Swal.fire({
                    title: 'Obriši..!',
                    text: "Jeste li sigurni da želite obrisati stavak?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Da, obriši!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(url, {id: id})
                        .then(response => {
                            if (response.data.success) {
                                successToast.fire({
                                    timer: 2160
                                });

                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                return errorToast.fire(response.data.message);
                            }
                        });


                    }
                });
            }

            /**
             *
             */
            function confirmDeleteItem(id, url) {

            }
        </script>

        @stack('js_after')
    </body>
</html>
