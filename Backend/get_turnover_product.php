<?php
$mysqli = require __DIR__ . "/database.php";

$query = "SELECT 
            products.Name, 
            products.Size, 
            orderitems.SKU, 
            COUNT(*) AS orderCount,
            SUM(products.Price) AS totalRevenue
          FROM 
            orderitems 
          JOIN 
            products ON orderitems.SKU = products.SKU 
          GROUP BY 
            products.SKU, products.Name, products.Size
          ORDER BY 
            orderCount DESC
          LIMIT 
            20;";

$result = mysqli_query($mysqli, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// JSON 
header('Content-Type: application/json');

echo json_encode($data);
?>