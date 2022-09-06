var mapStyles = [
    {
        "featureType": "all",
        "elementType": "labels.text",
        "stylers": [
            {
                "color": "#878787"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f7f7f7"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f5f5f5"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#c9c9c9"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#aee0f4"
            }
        ]
    }
];

$.ajaxSetup({
    cache: true
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Google Map - Homepage
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*

function createHomepageGoogleMap(_latitude,_longitude){
    /!* setMapHeight(); *!/
    if( document.getElementById('map') != null ){
        $.getScript("assets/js/map/locations.js", function(){
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
            for (i = 0; i < locations.length; i++) {
                var pictureLabel = document.createElement("img");
                pictureLabel.src = locations[i][7];
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
                    title: locations[i][1],
                    position: new google.maps.LatLng(locations[i][3], locations[i][4]),
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
							'<img src="' + locations[i][6] + '" alt="">' +
							'</a>' +

							'<div class="price bg-primary text-white p-2">' + locations[i][2] + ' <span class="text-white">' + locations[i][9]  + '</span></div>' +
						'</div>' +
						'<div class="featured-thumb-data">' +
							'<div class="p-4">' +
								'<h5 class="text-secondary hover-text-primary mb-2"><a href="' + locations[i][5] + '">' + locations[i][0] + '</a></h5>' +
								'<span class="location font-13"><i class="fas fa-map-marker-alt text-primary mr-1" aria-hidden="true"></i> ' + locations[i][1] + '</span>' +
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

        });
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
*/




