<?php
$mysqli = require __DIR__ . "/Backend\database.php"; 

$conn = $mysqli;

// Query to retrieve the total revenue for the years 2020, 2021, 2022
$sql = "SELECT YEAR(orderDate) as year, SUM(total) as total_revenue
        FROM orders
        WHERE YEAR(orderDate) IN (2020, 2021, 2022)
        GROUP BY YEAR(orderDate)
        ORDER BY YEAR(orderDate)";

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
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();
?>
