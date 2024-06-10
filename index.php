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

    <script src="/Backend/comp-script2.js"></script>

    <script src="scriptmap.js"></script>


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

        .time-group {
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
    



    <!--  <div class="statistics">
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
    </div> -->


    <div id="map"></div>

    <div class="container">
        <div class="left-section">
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            
           <!-- <div class="time-group">
                <input type="date" id="startDate" name="start-date">
                <input type="date" id="endDate" name="end-date">
                <button id="submitDateRange">Show Data</button>
            </div> -->

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

            </ul>
        </div>
    </div>


    <body>



        <div class="comparison-section closed">
            <h1 class="page-title accordion-title">Store Comparison <span class="accordion-icon"></span></h1>
            <div class="accordion-content">
                <div class="comparison-section">

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
                        <label for="startDate" class="label">Start Date:</label>
                        <input type="date" id="startDate" class="date-input">
                        <label for="endDate" class="label end-date-label">End Date:</label>
                        <input type="date" id="endDate" class="date-input">
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
                                <p id="bestsellerproduct1" class="product-name"> Top 1</p>
                                <p id="bestsellerproduct2" class="product-name"> Top 2</p>
                                <p id="bestsellerproduct3" class="product-name"> Top 3</p>
                            </div>
                            <div class="best-seller-item">
                                <h1 class="page-titlename">Store 2</h1>
                                <p id="bestsellerproduct4" class="product-name"> Top 1</p>
                                <p id="bestsellerproduct5" class="product-name"> Top 2</p>
                                <p id="bestsellerproduct6" class="product-name"> Top 3</p>
                            </div>
                        </div>
                    </div>
                    <div class="total-revenue-container">
                        <h1 class="page-title">Total Order </h1>
                        <div class="total-revenue">
                            <div class="total-revenue-item">
                                <h1 class="page-titlename">Store 1</h1>
                                <p id="totalordercountStore1" class="product-name">0</p>
                            </div>
                            <div class="total-revenue-item">
                                <h1 class="page-titlename">Store 2</h1>
                                <p id="totalordercountStore2" class="product-name">0</p>
                            </div>
                        </div>
                    </div>
                    <h1 class="page-title">Order Category Count</h1>

                    <h1 class="page-titlename">Store 1</h1>
                    <canvas id="store1PieChart" width="300" height="300"></canvas>
                    <h1 class="page-titlename">Store 2</h1>
                    <canvas id="store2PieChart" width="300" height="300"></canvas>
                    <div>
                        <canvas id="barChartStore" style="width: 600px; height: 400px; margin-top: 20px;"></canvas>
                    </div>

                </div>
            </div>
        </div>


        <!-- JavaScript-Dateien einbinden -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="/Backend/comp-script.js"></script>
        <script src="/Backend/comp-script2.js"></script>
    </body>

</html>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="/leaflet.fullscreen/leaflet.fullscreen.css" />
<script src="/leaflet.fullscreen/leaflet.fullscreen.js"></script>



</html>