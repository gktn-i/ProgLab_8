document.addEventListener("DOMContentLoaded", function () {
    fetchChartData();
    fetchYears();
});

let chartData = {};
let ordersPerCategoryChart, ordersPerYearChart, averageOrderValueChart;
let currentFilter = 'all';

function fetchChartData() {
    fetch('Backend/get_chart_data.php')
        .then(response => response.json())
        .then(data => {
            console.log('Fetched chart data:', data);  // Check the data in the console
            chartData = data;
            populateCategoryDropdown(data.categories);
            createCharts();
        })
        .catch(error => console.error('Error fetching chart data:', error));
}

function populateCategoryDropdown(categories) {
    const categorySelect = document.getElementById('categorySelect');
    categorySelect.innerHTML = '<option class="dropdown-option" value="all">All</option>';
    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categorySelect.appendChild(option);
    });

    categorySelect.addEventListener('change', function () {
        filterCharts(this.value);
    });
}

function createCharts() {
    const ctx1 = document.getElementById('ordersPerCategoryChart').getContext('2d');
    const ctx2 = document.getElementById('ordersPerYearChart').getContext('2d');
    const ctx4 = document.getElementById('averageOrderValueChart').getContext('2d');

    ordersPerCategoryChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: chartData.categories,
            datasets: [{
                label: 'Orders per Category',
                data: chartData.ordersPerCategory,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            onClick: function (event, elements) {
                if (elements.length > 0) {
                    const category = chartData.categories[elements[0].index];
                    if (currentFilter === category) {
                        currentFilter = 'all';
                    } else {
                        currentFilter = category;
                    }
                    filterCharts(currentFilter);
                    document.getElementById('categorySelect').value = currentFilter;
                }
            }
        }
    });

    ordersPerYearChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: chartData.years,
            datasets: [{
                label: 'Orders per Year',
                data: chartData.ordersPerYear,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        }
    });

    averageOrderValueChart = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: chartData.categories,
            datasets: [{
                label: 'Average Order Value',
                data: chartData.averageOrderValue,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }
    });

    displayMostSoldProductsTable();
}

function filterCharts(category = 'all') {
    currentFilter = category;
    const filteredData = getFilteredData(category);

    ordersPerCategoryChart.data.datasets[0].data = filteredData.ordersPerCategory;
    ordersPerCategoryChart.update();

    fetchOrdersPerYearForCategory(category);

    averageOrderValueChart.data.datasets[0].data = filteredData.averageOrderValue;
    averageOrderValueChart.update();

    displayMostSoldProductsTable(category);
}

function fetchOrdersPerYearForCategory(category) {
    fetch(`Backend/get_orders_per_year.php?category=${category}`)
        .then(response => response.json())
        .then(data => {
            ordersPerYearChart.data.datasets[0].data = data.ordersPerYear;
            ordersPerYearChart.update();
        })
        .catch(error => console.error('Error fetching orders per year data:', error));
}

function getFilteredData(category) {
    if (category === 'all') {
        return chartData;
    }

    const filteredOrdersPerCategory = chartData.categories.map((cat, index) => {
        if (cat === category) {
            return chartData.ordersPerCategory[index];
        }
        return 0;
    });

    const filteredAverageOrderValue = chartData.categories.map((cat, index) => {
        if (cat === category) {
            return chartData.averageOrderValue[index];
        }
        return 0;
    });

    return {
        ordersPerCategory: filteredOrdersPerCategory,
        averageOrderValue: filteredAverageOrderValue
    };
}

function fetchYears() {
    fetch('Backend/get_years.php')
        .then(response => response.json())
        .then(data => {
            displayMostSoldProductsTable();
        })
        .catch(error => console.error('Error fetching years:', error));
}

function displayMostSoldProductsTable(category = 'all') {
    const tableContainer = document.getElementById('mostSoldProductsTableContainer');
    tableContainer.innerHTML = '';

    const table = document.createElement('table');
    table.classList.add('most-sold-products-table');

    const thead = document.createElement('thead');
    thead.innerHTML = '<tr><th>Year</th><th>Product</th><th>Orders</th></tr>';
    table.appendChild(thead);

    const tbody = document.createElement('tbody');

    const years = Object.keys(chartData.mostSoldProducts);
    if (category === 'all') {
        let allProducts = {};
        years.forEach(year => {
            const yearData = chartData.mostSoldProducts[year];
            if (yearData) {
                Object.keys(yearData).forEach(cat => {
                    yearData[cat].forEach(product => {
                        if (allProducts[product.name]) {
                            allProducts[product.name] += product.orders;
                        } else {
                            allProducts[product.name] = product.orders;
                        }
                    });
                });
            }
        });

        const sortedProducts = Object.keys(allProducts).map(name => ({
            name,
            orders: allProducts[name]
        })).sort((a, b) => b.orders - a.orders).slice(0, 10);

        sortedProducts.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>All Years</td><td>${product.name}</td><td>${product.orders}</td>`;
            tbody.appendChild(row);
        });

    } else {
        years.forEach(year => {
            const yearData = chartData.mostSoldProducts[year];
            if (yearData && yearData[category]) {
                const topProducts = yearData[category].sort((a, b) => b.orders - a.orders).slice(0, 3);
                topProducts.forEach((product, index) => {
                    const row = document.createElement('tr');
                    if (index === 0) {
                        row.classList.add('highlighted-row');
                    }
                    row.innerHTML = `<td>${year}</td><td>${product.name}</td><td>${product.orders}</td>`;
                    tbody.appendChild(row);
                });
            }
        });
    }

    table.appendChild(tbody);
    tableContainer.appendChild(table);
}

function filterProducts() {
    var selectedSize = document.getElementById('sizeSelect').value;

    fetch('Backend/get_total_product.php?size=' + selectedSize)
        .then(response => response.json())
        .then(data => {
            displayProducts(data);
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
}

function displayProducts(products) {
    var productList = document.getElementById('productList');
    productList.innerHTML = '';

    products.forEach(product => {
        var productCard = document.createElement('div');
        productCard.className = 'product-card';

        var productName = document.createElement('h2');
        productName.textContent = product.Name;
        productCard.appendChild(productName);

        var productPrice = document.createElement('p');
        productPrice.textContent = `$${product.Price}`;
        productCard.appendChild(productPrice);

        var productInfo = document.createElement('div');
        productInfo.id = `info-${product.SKU}`;
        productInfo.className = 'product-info';
        productCard.appendChild(productInfo);

        var infoButton = document.createElement('button');
        infoButton.className = 'info-button';
        infoButton.textContent = 'i';
        infoButton.onclick = function () {
            toggleIngredients(product.SKU);
        };
        productCard.appendChild(infoButton);

        productList.appendChild(productCard);
    });
}

function toggleIngredients(sku) {
    var infoDiv = document.getElementById(`info-${sku}`);
    if (infoDiv.style.display === 'none' || infoDiv.style.display === '') {
        fetch('Backend/get_product_info.php?sku=' + sku)
            .then(response => response.json())
            .then(data => {
                infoDiv.innerHTML = data.Ingredients;
                infoDiv.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching product info:', error);
            });
    } else {
        infoDiv.style.display = 'none';
    }
}

window.onload = filterProducts;
