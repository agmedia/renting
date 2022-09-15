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

function createPropertyGoogleMap(_latitude,_longitude){
    /* setMapHeight(); */
    if( document.getElementById('map-single') != null ){

            var map = new google.maps.Map(document.getElementById('map-single'), {
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

                //Define the infobox
               // newMarkers[i].infobox = new InfoBox(infoboxOptions);


        const image = "public/assets/images/map/marker.png";


        new google.maps.Marker({
            position: map.getCenter(),
            icon: image,
            map: map,
        });









    }
}




