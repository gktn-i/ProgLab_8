let comparisonChart;
function fetchLoadStores() {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "Backend/get_store_comp.php");
        xhr.responseType = "json";
        xhr.onload = function () {
            if (xhr.status === 200) {
                resolve(xhr.response);
            } else {
                reject(new Error("Error fetching store data: " + xhr.statusText));
            }
        };
        xhr.onerror = function () {
            reject(new Error("Network error while fetching store data"));
        };
        xhr.send();
    });
}


function addOptions(dropdownId, data) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.innerHTML = '';

    const placeholderOption = new Option("-- Choose a Store --", "");
    placeholderOption.disabled = true;
    placeholderOption.selected = true;
    dropdown.appendChild(placeholderOption);

    data.sort((a, b) => a.city.localeCompare(b.city));

    data.forEach(item => {
        const option = new Option(`${item.storeID}, ${item.city}`, item.storeID);
        dropdown.appendChild(option);
    });
}

function filterOptions(select, searchTerm) {
    const options = Array.from(select.options);
    let hasMatch = false;

    options.forEach(option => {
        const optionText = option.textContent.toLowerCase();
        if (optionText.includes(searchTerm)) {
            option.style.display = 'block';
            hasMatch = true;
        } else {
            option.style.display = 'none';
        }
    });

    select.size = searchTerm && !hasMatch ? 2 : 1;
}

function fetchStoreRevenue(storeID) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `Backend/get_store_comp_revenue.php?storeID=${storeID}`);
        xhr.responseType = "json";
        xhr.onload = function () {
            if (xhr.status === 200) {
                resolve(xhr.response);
            } else {
                reject(new Error("Error fetching store revenue: " + xhr.statusText));
            }
        };
        xhr.onerror = function () {
            reject(new Error("Network error while fetching store revenue"));
        };
        xhr.send();
    });
}

async function fetchOrderCategoryCount(storeID) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `Backend/get_order_category_count_comp.php?storeID=${storeID}`);
        xhr.responseType = "json";

        xhr.onloadstart = function () {
            console.log("AJAX request started"); // Logge, wenn die Anfrage gestartet wird
        };

        xhr.onload = function () {
            console.log("XHR Success:", xhr.response); // Logge die empfangenen Daten bei Erfolg
            if (xhr.status === 200) {
                resolve(xhr.response);
            } else {
                reject(new Error("Error fetching order category count: " + xhr.statusText));
            }
        };

        xhr.onerror = function () {
            console.error("XHR Network Error"); // Logge Netzwerkfehler
            reject(new Error("Network error while fetching order category count"));
        };

        xhr.ontimeout = function () {
            console.error("XHR Timeout Error"); // Logge Time-out Fehler
            reject(new Error("Timeout error while fetching order category count"));
        };

        xhr.onloadend = function () {
            console.log("AJAX request completed"); // Logge, wenn die Anfrage abgeschlossen ist
        };

        xhr.send();
    });
}
function updateChart(chart, store1Data, store2Data) {
    console.log("Store 1 Data:", store1Data);
    console.log("Store 2 Data:", store2Data);

    const store1Dates = store1Data.map(item => item.orderDate);
    const store2Dates = store2Data.map(item => item.orderDate);
    const allDates = [...new Set([...store1Dates, ...store2Dates])].sort();

    const store1RevenueMap = store1Data.reduce((acc, item) => {
        acc[item.orderDate] = (acc[item.orderDate] || 0) + parseFloat(item.revenue);
        return acc;
    }, {});

    const store2RevenueMap = store2Data.reduce((acc, item) => {
        acc[item.orderDate] = (acc[item.orderDate] || 0) + parseFloat(item.revenue);
        return acc;
    }, {});

    const store1Revenues = allDates.map(date => store1RevenueMap[date] || 0);
    const store2Revenues = allDates.map(date => store2RevenueMap[date] || 0);

    chart.data.labels = allDates;
    chart.data.datasets[0].data = store1Revenues;
    chart.data.datasets[0].label = "Store 1";
    chart.data.datasets[1].data = store2Revenues;
    chart.data.datasets[1].label = "Store 2";

    chart.update();

    const totalRevenueStore1 = store1Revenues.reduce((sum, revenue) => sum + revenue, 0);
    const totalRevenueStore2 = store2Revenues.reduce((sum, revenue) => sum + revenue, 0);

    console.log("Total Revenue Store 1:", totalRevenueStore1);
    console.log("Total Revenue Store 2:", totalRevenueStore2);

    if (!isNaN(totalRevenueStore1)) {
        document.getElementById('totalRevenueStore1').textContent = `$${totalRevenueStore1.toFixed(2)}`;
    }

    if (!isNaN(totalRevenueStore2)) {
        document.getElementById('totalRevenueStore2').textContent = `$${totalRevenueStore2.toFixed(2)}`;
    }
}


