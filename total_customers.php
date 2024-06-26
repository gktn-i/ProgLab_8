
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Backend/total_customers.js"></script>


    <script src="scripts.js" defer></script>

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
            font-size: 20px;
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
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .section p {
            font-size: 14px;
            line-height: 1.6;
        }

        .store-details-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #storeDetailChart {
            max-width: 600px;
            max-height: 400px;
        }



        .chart-container1 {
            width: 65%;
            margin-bottom: 20px;
            text-align: center;
            font-size: 20px;

        }

        .chart-center {
            margin: 0 auto;

        }

        #time-filter button {
            padding: 5px 10px;
            border-color: #666666;
            color: white;
            border: 1px solid;
            border-radius: 4px;
            border-color: #666666;
            cursor: pointer;
            background-color: darkgreen;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);

        }

        #time-filter button:hover {
            background-color: green;
        }

        #time-filter {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            width: 500px;
            margin: 5px auto;
            animation: fadeIn 1s ease-in;

        }


    </style>
</head>

<body>


    <?php include 'Navbar.php'; ?>


    <form id="time-filter">
        <select id="year">
            <option value="all">All</option>
            <option value="A Customer">A Customer</option>
            <option value="B Customer">B Customer</option>
            <option value="C Customer">C Customer</option>
        </select>
        <button type="submit">Filter</button>
    </form>



    <div class="container">

        <div class="section">
            <div class="chart-container">
                <div class="title">Customers Segments</div>
                <canvas id="chart1"></canvas>
            </div>
        </div>


        <div class="section">
            <div class="chart-container">
                <div class="title">Average orders per customer</div>
                <canvas id="chart2"></canvas>
            </div>
        </div>


        <div class="section">
            <div class="chart-container">
                <div class="title">Customer per store</div>
                <canvas id="chart3"></canvas>
            </div>
        </div>

        <div class="section">
            <div class="chart-container">
                <div class="title">Average Customer per Month</div>
                <canvas id="chart4"></canvas>
            </div>
        </div>


</body>
</html>