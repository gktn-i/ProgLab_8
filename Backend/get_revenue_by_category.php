<?php
$mysqli = require __DIR__ . "/database.php"; 

$conn = $mysqli;

// Query to retrieve the total revenue by product category for the years 2020, 2021, 2022
$sql = "SELECT products.Category, SUM(orders.total) as total_revenue
        FROM orders
        JOIN orderitems ON orders.orderID = orderitems.orderID
        JOIN products ON orderitems.SKU = products.SKU
        WHERE YEAR(orders.orderDate) IN (2020, 2021, 2022)
        GROUP BY products.Category
        ORDER BY products.Category";

$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Query failed: " . $conn->error);
}

// Initialize an array to store the results
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Output the data as JSON
echo json_encode($data);

// Close the database connection
$conn->close();
?>
