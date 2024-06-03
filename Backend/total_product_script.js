function toggleIngredients(sku) {
    const infoDiv = document.getElementById('info-' + sku);
    if (infoDiv.style.display === 'block') {
        infoDiv.style.display = 'none';
    } else {
        if (!infoDiv.innerHTML) {
            fetch('Backend/get_total_product.php?sku=' + sku)
                .then(response => response.json())
                .then(data => {
                    infoDiv.innerHTML = `<strong>Ingredients:</strong> ${data.Ingredients}`;
                    infoDiv.style.display = 'block';
                });
        } else {
            infoDiv.style.display = 'block';
        }
    }
}
