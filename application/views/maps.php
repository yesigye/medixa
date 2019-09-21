<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      #map {
        width: 300px;
        height: 300px;
        margin: 10px 0px 0px 10px;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <button type="button" onClick="addMarker()"></button>
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZaE9sXlm3yQvvXb8giZF6tRQ1VpQqDaI&callback=initMap"
    async defer></script>
    <script>
        var directionDisplay;
        var directionsService = new google.maps.DirectionsService();
        var map;

        function initMap() {
        // The location of Uluru
        var uluru = {lat: -25.344, lng: 131.036};

        directionsDisplay = new google.maps.DirectionsRenderer();
        
        var mapOptions =  {
            center: uluru,
            zoom: 8
        };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: uluru, map: map});
        marker.set("id", 123);

        marker.addListener('click', function() {
            console.log(marker.id)
        });
        }

        function calcRoute() {
            var start = document.getElementById("start").value;
            var end = document.getElementById("end").value;
            var request = {
                origin:start, 
                destination:end,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                }
            });
        }
    </script>
  </body>
</html>