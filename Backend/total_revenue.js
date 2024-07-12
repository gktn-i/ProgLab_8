$(document).ready(function () {
    fetchDataAndCreateChart('get_total_revenue.php', 'revenueChart', 'pie', 'Total Revenue by Year');
    fetchDataAndCreateChart('Backend/get_revenue_by_store.php', 'storeRevenueChart', 'bar', 'Total Revenue by Store', onBarClick);
    fetchDataAndCreateCategoryRevenueChart('Backend/get_revenue_by_category.php', 'categoryRevenueChart', 'Total Revenue by Category');
    fetchDataAndCreateChart('Backend/get_revenue_by_month.php', 'monthlyRevenueChart', 'line', 'Total Revenue by Month');

    function fetchDataAndCreateChart(url, chartId, chartType, label, onClick) {
        $.getJSON(url)
            .done(function (data) {
                console.log(`Data fetched from ${url}:`, data);

                if (!data || data.length === 0) {
                    console.error(`No data received from ${url}`);
                    return;
                }

                const labels = data.map(item => item.year || item.storeID || item.category || item.month);
                const values = data.map(item => item.total_revenue);
                const storeIDs = data.map(item => item.storeID); 

                try {
                    const ctx = document.getElementById(chartId).getContext('2d');
                    let backgroundColor, borderColor;
                    if (chartType === 'pie') {
                        backgroundColor = [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ];
                        borderColor = [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ];
                    } else {
                        backgroundColor = 'rgba(45, 106, 79, 1)';
                        borderColor = 'rgba(45, 106, 79, 1)';
                    }
                    createChart(ctx, chartType, labels, values, label, onClick, storeIDs, backgroundColor, borderColor);
                } catch (error) {
                    console.error(`Failed to create chart for ${chartId}:`, error);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
            });
    }

    function createChart(ctx, chartType, labels, values, label, onClick, storeIDs, backgroundColor, borderColor) {
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
                   
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        barPercentage: 0.5 
                    }
                },
                onClick: function (event, array) {
                    if (onClick) {
                        onClick(event, array, storeIDs);
                    }
                }
            }
        });
    }

    function fetchDataAndCreateCategoryRevenueChart(url, chartId, label) {
        $.getJSON(url)
            .done(function (data) {
                console.log(`Data fetched from ${url}:`, data);

                const labels = data.map(item => item.Category);
                const values = data.map(item => item.total_revenue);

                try {
                    const ctx = document.getElementById(chartId).getContext('2d');
                    createChart(ctx, 'bar', labels, values, label, null, null, 'rgba(45, 106, 79, 1)', 'rgba(45, 106, 79, 1)');
                } catch (error) {
                    console.error(`Failed to create chart for ${chartId}:`, error);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Failed to fetch data from ${url}:`, textStatus, errorThrown);
            });
    }

    let storeDetailChart;

    function onBarClick(event, array, storeIDs) {
        if (array.length > 0) {
            const storeID = storeIDs[array[0].index];
            $.getJSON(`Backend/get_store_details.php?storeID=${storeID}`)
                .done(function (data) {
                    console.log(`Details for store ${storeID}:`, data);

                    if (data.error) {
                        alert(`Error: ${data.error}`);
                        return;
                    }

                    const labels = data.map(item => item.productName);
                    const values = data.map(item => item.total_revenue);

                    const detailChartId = 'storeDetailChart';
                    const detailCtx = document.getElementById(detailChartId).getContext('2d');

                    try {
                        if (storeDetailChart) {
                            storeDetailChart.destroy();
                        }

                        storeDetailChart = new Chart(detailCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: `Store ${storeID}`,
                                    data: values,
                                    backgroundColor: 'rgba(45, 106, 79, 1)',
                                    borderColor: 'rgba(45, 106, 79, 1)',
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
                    } catch (error) {
                        console.error(`Failed to create chart for store ${storeID}:`, error);
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.error(`Failed to fetch details for store ${storeID}:`, textStatus, errorThrown);
                    console.log(`Response text: ${jqXHR.responseText}`);
                });
        }
    }
});
