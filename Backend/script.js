var requestDataProducts = null; // Daten für die Gerichte
var requestDataCustomers = null; // Daten für die Kundenzählung
var requestDataTurnover = null; // Daten für die Umsätze
var myChart = null; // Variable für das Chart-Objekt


var requestCategoryandturnover = null;

var storeChart = null; // Variable für das Store-Chart-Objekt

var selectedRadio = 'firstRadio';

$(document).ready(function () {

    function fetchGeneralStatistics() {
        $.ajax({
            type: "GET",
            url: "Backend/get_general_statistics.php",
            dataType: "json",
            success: function (data) {
                if (data.error) {
                    console.error("Error fetching general statistics: ", data.error);
                } else {
                    console.log("General Statistics: ", data); // Debugging: Log the data
                    if (Array.isArray(data)) {
                        data = data[0];
                    }
                    $('#totalOrders').text(data.totalOrders);
                    $('#totalRevenue').text(`$${parseFloat(data.totalRevenue).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`);
                    $('#totalCustomers').text(data.totalCustomers);
                    $('#totalProducts').text(data.totalProducts);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching general statistics: ", xhr.responseText);
            }
        });
    }


    function fetchData() {
        $.ajax({
            type: "GET",
            url: "Backend/get_product_count_data.php",
            dataType: "json",
            success: function (data) {
                requestDataProducts = data;
                updateDisplay($('#filter_options1').val(), selectedRadio);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching product data: ", xhr.responseText);
            }
        });
    }
    //--
    function fetchCategoryandTurnover() {
        $.ajax({
            type: "GET",
            url: "Backend/get_category_turnover.php",
            dataType: "json",
            success: function (data) {
                requestCategoryandturnover = data;
                updateDisplay($('#filter_options1').val(), selectedRadio);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching category and turnover data: ", xhr.responseText);
            }
        });
    }

    function showStackedBarChart(data) {
        var ctx = document.getElementById('myChart').getContext('2d');


        var labels = [];
        var categories = {};

        data.forEach(function (item) {
            if (!labels.includes(item.Month)) {
                labels.push(item.Month);
            }
            if (!categories[item.Category]) {
                categories[item.Category] = [];
            }
            categories[item.Category].push({
                month: item.Month,
                totalRevenue: item.TotalRevenue
            });
        });
        var categoryColors = {
            Classic: 'rgba(255, 99, 132, 0.8)',
            Specialty: 'rgba(54, 162, 235, 0.8)',
            Vegetarian: 'rgba(255, 206, 86, 0.8)'

        };
        var datasets = [];
        for (var category in categories) {
            var categoryData = [];
            labels.forEach(function (label) {
                var monthData = categories[category].find(function (item) {
                    return item.month === label;
                });
                categoryData.push(monthData ? monthData.totalRevenue : 0);
            });
            datasets.push({
                label: category,
                data: categoryData,
                backgroundColor: categoryColors[category] || getRandomColor()
            });
        }

        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly turnover by category'
                    }
                }
            }
        });

        $('#myChart').show();
        $('#dataList').hide();
    }

    /*    zufällige Farben zu generieren
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        } */
    function showCategoryAndTurnoverList(data) {
        var listItems = "";
        $.each(data, function (index, item) {
            listItems += '<li class="list-group-item">' +
                '<label>Category ' + item.Category + '</label><br>' +
                '<span>Order Month: ' + item.Month + '</span>' +
                '<span>Order Total Revenue: ' + item.TotalRevenue + '</span>' +
                '</li>';
        });
        $('#dataList').html(listItems);
        $('#dataList').show();
        $('#myChart').hide();
    }

    //---
    function fetchDataCustomerOrders() {
        $.ajax({
            type: "GET",
            url: "Backend/get_customer_orders_data.php",
            dataType: "json",
            success: function (data) {
                requestDataCustomers = data;
                updateDisplay($('#filter_options1').val(), selectedRadio);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching customer orders data: ", xhr.responseText);
            }
        });
    }

    function fetchDataTurnover() {
        $.ajax({
            type: "GET",
            url: "Backend/get_store_turnover_data.php",
            dataType: "json",
            success: function (data) {
                requestDataTurnover = data;
                updateDisplay($('#filter_options1').val(), selectedRadio);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching turnover data: ", xhr.responseText);
            }
        });
    }
    function fetchorderbyresturant() {
        $.ajax({
            type: "GET",
            url: "Backend/get_orders_by_resturant.php",
            dataType: "json",
            success: function (data) {
                requestOrdersByRestaurant = data;
                updateDisplay($('#filter_options1').val(), selectedRadio);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching orders by restaurant data: ", xhr.responseText);
            }
        });
    }
    

    function showListData(data) {
        var listItems = "";
        $.each(data, function (index, item) {
            listItems += '<li class="list-group-item">' +
                '<label>Food: ' + item.Name + '</label><br>' +
                '<span>Size: ' + item.Size + '</span><br>' +
                '<span>Number of orders: ' + item.orderCount + '</span>' +
                '</li>';
        });
        $('#dataList').html(listItems);
        $('#dataList').show();
        $('#myChart').hide();
    }

    function showCustomerOrders(data) {
        var listItems = "";
        $.each(data, function (index, item) {
            listItems += '<li class="list-group-item">' +
                '<label>Customer: ' + item.customerID + '</label><br>' +
                '<span>Total: ' + item.Summe + '€</span><br>' +
                '<span>Numbers of Orders: ' + item.customerCount + '</span><br>' +
                '</li>';
        });
        $('#dataList').html(listItems);
        $('#dataList').show();
        $('#myChart').hide();
    }

    function showTurnoverData(data) {
        var listItems = "";
        $.each(data, function (index, item) {
            listItems += '<li class="list-group-item">' +
                '<label>Store: ' + item.store_name + '</label><br>' +
                '<span>Total Revenue: $' + parseFloat(item.total_revenue).toFixed(2) + '</span>' +
                '</li>';
        });
        $('#dataList').html(listItems);
        $('#dataList').show();
        $('#myChart').hide();
    }
    function showOrdersByRestaurant(data) {
        var listItems = "";
        $.each(data, function (index, item) {
            listItems += '<li class="list-group-item">' +
                '<label>Store: ' + item.storeID + '</label><br>' +
                '<span>Order Count: ' + item.order_count + '</span>' +
                '</li>';
        });
        $('#dataList').html(listItems);
        $('#dataList').show();
        $('#myChart').hide();
    }

    function createBarChart(labels, data, prices) {
        var ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy();
        }

        var backgroundColors = [];


        var minPrice = Math.min(...prices);
        var maxPrice = Math.max(...prices);

        // Farbverlauf definieren
        for (var i = 0; i < data.length; i++) {
            var price = prices[i];
            var gradient = (price - minPrice) / (maxPrice - minPrice);
            var redValue = Math.round(200 * gradient); 
            var greenValue = Math.round(200 - (200 * gradient)); 
            var color = 'rgba(' + redValue + ',' + greenValue + ',0,0.8)';
            backgroundColors.push(color);
        }

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Order Count',
                    data: data,
                    backgroundColor: backgroundColors,
                    borderColor: 'rgba(60, 81, 49, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            generateLabels: function (chart) {
                                return [{
                                    text: 'Price: Cheap',
                                    fillStyle: 'rgba(0, 200, 0, 0.8)', 
                                    strokeStyle: 'rgba(0, 200, 0, 0.8)',
                                    lineWidth: 1
                                }, {
                                    text: 'Price: expensive',
                                    fillStyle: 'rgba(200, 0, 0, 0.8)',
                                    strokeStyle: 'rgba(200, 0, 0, 0.8)',
                                    lineWidth: 1
                                }];
                            }
                        }
                    }
                }
            }
        });

        $('#myChart').show();
        $('#dataList').hide();
    }

    function createCustomerBarChart(labels, data) {
        var ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Customer Count',
                    data: data,
                    backgroundColor: 'rgba(60, 81, 49, 0.2)',
                    borderColor: 'rgb(60, 81, 49, 1)',
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

        $('#myChart').show();
        $('#dataList').hide();
    }

    function createTurnoverBarChart(labels, data) {
        var ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Revenue',
                    data: data,
                    backgroundColor: 'rgba(60, 81, 49, 0.2)',
                    borderColor: 'rgb(60, 81, 49, 1)',
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

        $('#myChart').show();
        $('#dataList').hide();
    }
    function createOrdersByRestaurantBarChart(labels, data) {
        var ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of orders',
                    data: data,
                    backgroundColor: 'rgba(60, 81, 49, 0.2)',
                    borderColor: 'rgb(60, 81, 49, 1)',
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

        $('#myChart').show();
        $('#dataList').hide();
    }

    function updateDisplay(displayType, selectedRadio) {
        if (selectedRadio === 'firstRadio') {
            if (displayType === 'list') {
                if (requestDataProducts) {
                    showListData(requestDataProducts);
                }
            } else if (displayType === 'chart') {
                if (requestDataProducts) {
                    var labels = [];
                    var orderCounts = [];
                    var prices = [];
                    $.each(requestDataProducts, function (index, item) {
                        labels.push(item.Name);
                        orderCounts.push(item.orderCount);
                        prices.push(parseFloat(item.minPrice));
                    });
                    createBarChart(labels, orderCounts, prices);
                }
            }
        } else if (selectedRadio === 'thirdRadio') {
            if (displayType === 'list') {
                if (requestDataCustomers) {
                    showCustomerOrders(requestDataCustomers);
                }
            } else if (displayType === 'chart') {
                if (requestDataCustomers) {
                    var labels = [];
                    var customerCounts = [];
                    $.each(requestDataCustomers, function (index, item) {
                        labels.push("Customer " + item.customerID);
                        customerCounts.push(item.customerCount);
                    });
                    createCustomerBarChart(labels, customerCounts);
                }
            }
        } else if (selectedRadio === 'secondRadio') {
            if (displayType === 'list') {
                if (requestDataTurnover) {
                    showTurnoverData(requestDataTurnover);
                }
            } else if (displayType === 'chart') {
                if (requestDataTurnover) {
                    var labels = [];
                    var turnoverAmounts = [];
                    $.each(requestDataTurnover, function (index, item) {
                        labels.push(item.store_name);
                        turnoverAmounts.push(parseFloat(item.total_revenue));
                    });
                    createTurnoverBarChart(labels, turnoverAmounts);
                }
            }
        } else if (selectedRadio === 'fifthRadio') {
            if (displayType === 'list') {
                if (requestOrdersByRestaurant) {
                    showOrdersByRestaurant(requestOrdersByRestaurant);
                }
            } else if (displayType === 'chart') {
                if (requestOrdersByRestaurant) {
                    var labels = [];
                    var orderCounts = [];
                    $.each(requestOrdersByRestaurant, function (index, item) {
                        labels.push(item.storeID);
                        orderCounts.push(item.order_count);
                    });
                    createOrdersByRestaurantBarChart(labels, orderCounts);
                }
            }
        } else if (selectedRadio === 'fourthRadio') {
            if (displayType === 'list') {
                if (requestCategoryandturnover) {
                    showCategoryAndTurnoverList(requestCategoryandturnover);
                }
            } else if (displayType === 'chart') {
                if (requestCategoryandturnover) {
                    showStackedBarChart(requestCategoryandturnover);
                }
            }
        }
    }

    $('#filter_options1').change(function () {
        var selectedTheme = $(this).val();
        updateDisplay(selectedTheme, selectedRadio);
    });

    $('input[name=listGroupRadio]').change(function () {
        selectedRadio = $(this).attr('id');
        updateDisplay($('#filter_options1').val(), selectedRadio);
    });

    $('input[name=listGroupRadio]').change(function () {
        selectedRadio = $(this).attr('id');
        if (selectedRadio === 'secondRadio') {
            fetchDataTurnover();
        } else if (selectedRadio === 'thirdRadio') {
            fetchDataCustomerOrders();
        } else if (selectedRadio === 'fifthRadio') {
            fetchorderbyresturant();
        }
        else {
            fetchData();
        }
        console.log("Calling fetchloadStores function...");
        fetchloadStores();



    });
    // Initial fetch
    fetchData();
    fetchDataCustomerOrders();
    fetchGeneralStatistics();
    fetchorderbyresturant();
    fetchCategoryandTurnover();
    



});

