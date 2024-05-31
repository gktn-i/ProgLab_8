<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="Frontend/store_comp.css">


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
            transition: transform 0.3s ease-in-out;
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
            user-select: none
        }

        .stat-box p {
            margin: 10px 0 0;
            font-size: 18px;
            color: #666;
            font-weight: bold;
            user-select: none
        }

        .stat-box:hover {
            transform: translateY(-5px);
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 50px auto;
            margin-bottom: 2%;
            height: 600px;
            animation: fadeIn 1s ease-in;


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
            height: 550px;
            margin: 20px auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-color: #121212;
            width: 1290px;
            border-radius: 3px;
            border: solid 1px;
            border-color: #666;
            animation: fadeIn 1s ease-in;

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

        .chartjs-legend {
            max-height: 70px;
            overflow-y: auto;
            margin-bottom: 5px;
        }

        .popup-content {
            overflow: hidden;
        }

        .leaflet-popup-content-wrapper {
            width: 520;
        }

        .popup-button {
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 4px 2px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            background-color: darkgreen;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .popup-button:hover {
            background-color: #45a049;
        }

        .popup-button:active {
            background-color: #45a049;
        }

        .popup-canvas {
            width: 300px !important;
            height: 200px !important;
        }

        .page-title {
            font-size: 24px;
            top: 0;
            left: 0;

            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div id="particles-js"></div>

    <?php include 'Navbar.php'; ?>


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
            <?php if (isset($error_message)): ?>
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
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="firstRadio"
                        checked>
                    <label class="form-check-label" for="firstRadio">Best seller product</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="secondRadio">
                    <label class="form-check-label" for="secondRadio">Turnover</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="thirdRadio">
                    <label class="form-check-label" for="thirdRadio">Top Customer</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="fourthRadio">
                    <label class="form-check-label" for="fourthRadio">Monthly turnover by category </label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="fifthRadio">
                    <label class="form-check-label" for="fifthRadio">Orders sorted by Stores</label>
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


    <body>
        <div class="comparison-section">
            <h1 class="page-title">Store Comparison</h1>
            <div class="stores-container">
                <div class="store-row">
                    <div class="store-container">
                        <span class="store-label">Store 1:</span>
                        <div class="dropdown-wrapper">
                            <input type="text" id="store1Search" class="search-input" placeholder="Search...">
                            <select id="store1Select" class="dropdown-select"
                                data-placeholder="Choose a Store"></select>
                        </div>
                    </div>
                    <div class="store-container">
                        <span class="store-label">Store 2:</span>
                        <div class="dropdown-wrapper">
                            <input type="text" id="store2Search" class="search-input" placeholder="Search...">
                            <select id="store2Select" class="dropdown-select"
                                data-placeholder="Choose a Store"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="date-filter">
                <label for="startDate" class="font-weight-bold" style="margin-right: 10px;">Start Date:</label>
                <input type="date" id="startDate">
                <label for="endDate" class="font-weight-bold" style="margin-left: 20px; margin-right: 10px;">End
                    Date:</label>
                <input type="date" id="endDate">
                <button id="applyFilter">Apply</button>
            </div>
            <div class="chart-container">
                <canvas id="comparisonChart"></canvas>
            </div>
            <div class="total-revenue-container">
                <h1 class="page-title">Total Revenue</h1>
                <div class="total-revenue">
                    <div class="total-revenue-item">
                        <h1 class="page-titlename">Store 1</h1>
                        <p id="totalRevenueStore1">$0.00</p>
                    </div>
                    <div class="total-revenue-item">
                        <h1 class="page-titlename">Store 2</h1>
                        <p id="totalRevenueStore2">$0.00</p>
                    </div>
                </div>
            </div>
            <div class="total-revenue-container">
                <h1 class="page-title">Best Seller product</h1>
                <div class="best-seller">
                    <div class="best-seller-item">
                        <h1 class="page-titlename">Store 1</h1>
                        <p id="bestsellerproduct1" class="product-name"></p>
                        <p id="bestsellerproduct2" class="product-name"></p>
                        <p id="bestsellerproduct3" class="product-name"></p>
                    </div>
                    <div class="best-seller-item">
                        <h1 class="page-titlename">Store 2</h1>
                        <p id="bestsellerproduct4" class="product-name"></p>
                        <p id="bestsellerproduct5" class="product-name"></p>
                        <p id="bestsellerproduct6" class="product-name"></p>
                    </div>

                </div>

                <!-- JavaScript-Dateien einbinden -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="/Backend/comp-script.js"></script>
    </body>

</html>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="/leaflet.fullscreen/leaflet.fullscreen.css" />
<script src="/leaflet.fullscreen/leaflet.fullscreen.js"></script>
<script>
    $(document).ready(function () {
        var map = L.map('map', {
            fullscreenControl: true,
        }).setView([37.7749, -122.4194], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var resetControl = L.control({
            position: 'topleft'
        });



        resetControl.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            div.style.backgroundColor = 'white';
            div.style.width = '34px';
            div.style.height = '34px';
            div.style.display = 'flex';
            div.style.justifyContent = 'center';
            div.style.alignItems = 'center';
            div.innerHTML = '<i class="bx bx-street-view" style="font-size:20px;"></i>';
            div.title = 'Reset View';
            div.onclick = function () {
                map.setView([37.7749, -122.4194], 5);
            }
            div.onmouseover = function () {
                this.style.backgroundColor = ' #f2f2f2';
            }
            div.onmouseout = function () {
                this.style.backgroundColor = 'white';
            }
            return div;
        };

        resetControl.addTo(map);

        resetControl.addTo(map);

        function fetchLocations() {
            fetch('/Backend/map.php')

                .then(response => response.json())
                .then(locations => {
                    console.log("Locations fetched: ", locations);
                    var markers = locations.map(function (location) {


                        var greenIcon = new L.Icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        });

                        var redIcon = new L.Icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        });


                        var orangeIcon = new L.Icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        });


                        fetch('/Backend/get_total_store_statistics.php?storeID=' + location.storeID)
                            .then(response => response.json())
                            .then(statistics => {
                                var icon;
                                if (statistics.totalRevenue > 100000) {
                                    icon = greenIcon;
                                } else if (statistics.totalRevenue > 50000) {
                                    icon = orangeIcon;
                                } else {
                                    icon = redIcon;
                                }

                                var marker = L.marker([location.latitude, location.longitude], {
                                    icon: icon
                                }).addTo(map);

                                marker.on('click', function () {
                                    console.log(`Fetching statistics for store ID: ${location.storeID}`);
                                    fetchStoreStatistics(location, marker);
                                });

                                return marker;
                            });


                        return null;
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
    <b>Total Revenue:</b> $${data.totalrevenue.totalRevenue1}<br>
    <b>Total Customers:</b> ${data.totalcustomers.totalCustomers1}<br>

    <div id="chartButtons" style="margin-top: 10px;">
        <button class="popup-button" onclick="showChart('orders')">Orders</button>
        <button class="popup-button" onclick="showChart('revenue')">Revenue</button>
        <button class="popup-button" onclick="showChart('customers')">Customers</button>
    </div>
    <div style="padding: 10px; width: 500px;">
        <canvas id="storeChartOrders" width="500" height="400" style="display: none;"></canvas>
        <canvas id="storeChartRevenue" width="500" height="400" style="display: none;"></canvas>
        <canvas id="storeChartCustomers" width="500" height="400" style="display: none;"></canvas>
    </div>`;

                    marker.bindPopup(popupContent).openPopup();




                    setTimeout(() => {




                        // Pie chart for Orders
                        var ctxOrders = document.getElementById('storeChartOrders');
                        if (ctxOrders) {
                            ctxOrders = ctxOrders.getContext('2d');
                            new Chart(ctxOrders, {
                                type: 'pie',
                                data: {
                                    labels: data.orders.map(item => item.productName),
                                    datasets: [{
                                        data: data.orders.map(item => item.quantitySold),
                                        backgroundColor: [
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            labels: {
                                                font: {
                                                    size: 12
                                                },
                                                boxWidth: 10,
                                                padding: 10,
                                                usePointStyle: true,
                                            }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function (context) {
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
                                    },
                                    layout: {
                                        padding: {
                                            top: 10,
                                            bottom: 10
                                        }
                                    }
                                }
                            });
                        } else {
                            console.error('Canvas element not found for Orders');
                        }

                        // Line chart for Total Revenue
                        var ctxRevenue = document.getElementById('storeChartRevenue');
                        if (ctxRevenue) {
                            ctxRevenue = ctxRevenue.getContext('2d');
                            new Chart(ctxRevenue, {
                                type: 'line',
                                data: {
                                    labels: data.revenue.map(item => item.period),
                                    datasets: [{
                                        label: 'Total Revenue',
                                        data: data.revenue.map(item => item.totalRevenue),
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1,
                                        fill: true,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Period'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Revenue'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            labels: {
                                                font: {
                                                    size: 12
                                                },
                                                boxWidth: 10,
                                                padding: 4,
                                                usePointStyle: true,
                                            }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function (context) {
                                                    let label = context.dataset.label || '';
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
                                    },
                                    layout: {
                                        padding: {
                                            top: 10,
                                            bottom: 10
                                        }
                                    }
                                }
                            });
                        } else {
                            console.error('Canvas element not found for Revenue');
                        }




                        /// Line chart for Total Customers
                        var ctxCustomers = document.getElementById('storeChartCustomers');
                        console.log("Canvas Element: ", ctxCustomers);

                        if (ctxCustomers) {
                            ctxCustomers = ctxCustomers.getContext('2d');
                            new Chart(ctxCustomers, {
                                type: 'line',
                                data: {
                                    labels: data.customers.map(item => item.time),
                                    datasets: [{
                                        label: 'Total Customers',
                                        data: data.customers.map(item => parseFloat(item.totalCustomers)),
                                        borderColor: 'rgba(255, 161, 71, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Period'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Customer Count'
                                            },
                                            ticks: {
                                                beginAtZero: true,
                                                stepSize: 1,
                                                callback: function (value, index, values) {
                                                    return Number.isInteger(value) ? value : null;
                                                }
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            labels: {
                                                font: {
                                                    size: 12
                                                },
                                                boxWidth: 10,
                                                padding: 10,
                                                usePointStyle: true,
                                            }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function (context) {
                                                    let label = context.dataset.label || '';
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
                                    },
                                    layout: {
                                        padding: {
                                            top: 10,
                                            bottom: 10
                                        }
                                    }
                                }
                            });
                        } else {
                            console.error('Canvas element not found for Customers');
                        }

                        // showChart('orders');
                    }, 300);
                })
                .catch(error => {
                    console.error('Error fetching store statistics: ', error);
                });
        }

        fetchLocations();
    });

    function showChart(type) {
        document.getElementById('storeChartOrders').style.display = 'none';
        document.getElementById('storeChartRevenue').style.display = 'none';
        document.getElementById('storeChartCustomers').style.display = 'none';

        if (type === 'orders') {
            document.getElementById('storeChartOrders').style.display = 'block';
        } else if (type === 'revenue') {
            document.getElementById('storeChartRevenue').style.display = 'block';
        } else if (type === 'customers') {
            document.getElementById('storeChartCustomers').style.display = 'block';
        }
    }
</script>


</html>