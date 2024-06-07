document.addEventListener("DOMContentLoaded", function () {
    fetchChartData();
    fetchYears();
});

let chartData = {};
let ordersPerCategoryChart, ordersPerYearChart, totalRevenueChart, averageOrderValueChart;
let currentFilter = 'all';

function fetchChartData() {
    fetch('Backend/get_chart_data.php')
        .then(response => response.json())
        .then(data => {
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
    const ctx3 = document.getElementById('totalRevenueChart').getContext('2d');
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

    totalRevenueChart = createTotalRevenueChart(ctx3);

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
}

function filterCharts(category = 'all') {
    currentFilter = category;
    const filteredData = getFilteredData(category);

    ordersPerCategoryChart.data.datasets[0].data = filteredData.ordersPerCategory;
    ordersPerCategoryChart.update();

    fetchOrdersPerYearForCategory(category);

    totalRevenueChart.data.datasets[0].data = filteredData.totalRevenue;
    totalRevenueChart.update();

    averageOrderValueChart.data.datasets[0].data = filteredData.averageOrderValue;
    averageOrderValueChart.update();
}

function fetchOrdersPerYearForCategory(category) {
    fetch(`Backend/get_orders_per_year.php?category=${category}`)
        .then(response => response.json())
        .then(data => {
            ordersPerYearChart.data.labels = data.years;
            ordersPerYearChart.data.datasets[0].data = data.ordersPerYear;
            ordersPerYearChart.update();
        })
        .catch(error => console.error('Error fetching orders per year data:', error));
}

function getFilteredData(category) {
    if (category === 'all') {
        return chartData;
    }

    const filteredData = {
        categories: chartData.categories,
        ordersPerCategory: chartData.ordersPerCategory.map((val, idx) => chartData.categories[idx] === category ? val : 0),
        totalRevenue: chartData.totalRevenue.map((val, idx) => chartData.categories[idx] === category ? val : 0),
        averageOrderValue: chartData.averageOrderValue.map((val, idx) => chartData.categories[idx] === category ? val : 0),
    };

    return filteredData;
}

function displayOrdersForYear(year) {
    const clickedYearIndex = chartData.years.findIndex(y => y === year);
    const ordersForClickedYear = chartData.ordersPerYear[clickedYearIndex];
    const categories = chartData.categories;

    const data = {
        labels: categories,
        datasets: [{
            label: `Orders for ${year}`,
            data: ordersForClickedYear,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    displayOrdersPerCategoryChart(data);
}

function displayOrdersPerCategoryChart(data) {
    const ctx = document.getElementById('ordersPerCategoryForYearChart').getContext('2d');
    const ordersPerCategoryForYearChart = new Chart(ctx, {
        type: 'bar',
        data: data,
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

function createTotalRevenueChart(ctx) {
    const pieColors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'];
    const borderColors = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];

    const topCategories = chartData.categories.slice(0, 3);
    const topData = chartData.totalRevenue.slice(0, 3);

    return new Chart(ctx, {
        type: 'pie',
        data: {
            labels: topCategories,
            datasets: [{
                label: 'Total Revenue',
                data: topData,
                backgroundColor: pieColors.slice(0, topCategories.length),
                borderColor: borderColors.slice(0, topCategories.length),
                borderWidth: 1
            }]
        }
    });
}

function fetchYears() {
    fetch('Backend/get_years.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            populateYearDropdown(data);
        })
        .catch(error => {
            console.error('Error fetching years:', error);
        });
}

function populateYearDropdown(years) {
    const yearSelect = document.getElementById('yearSelect');
    yearSelect.innerHTML = ''; // Clear existing options
    years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    });

    // Load the most ordered product for the first year in the dropdown
    if (years.length > 0) {
        fetchMostOrderedProduct(years[0]);
    }
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
    productList.innerHTML = ''; // Clear product list

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
