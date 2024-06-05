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
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap; /* Allow wrapping of charts */
        }
        .chart-container {
            width: 400px; /* Adjust the width as needed */
            height: 400px; /* Adjust the height as needed */
            margin: 20px; /* Add spacing around the charts */
            text-align: center;
        }
        .dropdown-container {
            margin-right: 100px; /* Add spacing to the right */
            text-align: center;
        }
        .totalrevenuetopic {
            text-align: center;
            margin-top: 50px;
        }
        canvas {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="container">
        <div class="chart-container">
            <h1>Total Revenue Dashboard</h1>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <footer>
    </footer>

    <h2 class="totalrevenuetopic">Sales by product</h2>

    <div class="dropdown-container">
        <label for="yearSelect">Select Year:</label>
        <select id="yearSelect">
            <option value="all">All Years</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
        </select>
    </div>

    <div class="container" id="chartsContainer">
        <!-- Bar charts will be added here dynamically -->
    </div>
</body>
</html>
