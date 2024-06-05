document.addEventListener("DOMContentLoaded", function() {
    fetchYears();
});

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
    productList.innerHTML = ''; // Leeren der Produktliste

    products.forEach(product => {
        var productCard = document.createElement('div');
        productCard.className = 'product-card';

        var productName = document.createElement('h2');
        productName.textContent = product.Name;
        productCard.appendChild(productName);

        var productPrice = document.createElement       
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
