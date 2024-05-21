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

        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
        }

        .map-section {
            flex: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);

        }

        h1 {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>
    <?php include 'Footer.php'; ?>

    <div class="container">
        <div class="map-section">
            <h1 style="margin-bottom: 40px;">Maps</h1>

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

                            locations.forEach(function(location) {
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
        </div>
    </div>
</body>

</html>