async function updateChartOnSelection() {
    const store1Select = document.getElementById('store1Select');
    const store2Select = document.getElementById('store2Select');

    if (store1Select.value && store2Select.value) {
        try {
            const [store1Data, store2Data] = await Promise.all([
                fetchStoreRevenue(store1Select.value),
                fetchStoreRevenue(store2Select.value)
            ]);
            updateChart(comparisonChart, store1Data, store2Data);
        } catch (error) {
            console.error("Error fetching store data for comparison: ", error);
        }
    }
}

async function initializeDropdowns() {
    const dropdownSelects = document.querySelectorAll('.dropdown-select[data-placeholder]');

    dropdownSelects.forEach(async select => {
        try {
            const data = await fetchLoadStores();
            addOptions(select.id, data);

            const searchInput = select.previousElementSibling;
            searchInput.addEventListener('click', event => event.stopPropagation());
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase();
                filterOptions(select, searchTerm);
            });

            select.addEventListener('change', () => {
                if (select.value === "") {
                    const placeholderOption = select.querySelector('[data-placeholder]');
                    if (!placeholderOption) {
                        const newPlaceholderOption = new Option("-- Choose a Store --", "");
                        newPlaceholderOption.disabled = true;
                        newPlaceholderOption.selected = true;
                        select.insertBefore(newPlaceholderOption, select.firstChild);
                    }
                } else {
                    const placeholderOption = select.querySelector('[data-placeholder]');
                    if (placeholderOption) {
                        placeholderOption.remove();
                    }
                }

                updateChartOnSelection();
            });
        } catch (error) {
            console.error("Error fetching store data: ", error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initializeDropdowns();

    const ctx = document.getElementById('comparisonChart').getContext('2d');
    comparisonChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Store 1',
                    data: [],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)'
                },
                {
                    label: 'Store 2',
                    data: [],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Revenue'
                    }
                }
            }
        }
    });

    const store1Select = document.getElementById('store1Select');
    const store2Select = document.getElementById('store2Select');

    store1Select.addEventListener('change', updateChartOnSelection);
    store2Select.addEventListener('change', updateChartOnSelection);

    async function updateChartOnSelection() {
        const store1Select = document.getElementById('store1Select');
        const store2Select = document.getElementById('store2Select');

        if (store1Select.value && store2Select.value) {
            try {
                const [store1Data, store2Data] = await Promise.all([
                    fetchStoreRevenue(store1Select.value),
                    fetchStoreRevenue(store2Select.value)
                ]);
                updateChart(comparisonChart, store1Data, store2Data);

                // Ajax-Anfrage nur senden, wenn beide Stores ausgewählt wurden
                $.ajax({
                    url: 'Backend/get_best_seller_comp.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        storeID: store1Select.value
                    },
                    success: function (data) {
                        console.log('Received data for Store 1:', data);
                        if (data.length >= 3) {
                            $('#bestsellerproduct1').text(data[0].Name);
                            $('#bestsellerproduct2').text(data[1].Name);
                            $('#bestsellerproduct3').text(data[2].Name);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Ajax request for Store 1 failed:', error);
                    }
                });

                $.ajax({
                    url: 'Backend/get_best_seller_comp.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        storeID: store2Select.value
                    },
                    success: function (data) {
                        console.log('Received data for Store 2:', data);
                        if (data.length >= 3) {
                            $('#bestsellerproduct4').text(data[0].Name);
                            $('#bestsellerproduct5').text(data[1].Name);
                            $('#bestsellerproduct6').text(data[2].Name);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Ajax request for Store 2 failed:', error);
                    }
                });

            } catch (error) {
                console.error("Error fetching store data for comparison: ", error);
            }
        }
    }
    /*     function updateCategoryTurnoverPieCharts(store1Data, store2Data) {
            const categories1 = store1Data.map(item => item.Category);
            const counts1 = store1Data.map(item => item.OrderCount);
    
            const categories2 = store2Data.map(item => item.Category);
            const counts2 = store2Data.map(item => item.OrderCount);
    
            updatePieChart('categoryTurnoverPieChart1', categories1, counts1, 'Store 1');
            updatePieChart('categoryTurnoverPieChart2', categories2, counts2, 'Store 2');
        } */

});

