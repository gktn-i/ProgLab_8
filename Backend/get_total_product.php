<?php
function connect_db() {
    return require __DIR__ . '/database.php';
}

function get_unique_products() {
    $db = connect_db();
    $query = "SELECT DISTINCT Name, MIN(Price) AS Price, SKU FROM products GROUP BY Name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->close();
    return $products;
}

function get_product_by_sku($sku) {
    $db = connect_db();
    $query = "SELECT * FROM products WHERE SKU = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $sku);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    $db->close();
    return $product;
}

if (isset($_GET['sku'])) {
    $sku = $_GET['sku'];
    $product = get_product_by_sku($sku);
    echo json_encode($product);
}
?>
