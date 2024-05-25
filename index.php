<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />


    
    
    <title>Dashboard</title>
    <script src="Backend/script.js"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .stat-box.dark-mode {
            background-color: #1e1e1e;
        }

        .statistics {
            display: flex;
            justify-content: space-around;
            margin: 20px auto;
            max-width: 1200px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .stat-box {
            min-width: fit-content;
            flex: 1;
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 1s ease-in;
            border: 1px solid;
            border-color: #666;
        }

        .stat-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-content i {
            font-size: 24px;
            margin-right: 10px;
            color: darkgreen;
        }

        .stat-box h2 {
            margin: 0;
            font-size: 24px;
            color: darkgreen;
        }

        .stat-box p {
            margin: 10px 0 0;
            font-size: 18px;
            color: #666;
            font-weight: bold;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 50px auto;
            margin-bottom: 10%;
            height: 600px;
        }

        .left-section {
            flex-basis: 30%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
            border: 1px solid;
            border-color: #666;
        }

        .right-section {
            flex-basis: 70%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid;
            border-color: #666;
        }

        h1,
        h2 {
            text-align: center;
        }

        .list-group {
            padding: 0;
            list-style: none;
            max-height: 500px;
            overflow-y: auto;
        }

        .list-group-item {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 5%px;
            transition: all 0.3s ease;
        }

        .list-group-item label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
            flex-basis: 30%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .list-group-item:hover {
            background-color: #e9e9e9;
            transition: opacity 0.3s;
        }

        .form-group2 {
            margin-bottom: 20px;
            flex-basis: 30%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
            appearance: none;
        }

        .filter_options {
            margin-bottom: 10px;
        }

        #map {
            height: 500px;
            margin: 20px auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-color: #121212;
            width: 1290px;
            border-radius: 3px;
            border: solid 1px;
            border-color: #666;
        }

        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
        }

        /* Popup styles */
        #chartPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            z-index: 1000;
        }

        #closePopup {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>

<body>

    <div id="particles-js"></div>

    <?php include 'Navbar.php'; ?>
    <?php include 'Footer.php'; ?>

    <div class="statistics">
        <div class="stat-box">
            <h2><i class='bx bxs-user-detail'></i> <span id="totalOrders">0</span></h2>
            <p>Total Orders</p>
        </div>
        <div class="stat-box">
            <h2><i class='bx bxs-dollar-circle'></i> <span id="totalRevenue">$0.00</span></h2>
            <p>Total Revenue</p>
        </div>
        <div class="stat-box">
            <h2><i class='bx bxs-group'></i> <span id="totalCustomers">0</span></h2>
            <p>Total Customers</p>
        </div>
        <div class="stat-box">
            <h2><i class='bx bxs-box'></i> <span id="totalProducts">0</span></h2>
            <p>Total Products</p>
        </div>
    </div>


    <div id="map"></div>

    <div class="container">
        <div class="left-section">
            <?php if (isset($error_message)) : ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="filter_options">Select Time Range</label>
                <select id="filter_options" name="filter_options">
                    <option value="all">ALL</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>
            <div class="form-group2">
                <label for="filter_options">Theme</label>
                <select id="filter_options1" name="filter_options1">
                    <option value="list">List</option>
                    <option value="chart">Chart</option>
                </select>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="firstRadio" checked>
                    <label class="form-check-label" for="firstRadio">Best seller product</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="secondRadio">
                    <label class="form-check-label" for="secondRadio">Turnover</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="thirdRadio">
                    <label class="form-check-label" for="thirdRadio">Customer Count</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="fourthRadio">
                    <label class="form-check-label" for="fourthRadio">Best ?</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="fifthRadio">
                    <label class="form-check-label" for="fifthRadio">Order Count</label>
                </li>
            </ul>
        </div>
        <div class="right-section">
            <h1>Statistics</h1>
            <div id="chartContainer">
                <canvas id="myChart"></canvas>
            </div>
            <ul class="list-group" id="dataList">
                <!-- Placeholder for list data -->
            </ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="storeModal" tabindex="-1" aria-labelledby="storeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="storeModalLabel">Store Statistics</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <canvas id="storeChart"></canvas>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            var map = L.map('map').setView([37.7749, -122.4194], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            function fetchLocations() {
                fetch('/Backend/map.php')
                    .then(response => response.json())
                    .then(locations => {
                        console.log("Locations fetched: ", locations);
                        var markers = locations.map(function(location) {
                            var marker = L.marker([location.latitude, location.longitude]);

                            marker.on('click', function() {
                                console.log(`Fetching statistics for store ID: ${location.storeID}`);
                                fetchStoreStatistics(location, marker);
                            });

                            return marker;
                        });

                        var featureGroup = L.featureGroup(markers).addTo(map);
                        map.fitBounds(featureGroup.getBounds());
                    })
                    .catch(error => {
                        console.error('Error fetching map data:', error);
                    });
            }

            function fetchStoreStatistics(location, marker) {
                fetch(`/Backend/get_store_statistics.php?storeID=${location.storeID}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Statistics fetched: ", data);
                        var popupContent = `
                <b>Store ID:</b> ${location.storeID}<br>
                <b>City:</b> ${location.city}<br>
                <b>Zip Code:</b> ${location.zipcode}<br>
                <b>State:</b> ${location.state} (${location.state_abbr})<br>
                <canvas id="storeChart" width="200" height="150"></canvas>`;
                        marker.bindPopup(popupContent).openPopup();

                        setTimeout(() => {
                            var ctx = document.getElementById('storeChart');
                            if (ctx) {
                                ctx = ctx.getContext('2d');

                                var chart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: ['Total Orders', 'Total Revenue', 'Total Customers'],
                                        datasets: [{
                                            data: [data[0].totalOrders, data[0].totalRevenue, data[0].totalCustomers],
                                            backgroundColor: [
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        let label = context.label || '';
                                                        if (label) {
                                                            label += ': ';
                                                        }
                                                        if (context.raw !== null) {
                                                            label += context.raw.toLocaleString();
                                                        }
                                                        return label;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            } else {
                                console.error('Canvas element not found');
                            }
                        }, 300);
                    })
                    .catch(error => {
                        console.error('Error fetching store statistics: ', error);
                    });
            }
            fetchLocations();
        });
    </script>
</body>



<script type="text/javascript " src="particles.js "></script>
<script src="app.js "></script>

</body>

</html>