async function fetchOrderCount(storeID) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `Backend/get_totalorder_comp.php?storeID=${storeID}`);
        xhr.responseType = "json";
        xhr.onload = function () {
            if (xhr.status === 200) {
                resolve(xhr.response);
            } else {
                reject(new Error("Error fetching order count: " + xhr.statusText));
            }
        };
        xhr.onerror = function () {
            reject(new Error("Network error while fetching order count"));
        };
        xhr.send();
    });
}

async function updateOrderCount() {
    const store1Select = document.getElementById('store1Select');
    const store2Select = document.getElementById('store2Select');

    if (store1Select.value) {
        try {
            const orderCountStore1 = await fetchOrderCount(store1Select.value);
            const totalOrderCountStore1 = document.getElementById('totalordercountStore1');
            if (totalOrderCountStore1) {
                totalOrderCountStore1.textContent = `Total Order: ${orderCountStore1}`;
            } else {
                console.error("Element with ID 'totalordercountStore1' not found.");
            }
        } catch (error) {
            console.error("Error fetching order count for Store 1: ", error);
        }
    }

    if (store2Select.value) {
        try {
            const orderCountStore2 = await fetchOrderCount(store2Select.value);
            const totalOrderCountStore2 = document.getElementById('totalordercountStore2');
            if (totalOrderCountStore2) {
                totalOrderCountStore2.textContent = `Total Order: ${orderCountStore2}`;
            } else {
                console.error("Element with ID 'totalordercountStore2' not found.");
            }
        } catch (error) {
            console.error("Error fetching order count for Store 2: ", error);
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Initialisierung des Dropdowns und des Diagramms...

    // Event-Listener für die Auswahländerungen der Dropdowns hinzufügen
    store1Select.addEventListener('change', updateOrderCount);
    store2Select.addEventListener('change', updateOrderCount);
});




function updateCategoryCountChart(store1Data, store2Data) {
    const store1Categories = store1Data.map(item => item.Category);
    const store1Counts = store1Data.map(item => parseInt(item.orderCount));

    const store2Categories = store2Data.map(item => item.Category);
    const store2Counts = store2Data.map(item => parseInt(item.orderCount));

    const store1Colors = generateRandomColors(store1Categories.length);
    const store2Colors = generateRandomColors(store2Categories.length);

    drawPieChart('store1PieChart', store1Categories, store1Counts, store1Colors);
    drawPieChart('store2PieChart', store2Categories, store2Counts, store2Colors);
}

function drawPieChart(canvasId, categories, counts, colors) {
    const ctx = document.getElementById(canvasId).getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: categories,
            datasets: [{
                data: counts,
                backgroundColor: colors,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: canvasId === 'store1PieChart' ? 'Store 1' : 'Store 2'
            }
        }
    });
}

