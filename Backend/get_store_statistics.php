<?php
$mysqli = require __DIR__ . "/database.php";

$storeID = $_GET['storeID'];

if (!$storeID) {
    echo json_encode(['error' => 'Store ID not provided']);
    exit;
}

$query = "
    SELECT 
        (SELECT COUNT(*) FROM orders WHERE storeID = '$storeID') AS totalOrders, 
        (SELECT SUM(total) FROM orders WHERE storeID = '$storeID') AS totalRevenue, 
        (SELECT COUNT(DISTINCT customerID) FROM orders WHERE storeID = '$storeID') AS totalCustomers, 
        (SELECT COUNT(DISTINCT oi.SKU) FROM orderitems oi JOIN orders o ON oi.orderID = o.orderID WHERE o.storeID = '$storeID') AS totalProducts
";

$result = mysqli_query($mysqli, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// JSON 
header('Content-Type: application/json');

echo json_encode($data);
?>
