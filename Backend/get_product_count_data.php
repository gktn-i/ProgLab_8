<?php
$mysqli = require __DIR__ . "/database.php";
$query = "  SELECT products.Name, products.Size, orderitems.SKU, COUNT(*) as orderCount 
            FROM orderitems 
            JOIN products ON orderitems.SKU = products.SKU 
            GROUP BY products.SKU 
            ORDER BY orderCount DESC;";
$result = mysqli_query($mysqli, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// JSON 
header('Content-Type: application/json');

echo json_encode($data);
