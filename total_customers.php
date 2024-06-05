<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Total Customers</title>
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
            <h2>Average Customers per Month</h2>
            <div class="chart-container">
                <canvas id="chart2"></canvas>
            </div>
        </div>

        <div class="section">
            <h2>Total Customers per Store</h2>
            <div class="chart-container">
                <canvas id="chart3"></canvas>
            </div>
        </div>

        <div class="section">
            <h2>Average orders per Customers</h2>
            <div class="chart-container">
                <canvas id="chart4"></canvas>
            </div>
        </div>
    </div>


<script>

    let charts = [];



    async function fetchALLChartData(year = 'all') {
        try{
            let response = await fetch(`Backend/total_customers_data.php?year=${year}`);
            if (!response.ok) throw new Error('Network response was not ok');
            let data = await response.json();
            if (data.error) throw new Error(data.error);
            console.log('All data:', data);
            return data;
        } catch (error) {
            console.error('Error fetching data:', error);
            return null;
        }
    }

    function destroyCharts() {
        charts.forEach(chart => chart.destroy());
        charts = [];
    }

    function renderChart(ctx, data, config) {
        return new Chart(ctx, {
            type: config.type,
            data: data,
            options: config.options
        });
    }

    async function initializeCharts(year = 'all') {
        destroyCharts();
        let allData = await fetchAllChartData(year);
        if (allData) {
            const chartConfigs = [
                {
                    type: 'line',
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Total Customers by Month'
                        }
                    }
                },
                {
                    type: 'line',
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Average Customers by Month'
                        }
                    }
                },
                {
                    type: 'bar',
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Total Customers by Store'
                        }
                    }
                },
                {
                    type: 'bar',
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Average Orders per Customer'
                        }
                    }
                }
            ];

            let ctx1 = document.getElementById('chart1').getContext('2d');
            let chart1Data = {
                labels: allData.total_customers_by_month.map(item => item.month),
                datasets: [{
                    label: 'Total Customers',
                    data: allData.total_customers_by_month.map(item => item.total_customers),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true,
                }]
            };
            charts.push(renderChart(ctx1, chart1Data, chartConfigs[0]));

            let ctx2 = document.getElementById('chart2').getContext('2d');
            let chart2Data = {
                labels: allData.average_customers_by_month.map(item => item.month),
                datasets: [{
                    label: 'Average Customers',
                    data: allData.average_customers_by_month.map(item => item.avg_customers),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            };
            charts.push(renderChart(ctx2, chart2Data, chartConfigs[1]));

            let ctx3 = document.getElementById('chart3').getContext('2d');
            let chart3Data = {
                labels: allData.total_customers_by_store.map(item => item.city),
                datasets: [{
                    label: 'Total Customers',
                    data: allData.total_customers_by_store.map(item => item.total_customers),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            };
            charts.push(renderChart(ctx3, chart3Data, chartConfigs[2]));

            let ctx4 = document.getElementById('chart4').getContext('2d');
            let chart4Data = {
                labels: allData.average_orders_per_customer.map(item => item.customerID),
                datasets: [{
                    label: 'Average Orders',
                    data: allData.average_orders_per_customer.map(item => item.avg_orders),
                    backgroundColor: 'rgba(255, 205, 86, 0.2)',
                    borderColor: 'rgba(255, 205, 86, 1)',
                    borderWidth: 1
                }]
            };
            charts.push(renderChart(ctx4, chart4Data, chartConfigs[3]));
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // default "all" year on page load
        initializeCharts();

        document.getElementById('time-filter').addEventListener('submit', function(event) {
            event.preventDefault();
            let year = document.getElementById('year').value;
            initializeCharts(year);
        });
    });



</script>





</body>

</html>