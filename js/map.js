var directionsDisplay;
var map;


function afficheCarte(lat, lng) {
    pop_content('<div id=\'map\'></div>');
    var h = google.maps.event.addDomListener(window, 'load', creaMap(lat,lng));
    pop_set_x(473);
    pop_set_y(473);
    pop_close_func(removelistener(h));
    pop_show();
}

function removelistener(h){
    google.maps.event.removeListener(h);
}

function creaMap(lat,lng){

    var mapOptions = {
        center: new google.maps.LatLng(lat, lng),
        zoom: 12
    };

    var carte = new google.maps.Map(document.getElementById("map"),mapOptions);
}

function afficheItineraire(start,end){
    google.maps.event.addDomListener(window, 'load', itineraire());
    calcRoute(start,end);
}

function itineraire(){

    directionsDisplay = new google.maps.DirectionsRenderer();
    var mapOptions = {
        zoom:7
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    directionsDisplay.setMap(map);
}

function calcRoute(start,end) {
    var request = {
        origin:start,
        destination:end,
        travelMode: google.maps.TravelMode.DRIVING
    };
    var directionsService = new google.maps.DirectionsService();
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}