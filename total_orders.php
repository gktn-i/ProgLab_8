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
        async function fetchChartData(graph) {
            try {
                let response = await fetch(`Backend/total_orders_data.php?graph=${graph}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                let data = await response.json();
                if (data.error) {
                    throw new Error(data.error);
                }
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
                { type: 'bar', options: { responsive: true, title: { display: true, text: 'Total Orders by Customer' } } }
            ];

            let chart1Data = await fetchChartData('orders_by_month');
            if (chart1Data) {
                var ctx1 = document.getElementById('chart1').getContext('2d');
                var chart1Config = {
                    labels: chart1Data.map(item => item.month),
                    datasets: [{
                        label: 'Total Orders',
                        data: chart1Data.map(item => item.total_orders),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                };
                renderChart(ctx1, chart1Config, chartConfigs[0]);
            }

            let chart2Data = await fetchChartData('average_order_value_by_month');
            if (chart2Data) {
                var ctx2 = document.getElementById('chart2').getContext('2d');
                var chart2Config = {
                    labels: chart2Data.map(item => item.month),
                    datasets: [{
                        label: 'Average Order Value',
                        data: chart2Data.map(item => item.avg_order_value),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                };
                renderChart(ctx2, chart2Config, chartConfigs[1]);
            }

            let chart3Data = await fetchChartData('orders_by_store');
            if (chart3Data) {
                var ctx3 = document.getElementById('chart3').getContext('2d');
                var chart3Config = {
                    labels: chart3Data.map(item => item.city),
                    datasets: [{
                        label: 'Total Orders',
                        data: chart3Data.map(item => item.total_orders),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                };
                renderChart(ctx3, chart3Config, chartConfigs[2]);
            }

            let chart4Data = await fetchChartData('orders_by_customer');
            if (chart4Data) {
                var ctx4 = document.getElementById('chart4').getContext('2d');
                var chart4Config = {
                    labels: chart4Data.map(item => item.customerID),
                    datasets: [{
                        label: 'Total Orders',
                        data: chart4Data.map(item => item.total_orders),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                };
                renderChart(ctx4, chart4Config, chartConfigs[3]);
            }
        });
    </script>
</body>

</html>
