$(document).ready(function () {
    fetchDataAndCreateChart('customer_segments.php', 'chart1', 'bar', 'Customer Segments');

    function fetchDataAndCreateChart(url, chartId, chartType, label) {
        $.getJSON(url)
            .done(function (data) {
                console.log(`Data fetched from ${url}:`, data);

                if (!data) {
                    console.error(`No data received from ${url}`);
                    return;
                }

                const labels = ['A Customers', 'B Customers', 'C Customers'];
                const values = [data.a_count, data.b_count, data.c_count];

                try {
                    const ctx = document.getElementById(chartId).getContext('2d');
                    const backgroundColor = [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ];
                    const borderColor = [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ];

                    createChart(ctx, chartType, labels, values, label, backgroundColor, borderColor);
                } catch (error) {
                    console.error(`Failed to create chart for ${chartId}:`, error);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
            });
    }

    function createChart(ctx, chartType, labels, values, label, backgroundColor, borderColor) {
        new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: values,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        barPercentage: 0.5
                    }
                }
            }
        });
    }
});