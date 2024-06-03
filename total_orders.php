<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Orders</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

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

        .section {
            flex: calc(50% - 20px);
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid;
            border-radius: 3px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-color: #666666;
            margin: 5px;
        }

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <div class="container">
        <!-- Chart sections -->
        <div class="section">
            <div class="chart-container">
                <canvas id="chart1"></canvas>
            </div>
        </div>
        <div class="section">
            <div class="chart-container">
                <canvas id="chart2"></canvas>
            </div>
        </div>
        <div class="section">
            <div class="chart-container">
                <canvas id="chart3"></canvas>
            </div>
        </div>
        <div class="section">
            <div class="chart-container">
                <canvas id="chart4"></canvas>
            </div>
        </div>
    </div>

    <script>
      
    </script>
</body>

</html>
