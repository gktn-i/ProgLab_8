var requestDataProducts = null; // Daten für die Gerichte
var requestDataCustomers = null; // Daten für die Kundenzählung
var requestDataTurnover = null; // Daten für die Umsätze
var myChart = null; // Variable für das Chart-Objekt
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
                    $('#totalRevenue').text(`$${parseFloat(data.totalRevenue).toFixed(2)}`);
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
            url: "Backend/get_turnover_data.php",
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

    function showListData(data) {
        var listItems = "";
        $.each(data, function (index, item) {
            listItems += '<li class="list-group-item">' +
                '<label>Gericht: ' + item.Name + '</label><br>' +
                '<span>Size: ' + item.Size + '</span><br>' +
                '<span>Order Count: ' + item.orderCount + '</span>' +
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

    function createBarChart(labels, data) {
        var ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Order Count',
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
                    $.each(requestDataProducts, function (index, item) {
                        labels.push(item.Name);
                        orderCounts.push(item.orderCount);
                    });
                    createBarChart(labels, orderCounts);
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
        } else {
            fetchData();
        }
    });

    // Initial fetch
    fetchData();
    fetchDataCustomerOrders();
    fetchGeneralStatistics();
});
