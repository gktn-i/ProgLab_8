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
            height: auto;
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
            height: auto;
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }

        h2{
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'Navbar.php'; ?>
    <div class="container">
        <!-- Chart sections -->
        <div class="section">
            <h2>Total Orders by Month</h2>
            <div class="chart-container">
                <canvas id="chart1"></canvas>
            </div>
        </div>
        <div class="section">
            <h2>Average Order Value by Month</h2>
            <div class="chart-container">
                <canvas id="chart2"></canvas>
            </div>
        </div>
        <div class="section">
            <h2>Total Orders by Store</h2>
            <div class="chart-container">
                <canvas id="chart3"></canvas>
            </div>
        </div>
        <div class="section">
            <h2>Pizza Distribution</h2>
            <div class="chart-container">
                <canvas id="chart4"></canvas>
            </div>
        </div>
    </div>

    <script>
        async function fetchAllChartData() {
            try {
                let response = await fetch(`Backend/total_orders_data.php`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                let data = await response.json();
                if (data.error) {
                    throw new Error(data.error);
                }
                console.log('All data:', data);
                return data;
            } catch (error) {
                console.error('Error fetching data:', error);
                return null;
            }
        }

        function renderChart(ctx, data, config) {
            new Chart(ctx, {
                type: config.type,
                data: data,
                options: config.options
            });
        }

        document.addEventListener('DOMContentLoaded', async function() {
            var chartConfigs = [
                { type: 'line', options: { responsive: true, title: { display: true, text: 'Total Orders by Month' } } },
                { type: 'line', options: { responsive: true, title: { display: true, text: 'Average Order Value by Month' } } },
                { type: 'bar', options: { responsive: true, title: { display: true, text: 'Total Orders by Store' } } },
                { type: 'pie', options: { responsive: true, title: { display: true, text: 'Pizza Distribution' } } }
            ];

            let allData = await fetchAllChartData();
            if (allData) {
                // Render chart 1: Total Orders by Month
                var ctx1 = document.getElementById('chart1').getContext('2d');
                var chart1Data = {
                    labels: allData.orders_by_month.map(item => item.month),
                    datasets: [{
                        label: 'Total Orders',
                        data: allData.orders_by_month.map(item => item.total_orders),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                };
                renderChart(ctx1, chart1Data, chartConfigs[0]);

                // Render chart 2: Average Order Value by Month
                var ctx2 = document.getElementById('chart2').getContext('2d');
                var chart2Data = {
                    labels: allData.average_order_value_by_month.map(item => item.month),
                    datasets: [{
                        label: 'Average Order Value',
                        data: allData.average_order_value_by_month.map(item => item.avg_order_value),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                };
                renderChart(ctx2, chart2Data, chartConfigs[1]);

                // Render chart 3: Total Orders by Store
                var ctx3 = document.getElementById('chart3').getContext('2d');
                var chart3Data = {
                    labels: allData.orders_by_store.map(item => item.city),
                    datasets: [{
                        label: 'Total Orders',
                        data: allData.orders_by_store.map(item => item.total_orders),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                };
                renderChart(ctx3, chart3Data, chartConfigs[2]);

                // Render chart 4: Pizza Distribution
                var ctx4 = document.getElementById('chart4').getContext('2d');
                var chart4Data = {
                    labels: allData.pizza_distribution.map(item => item.Name),
                    datasets: [{
                        label: 'Total Orders',
                        data: allData.pizza_distribution.map(item => item.total_orders),
                        backgroundColor: allData.pizza_distribution.map((_, index) => `rgba(${index * 30}, 99, 132, 0.2)`),
                        borderColor: allData.pizza_distribution.map((_, index) => `rgba(${index * 30}, 99, 132, 1)`),
                        borderWidth: 1
                    }]
                };
                renderChart(ctx4, chart4Data, chartConfigs[3]);
            }
        });
    </script>
</body>

</html>
