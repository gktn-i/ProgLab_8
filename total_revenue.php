<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Revenue Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Backend/total_revenue.js"></script>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1300px;
            margin: 50px auto;
            margin-bottom: 2%;
            height: 800px;
            animation: fadeIn 1s ease-in;
            justify-content: space-between;
        }

        .chart-container {
            width: 300px;
            /* Adjust the width as needed */
            height: 300px;
            /* Adjust the height as needed */
            margin: 20px;
            /* Add spacing around the charts */
            text-align: center;
        }

        .dropdown-container {
            margin-right: 100px;
            /* Add spacing to the right */
            text-align: center;
        }

        .totalrevenuetopic {
            text-align: center;
            margin-top: 50px;
        }

        canvas {
            margin-top: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .section {
            flex: calc(50% - 20px);
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid;
            border-radius: 3px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-color: #666666;
            margin: 5px;
            height: calc(50% - 20px);
            /* Gleichmäßige Höhe für alle Abschnitte */
        }

        .title {
            font-size: 24px;
            /* Ändere die Schriftgröße nach Bedarf */
            font-weight: bold;
            /* Optional: Falls du den Text fett haben möchtest */
            margin: 10px 0;
            /* Ändere den Seitenabstand nach Bedarf */
        }
    </style>

</head>

<body>
    <?php include 'Navbar.php'; ?>

    <div class="container">
        <div class="section">
            <div class="chart-container">
                <div class="title">Total Revenue Dashboard</div>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="section">
        <div class="title">Sales by product</div>

            <div class="dropdown-container">
                <label for="yearSelect">Select Year:</label>
                <select id="yearSelect">
                    <option value="all">Select a Year</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div class="container" id="chartsContainer">
                <!-- Bar charts will be added here dynamically -->
            </div>
        </div>

        <div class="section">
        </div>
        <div class="section">
        </div>

    </div>




</body>

</html>