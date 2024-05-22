<?php
$mysqli = require __DIR__ . "/database.php";

$query = "SELECT stores.city as store_name, SUM(orders.total) as total_revenue 
          FROM stores 
          JOIN orders ON stores.storeID = orders.storeID 
          GROUP BY stores.city 
          ORDER BY total_revenue DESC";

$result = mysqli_query($mysqli, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// JSON 
header('Content-Type: application/json');

echo json_encode($data);
