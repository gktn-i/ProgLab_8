/*
document.addEventListener('DOMContentLoaded', function() {
    fetch('/Backend/customer_segments.php')
        .then(response => response.json())
        .then(data => {
            createChart1(data);
        })
        .catch(error => console.error('Error fetching data:', error));


    fetch('/Backend/get_customer_orders.php')
        .then(response => response.json())
        .then(data => {
            createChart2(data);
        })
        .catch(error => console.error('Error fetching data:', error));
});

function createChart1(data) {
    const ctx = document.getElementById('chart1').getContext('2d');

    const labels = Object.keys(data);
    const values = Object.values(data).map(segment => segment.length);

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Customer Segments',
                data: values,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 2)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createChart2(data) {
    const ctx = document.getElementById('chart2').getContext('2d');

    const labels = data.map(item => item.customerID);
    const values = data.map(item => item.order_count);

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Anzahl der Bestellungen',
                data: values,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}




*/

$(document).ready(function () {
    /*
    fetchDataAndCreateChart1(
        'Backend/customer_segments.php',
        'chart1',
        'bar',
        'Customer Segments',
        'Segment',
        'Anzahl Kunden'
    );

     */
    fetchDataAndCreateChart(
        'Backend/get_customer_orders.php',
        'chart2',
        'line',
        'Average',
        'Months',
        'Average orders per customer'
    );

    fetchDataAndCreateChart3(
        'Backend/customer_by_store.php',
        'chart3',
        'bar',
        'customer',
        'Stores',
        'Customers'
    );
    
    fetchDataAndCreateChart4(
        'Backend/customer_per_month.php',
        'chart4',
        'line',
        'Avg customer',
        'Months',
        'Avg customer'
    );

    



    function fetchDataAndCreateChart(url, chartId, chartType, label, xAxisLabel, yAxisLabel, onClick) {
        $.getJSON(url)
            .done(function (data) {
                console.log(`Data fetched from ${url}:`, data);

                if (!data || data.length === 0) {
                    console.error(`No data received from ${url}`);
                    return;
                }

                const labels = data.map(item => item.month);
                const values = data.map(item => item.avg_customers);


                try {
                    const ctx = document.getElementById(chartId).getContext('2d');
                    createChart(ctx, chartType, labels, values, label, xAxisLabel, yAxisLabel, onClick);
                } catch (error) {
                    console.error(`Failed to create chart for ${chartId}:`, error);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
            });
    }



    function fetchDataAndCreateChart1(url, chartId, chartType, label, xAxisLabel, yAxisLabel, onClick) {
        $.getJSON(url)
            .done(function (data) {
                console.log(`Data fetched from ${url}:`, data);

                if (!data || data.length === 0) {
                    console.error(`No data received from ${url}`);
                    return;
                }

                const labels = Object.keys(data);
                const values = Object.values(data).map(segment => segment.length);


                try {
                    const ctx = document.getElementById(chartId).getContext('2d');
                    createChart(ctx, chartType, labels, values, label, xAxisLabel, yAxisLabel, onClick);
                } catch (error) {
                    console.error(`Failed to create chart for ${chartId}:`, error);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
            });
    }



    function fetchDataAndCreateChart3(url, chartId, chartType, label, xAxisLabel, yAxisLabel, onClick, value) {
        $.getJSON(url)
            .done(function (data) {
                console.log(`Data fetched from ${url}:`, data);

                if (!data || data.length === 0) {
                    console.error(`No data received from ${url}`);
                    return;
                }


                labels = data.map(item => item.city);
                values = data.map(item => item.total_customers);



                try {
                    const ctx = document.getElementById(chartId).getContext('2d');
                    createChart(ctx, chartType, labels, values, label, xAxisLabel, yAxisLabel, onClick,);
                } catch (error) {
                    console.error(`Failed to create chart for ${chartId}:`, error);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
            });
    }



    function fetchDataAndCreateChart4(url, chartId, chartType, label, xAxisLabel, yAxisLabel, onClick, value) {
        $.getJSON(url)
            .done(function (data) {
                console.log(`Data fetched from ${url}:`, data);

                if (!data || data.length === 0) {
                    console.error(`No data received from ${url}`);
                    return;
                }


                const labels = data.map(item => item.month);
                const values = data.map(item => item.customers_per_month);



                try {
                    const ctx = document.getElementById(chartId).getContext('2d');
                    createChart(ctx, chartType, labels, values, label, xAxisLabel, yAxisLabel, onClick,);
                } catch (error) {
                    console.error(`Failed to create chart for ${chartId}:`, error);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
            });
    }


    function createChart(ctx, chartType, labels, values, label, xAxisLabel, yAxisLabel, onClick) {
        new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                       /* 'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)' */
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                     /*   'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)' */
                    ],
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
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: yAxisLabel // Dynamische Beschriftung der Y-Achse
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: xAxisLabel // Dynamische Beschriftung der X-Achse
                        },
                        barPercentage: 0.5 // Breite der Balken (für Balkendiagramme)
                    }
                },
                onClick: function (event, array) {
                    if (onClick) {
                        onClick(event, array);
                    }
                }
            }
        });
    }
});

