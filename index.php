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

    <script src="/scriptmap.js"></script>


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


        .container {
            display: flex;
            max-width: 1200px;
            margin: 50px auto;
            margin-bottom: 2%;
            height: 600px;
            animation: fadeIn 1s ease-in;


        }
        
        .comparison-section {
           justify-content: center;
            display: flex;
            width: 1295px;
            margin: 50px auto;

            height: 600px;
            border: 1px solid;
            border-color: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;


        }

        .comparison-section {
           justify-content: center;
            display: flex;
            width: 1295px;
            margin: 50px auto;
            margin-bottom: 3%;
            height: 600px;
            border: 1px solid;
            border-color: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;


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
        
    </style>
</head>

<body>


    <?php include 'Navbar.php'; ?>




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

    <div class="comparison-section">
        <h1>Store Comparison</h1>
        <div id="store1Container">
            <h2></h2>
           
        </div>
        <div id="store2Container">
            <h2></h2>
            
        </div>
    </div>
ä
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="/leaflet.fullscreen/leaflet.fullscreen.css" />
    <script src="/leaflet.fullscreen/leaflet.fullscreen.js"></script>


   
</body>



<!-- <script type="text/javascript " src="particles.js "></script> -->
<!-- <script src="app.js "></script> -->

</body>

</html>