var requestDataProducts = null; // Daten für die Gerichte
var requestDataCustomers = null; // Daten für die Kundenzählung
var myChart = null; // Variable für das Chart-Objekt

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
            console.error(xhr.responseText);
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
            console.error(xhr.responseText);
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
            '<label>Kunde: ' + item.customerID + '</label><br>' +
            '<span>Orders: ' + item.Summe + '</span><br>' +
            '<span>Orders: ' + item.customerCount + '</span><br>' +
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
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
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
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    $('#myChart').show();
    $('#dataList').hide();
}

$(document).ready(function () {
    var selectedRadio = 'firstRadio';

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
        if (selectedRadio === 'thirdRadio') {
            fetchDataCustomerOrders();
        } else {
            fetchData();
        }
    });
});
