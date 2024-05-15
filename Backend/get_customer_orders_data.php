<?php
$mysqli = require __DIR__ . "/database.php";
$query = "SELECT customerID, COUNT(customerID) as customerCount, SUM(total) as Summe
FROM orders 
GROUP BY customerID 
ORDER BY customerCount DESC
LIMIT 10;";
$customerOrders = mysqli_query($mysqli, $query);

$data = [];
while ($row = mysqli_fetch_assoc($customerOrders)) {
    $data[] = $row;
}

// JSON 
header('Content-Type: application/json');

echo json_encode($data);