<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Total Customers</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Backend/total_customers.js"></script>
    <script src="Backend/customer_chart2.js"></script>
    <script src="Backend/customer_chart3.js"></script>
    <script src="Backend/customer_chart4.js"></script>
    <script src="Backend/customer_chart5.js"></script>
    <script src="Backend/customer_chart6.js"></script>


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
            height: 900px;
            animation: fadeIn 1s ease-in;
            justify-content: space-between;
            text-align: center;
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

        .dark-mode .section {
            background-color: #1e1e1e;
            border-color: #555;
            color: white;
        }

        .dark-mode {
            background-color: #2c2c2c;
            color: #ccc;
        }

        .dark-mode .container {
            background-color: #2c2c2c;
            color: #ccc;
            border-color: #444;
        }
        .title {
            font-size: 18px;
            margin-bottom: 20px;
        }




    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>





    <div class="container">
        <div class="section">
            <div class="title">Revenue by Customer Segments</div>
            <div class="chart-container">
                <canvas id="chart1"></canvas>
            </div>
        </div>


        <div class="section">
        <div class="title">Segmentation by percentage of revenue</div>
            
            <div class="chart-container">
                <canvas id="chart2"></canvas>
            </div>
        </div>


        <div class="section">
        <div class="title">Segment percentages</div>
            
            <div class="chart-container">
                <canvas id="chart3"></canvas>
            </div>
        </div>



        <div class="section">
        <div class="title">Rush Hours</div>
            <div class="chart-container">
                <canvas id="chart4"></canvas>
            </div>
        </div>








    </div>




</body>

</html>