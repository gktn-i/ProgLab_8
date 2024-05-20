<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Locator Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 800px;
            width: 90%;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>
    <?php include 'Footer.php'; ?>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // AJAX-Anfrage, um die Standortdaten von map.php zu erhalten
        fetch('/Backend/map.php')
            .then(response => response.json())
            .then(locations => {
                var map = L.map('map').setView([51.505, -0.09], 2); 

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                locations.forEach(function (location) {
                    var marker = L.marker([location.latitude, location.longitude]).addTo(map);
                    marker.bindPopup(
                        '<b>Store ID:</b> ' + location.storeID + '<br>' +
                        '<b>City:</b> ' + location.city + '<br>' +
                        '<b>Zip Code:</b> ' + location.zipcode + '<br>' +
                        '<b>State:</b> ' + location.state + ' (' + location.state_abbr + ')'
                    );
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
</body>

</html>
