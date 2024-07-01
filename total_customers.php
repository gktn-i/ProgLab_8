<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Total Customers</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Backend/total_customers.js"></script>
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
            height: 350px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-bottom: 8px;
        }

        h2 {
            text-align: center;
            font-size: 1.2em;
        }

        #time-filter {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            width: 500px;
            margin: 5px auto;
            animation: fadeIn 1s ease-in;

        }

        #time-filter select {
            padding: 5px;
            margin-right: 10px;
            width: 80px;
            border: 1px solid;
            border-radius: 4px;
            border-color: #666666;
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



    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>


    <form id="time-filter">
        <select id="year">
            <option value="all">All</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
        </select>
        <button type="submit">Filter</button>
    </form>



    <div class="container">
        <div class="section">
            <h2>Total Customers per Month</h2>
            <div class="chart-container">
                <canvas id="chart1"></canvas>
            </div>
        </div>


        <div class="section">
            <h2></h2>
            <div class="chart-container">
                <canvas id="chart2"></canvas>
            </div>
        </div>


        <div class="section">
            <h2>T</h2>
            <div class="chart-container">
                <canvas id="chart3"></canvas>
            </div>
        </div>



        <div class="section">
            <h2>T</h2>
            <div class="chart-container">
                <canvas id="chart4"></canvas>
            </div>
        </div>


    </div>




</body>

</html>