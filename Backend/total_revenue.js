$(document).ready(function() {
    // Fetch data and create the pie chart
    $.getJSON('get_total_revenue.php', function(data) {
        const labels = data.map(item => item.year);
        const values = data.map(item => item.total_revenue);

        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Revenue',
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right' // Position the legend on the right side
                    }
                }
            }
        });
    });

    // Fetch data and create the bar charts
    $('#yearSelect').change(function() {
        var selectedYear = $(this).val();
        fetchData(selectedYear);
    });

    // Fetch data and create charts initially for "all" years
    fetchData('all');

    function fetchData(year) {
        $.getJSON('/Backend/get_turnover_product.php?year=' + year, function(data) {
            createBarCharts(data);
        });
    }

    // Function to create bar charts
    function createBarCharts(data) {
        $('#chartsContainer').empty();  // Clear the existing charts

        var yearData = {};

        // Group data by year
        data.forEach(function(item) {
            var year = item.year;
            if (!yearData[year]) {
                yearData[year] = [];
            }
            yearData[year].push(item);
        });

        // Create a bar chart for each year
        for (var year in yearData) {
            var chartContainer = $('<div class="chart-container"></div>');
            var canvas = $('<canvas></canvas>');
            chartContainer.append('<h3>Year ' + year + '</h3>');
            chartContainer.append(canvas);
            $('#chartsContainer').append(chartContainer);

            var ctx = canvas[0].getContext('2d');
            var labels = [];
            var sums = [];

            yearData[year].forEach(function(item) {
                labels.push(item.SKU);
                sums.push(item.totalRevenue);
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Revenue',
                        data: sums,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
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
    }
});