function generateRandomColors(numColors) {
    const colors = [];
    for (let i = 0; i < numColors; i++) {
        colors.push(`rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.8)`);
    }
    return colors;
}

async function updateCategoryCount() {
    const store1Select = document.getElementById('store1Select');
    const store2Select = document.getElementById('store2Select');

    if (store1Select.value && store2Select.value) {
        try {
            const [store1Data, store2Data] = await Promise.all([
                fetchOrderCategoryCount(store1Select.value),
                fetchOrderCategoryCount(store2Select.value)
            ]);
            updateCategoryCountChart(store1Data, store2Data);
        } catch (error) {
            console.error("Error fetching order category count for comparison: ", error);
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Event-Listener für die Auswahländerungen der Dropdowns hinzufügen
    store1Select.addEventListener('change', updateCategoryCount);
    store2Select.addEventListener('change', updateCategoryCount);

    // Funktion zum Zeichnen der Tortendiagramme aktualisieren
    // Funktion zum Zeichnen eines Pie-Charts
    function drawPieChart(canvasId, categories, counts, colors) {
        const ctx = document.getElementById(canvasId).getContext('2d');

        // Überprüfen, ob ein Chart auf dem Canvas existiert
        if (Chart.getChart(ctx)) {
            Chart.getChart(ctx).destroy(); // Vorheriges Chart zerstören
        }

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    data: counts,
                    backgroundColor: colors,
                }]
            },
            options: {
                responsive: false,
                title: {
                    display: true,
                    text: canvasId === 'store1PieChart' ? 'Store 1' : 'Store 2'
                }
            }
        });
    }
    // updateCategoryCountChart aktualisieren, um die Tortendiagramme zu zeichnen
    function updateCategoryCountChart(store1Data, store2Data) {
        const store1Categories = store1Data.map(item => item.Category);
        const store1Counts = store1Data.map(item => parseInt(item.orderCount));

        const store2Categories = store2Data.map(item => item.Category);
        const store2Counts = store2Data.map(item => parseInt(item.orderCount));

        const store1Colors = generateRandomColors(store1Categories.length);
        const store2Colors = generateRandomColors(store2Categories.length);

        // Set width and height for both pie charts
        document.getElementById('store1PieChart').width = 300;
        document.getElementById('store1PieChart').height = 300;
        document.getElementById('store2PieChart').width = 300;
        document.getElementById('store2PieChart').height = 300;

        drawPieChart('store1PieChart', store1Categories, store1Counts, store1Colors);
        drawPieChart('store2PieChart', store2Categories, store2Counts, store2Colors);
    }
    document.getElementById('store2PieChart').width = 300; // Setze die Breite auf 300 Pixel
    document.getElementById('store2PieChart').height = 300; // Setze die Höhe auf 300 Pixel
    document.getElementById('store1PieChart').style.marginRight = '10px'; // Abstand zwischen den Diagrammen
    document.getElementById('store2PieChart').style.marginLeft = '10px';


    function generateRandomColors(numColors) {
        const colors = [];
        for (let i = 0; i < numColors; i++) {
            colors.push(`rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.8)`);
        }
        return colors;
    }

    async function updateCategoryCount() {
        const store1Select = document.getElementById('store1Select');
        const store2Select = document.getElementById('store2Select');

        if (store1Select.value && store2Select.value) {
            try {
                const [store1Data, store2Data] = await Promise.all([
                    fetchOrderCategoryCount(store1Select.value),
                    fetchOrderCategoryCount(store2Select.value)
                ]);
                updateCategoryCountChart(store1Data, store2Data);
            } catch (error) {
                console.error("Error fetching order category count for comparison: ", error);
            }
        }
    }



});
