src="https://code.jquery.com/jquery-3.6.0.min.js"
$(document).ready(function () {
    var myChart;
    var requestData = null;
    var selectedRadio = 'firstRadio';

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

    function createBarChart(labels, orderCounts) {
        var ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.map((label, index) => {
                    return label + " (" + requestData[index].Size + ")";
                }),
                datasets: [{
                    label: 'Order Count',
                    data: orderCounts,
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

    function fetchData() {
        $.ajax({
            type: "GET",
            url: "Backend/get_product_count_data.php",
            dataType: "json",
            success: function (data) {
                requestData = data;
                updateDisplay($('#filter_options1').val(), selectedRadio);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function updateDisplay(displayType, selectedRadio) {
        if (requestData === null) {
            return;
        }

        if (displayType === 'list' && selectedRadio === 'firstRadio') {
            showListData(requestData);
        } else if (displayType === 'chart' && selectedRadio === 'firstRadio') {
            var labels = [];
            var orderCounts = [];
            $.each(requestData, function (index, item) {
                labels.push(item.Name);
                orderCounts.push(item.orderCount);
            });
            createBarChart(labels, orderCounts);
        } else {
            $('#dataList').hide();
            $('#myChart').hide();
        }
    }

    var defaultTheme = $('#filter_options1').val();
    fetchData();
    updateDisplay(defaultTheme, selectedRadio);


    $('#filter_options1').change(function () {
        var selectedTheme = $(this).val();
        updateDisplay(selectedTheme, selectedRadio);
    });

    $('input[name=listGroupRadio]').change(function () {
        selectedRadio = $(this).attr('id');
        updateDisplay($('#filter_options1').val(), selectedRadio);
    });

 
