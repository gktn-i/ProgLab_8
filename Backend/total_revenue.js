$(document).ready(function() {
    fetchDataAndCreateChart('get_total_revenue.php', 'revenueChart', 'pie', 'Total Revenue by Year');
    fetchDataAndCreateChart('Backend/get_revenue_by_store.php', 'storeRevenueChart', 'bar', 'Total Revenue by Store');
    fetchDataAndCreateCategoryRevenueChart('Backend/get_revenue_by_category.php', 'categoryRevenueChart', 'Total Revenue by Category');
    fetchDataAndCreateChart('Backend/get_revenue_by_month.php', 'monthlyRevenueChart', 'line', 'Total Revenue by Month');

    function fetchDataAndCreateChart(url, chartId, chartType, label) {
        $.getJSON(url, function(data) {
            // Debugging: Log the fetched data to the console
            console.log(`Data fetched from ${url}:`, data);

            const labels = data.map(item => item.year || item.storeID || item.category || item.month);
            const values = data.map(item => item.total_revenue);

            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
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
                            beginAtZero: true
                        }
                    }
                }
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
        });
    }

    function fetchDataAndCreateCategoryRevenueChart(url, chartId, label) {
        $.getJSON(url, function(data) {
            // Debugging: Log the fetched data to the console
            console.log(`Data fetched from ${url}:`, data);

            const labels = data.map(item => item.Category);
            const values = data.map(item => item.total_revenue);

            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
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
                            beginAtZero: true
                        }
                    }
                }
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
        });
    }
});
