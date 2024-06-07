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
            justify-content: space-between;
        }

        .chart-container {
            width: 600px;
            height: 400px;
            text-align: center;
            margin-bottom: 20px;
        }

        .dropdown-container {
            text-align: center;
            margin-bottom: 20px;
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
            border: 1px solid #666;
            border-radius: 3px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 5px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <div class="container">
        <div class="section">
            <div class="chart-container">
                <div class="title">Total Revenue by Year</div>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="section">
            <div class="chart-container">
                <div class="title">Total Revenue by Store</div>
                <canvas id="storeRevenueChart"></canvas>
            </div>
        </div>
        <div class="section">
            <div class="chart-container">
                <div class="title">Total Revenue by Category</div>
                <canvas id="categoryRevenueChart"></canvas>
            </div>
        </div>
        <div class="section">
            <div class="chart-container">
                <div class="title">Total Revenue by Month</div>
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>
    </div>

</body>

</html>
