<?php
$mysqli = require __DIR__ . "/database.php";

// Get the year from the GET request
$year = isset($_GET['year']) ? $_GET['year'] : 'all';

// Adjust the SQL query based on the selected year
if ($year === 'all') {
    $query = "SELECT 
                orderitems.SKU, 
                YEAR(orders.orderDate) as year, 
                COUNT(*) AS orderCount,
                SUM(products.Price) AS totalRevenue
              FROM 
                orderitems 
              JOIN 
                products ON orderitems.SKU = products.SKU 
              JOIN 
                orders ON orderitems.orderID = orders.orderID
              GROUP BY 
                orderitems.SKU, YEAR(orders.orderDate)
              ORDER BY 
                year, orderCount DESC;";
} else {
    $query = "SELECT 
                orderitems.SKU, 
                YEAR(orders.orderDate) as year, 
                COUNT(*) AS orderCount,
                SUM(products.Price) AS totalRevenue
              FROM 
                orderitems 
              JOIN 
                products ON orderitems.SKU = products.SKU 
              JOIN 
                orders ON orderitems.orderID = orders.orderID
              WHERE 
                YEAR(orders.orderDate) = ?
              GROUP BY 
                orderitems.SKU, YEAR(orders.orderDate)
              ORDER BY 
                year, orderCount DESC;";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $year);
    $stmt->execute();
    $result = $stmt->get_result();
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// JSON 
header('Content-Type: application/json');

echo json_encode($data);
?>
