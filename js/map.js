var directionsDisplay;
var map;

function afficheVille(coord) {
    google.maps.event.addDomListener(window, 'load', creaMap());
    setCenter(coord);
}

function creaMap(){

    var mapOptions = {
        zoom: 12
    };

    map = new google.maps.Map(document.getElementById("map"),mapOptions);
}

function setCenter(coord){
    map.setCenter(coord);
}

function afficheItineraire(start,end){
    google.maps.event.addDomListener(window, 'load', itineraire());
    calcRoute(start,end);
}

function itineraire(){

    directionsDisplay = new google.maps.DirectionsRenderer();
    var mapOptions = {
        zoom:7
    };
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
            document.getElementById("infotemps").innerHTML = response.routes[0].legs[0].duration.text;
        }
    });
}