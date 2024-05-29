$(document).ready(function() {
    var map = L.map('map', {
        fullscreenControl: true,
    }).setView([37.7749, -122.4194], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var resetControl = L.control({
        position: 'topleft'
    });

    

    resetControl.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
        div.style.backgroundColor = 'white';
        div.style.width = '34px';
        div.style.height = '34px';
        div.style.display = 'flex';
        div.style.justifyContent = 'center';
        div.style.alignItems = 'center';
        div.innerHTML = '<i class="bx bx-street-view" style="font-size:20px;"></i>';
        div.title ='Reset View';
        div.onclick = function() {
            map.setView([37.7749, -122.4194], 5);
        }
        div.onmouseover = function() {
            this.style.backgroundColor = ' #f2f2f2'; 
        }
        div.onmouseout = function() {
            this.style.backgroundColor = 'white';
        }
        return div;
    };

    resetControl.addTo(map);

    resetControl.addTo(map);

    function fetchLocations() {
        fetch('/Backend/map.php')

            .then(response => response.json())
            .then(locations => {
                console.log("Locations fetched: ", locations);
                var markers = locations.map(function(location) {


                    var greenIcon = new L.Icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    var redIcon = new L.Icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });


                    var orangeIcon = new L.Icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });


                    fetch('/Backend/get_total_store_statistics.php?storeID=' + location.storeID)
                        .then(response => response.json())
                        .then(statistics => {
                            var icon;
                            if (statistics.totalRevenue > 100000) {
                                icon = greenIcon;
                            } else if (statistics.totalRevenue > 50000) {
                                icon = orangeIcon;
                            } else {
                                icon = redIcon;
                            }

                            var marker = L.marker([location.latitude, location.longitude], {
                                icon: icon
                            }).addTo(map);

                            marker.on('click', function() {
                                console.log(`Fetching statistics for store ID: ${location.storeID}`);
                                fetchStoreStatistics(location, marker);
                            });

                            return marker;
                        });


                    return null;
                });

                var featureGroup = L.featureGroup(markers).addTo(map);
                map.fitBounds(featureGroup.getBounds());
            })
            .catch(error => {
                console.error('Error fetching map data:', error);
            });

            


    }

    function fetchStoreStatistics(location, marker) {
        fetch(`/Backend/get_store_statistics.php?storeID=${location.storeID}`)
            .then(response => response.json())
            .then(data => {
                console.log("Statistics fetched: ", data);


                var popupContent = `
<b>Store ID:</b> ${location.storeID}<br>
<b>City:</b> ${location.city}<br>
<b>Zip Code:</b> ${location.zipcode}<br>
<b>State:</b> ${location.state} (${location.state_abbr})<br>
<b>Total Revenue:</b> $${data.totalrevenue.totalRevenue1}<br>
<b>Total Customers:</b> ${data.totalcustomers.totalCustomers1}<br>

<div id="chartButtons" style="margin-top: 10px;">
<button class="popup-button" onclick="showChart('orders')">Orders</button>
<button class="popup-button" onclick="showChart('revenue')">Revenue</button>
<button class="popup-button" onclick="showChart('customers')">Customers</button>
</div>
<div style="padding: 10px; width: 500px;">
<canvas id="storeChartOrders" width="500" height="400" style="display: none;"></canvas>
<canvas id="storeChartRevenue" width="500" height="400" style="display: none;"></canvas>
<canvas id="storeChartCustomers" width="500" height="400" style="display: none;"></canvas>
</div>`;

                marker.bindPopup(popupContent).openPopup();




                setTimeout(() => {




                    // Pie chart for Orders
                    var ctxOrders = document.getElementById('storeChartOrders');
                    if (ctxOrders) {
                        ctxOrders = ctxOrders.getContext('2d');
                        new Chart(ctxOrders, {
                            type: 'pie',
                            data: {
                                labels: data.orders.map(item => item.productName),
                                datasets: [{
                                    data: data.orders.map(item => item.quantitySold),
                                    backgroundColor: [
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            font: {
                                                size: 12
                                            },
                                            boxWidth: 10,
                                            padding: 10,
                                            usePointStyle: true,
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                if (context.raw !== null) {
                                                    label += context.raw.toLocaleString();
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                },
                                layout: {
                                    padding: {
                                        top: 10,
                                        bottom: 10
                                    }
                                }
                            }
                        });
                    } else {
                        console.error('Canvas element not found for Orders');
                    }

                    // Line chart for Total Revenue
                    var ctxRevenue = document.getElementById('storeChartRevenue');
                    if (ctxRevenue) {
                        ctxRevenue = ctxRevenue.getContext('2d');
                        new Chart(ctxRevenue, {
                            type: 'line',
                            data: {
                                labels: data.revenue.map(item => item.period),
                                datasets: [{
                                    label: 'Total Revenue',
                                    data: data.revenue.map(item => item.totalRevenue),
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1,
                                    fill: true,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Period'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Revenue'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            font: {
                                                size: 12
                                            },
                                            boxWidth: 10,
                                            padding: 4,
                                            usePointStyle: true,
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.dataset.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                if (context.raw !== null) {
                                                    label += context.raw.toLocaleString();
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                },
                                layout: {
                                    padding: {
                                        top: 10,
                                        bottom: 10
                                    }
                                }
                            }
                        });
                    } else {
                        console.error('Canvas element not found for Revenue');
                    }




                    /// Line chart for Total Customers
                    var ctxCustomers = document.getElementById('storeChartCustomers');
                    console.log("Canvas Element: ", ctxCustomers);

                    if (ctxCustomers) {
                        ctxCustomers = ctxCustomers.getContext('2d');
                        new Chart(ctxCustomers, {
                            type: 'line',
                            data: {
                                labels: data.customers.map(item => item.time),
                                datasets: [{
                                    label: 'Total Customers',
                                    data: data.customers.map(item => parseFloat(item.totalCustomers)),
                                    borderColor: 'rgba(255, 161, 71, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Period'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Customer Count'
                                        },
                                        ticks: {
                                            beginAtZero: true,
                                            stepSize: 1,
                                            callback: function(value, index, values) {
                                                return Number.isInteger(value) ? value : null;
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            font: {
                                                size: 12
                                            },
                                            boxWidth: 10,
                                            padding: 10,
                                            usePointStyle: true,
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.dataset.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                if (context.raw !== null) {
                                                    label += context.raw.toLocaleString();
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                },
                                layout: {
                                    padding: {
                                        top: 10,
                                        bottom: 10
                                    }
                                }
                            }
                        });
                    } else {
                        console.error('Canvas element not found for Customers');
                    }

                    // showChart('orders');
                }, 300);
            })
            .catch(error => {
                console.error('Error fetching store statistics: ', error);
            });
    }

    fetchLocations();
});

function showChart(type) {
    document.getElementById('storeChartOrders').style.display = 'none';
    document.getElementById('storeChartRevenue').style.display = 'none';
    document.getElementById('storeChartCustomers').style.display = 'none';

    if (type === 'orders') {
        document.getElementById('storeChartOrders').style.display = 'block';
    } else if (type === 'revenue') {
        document.getElementById('storeChartRevenue').style.display = 'block';
    } else if (type === 'customers') {
        document.getElementById('storeChartCustomers').style.display = 'block';
    }
}