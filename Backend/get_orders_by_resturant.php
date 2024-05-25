<?php
$mysqli = require __DIR__ . "/database.php";


$query = "SELECT storeID, COUNT(orderID) AS order_count
FROM orders
GROUP BY storeID
ORDER BY order_count DESC;";

$result = mysqli_query($mysqli, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// JSON 
header('Content-Type: application/json');

echo json_encode($data);
