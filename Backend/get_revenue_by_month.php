<?php
$mysqli = require __DIR__ . "/database.php"; 

$conn = $mysqli;

// Query to retrieve the total revenue by month for the years 2020, 2021, 2022
$sql = "SELECT CONCAT(YEAR(orderDate), '-', MONTH(orderDate)) as month, SUM(total) as total_revenue
        FROM orders
        WHERE YEAR(orderDate) IN (2020, 2021, 2022)
        GROUP BY YEAR(orderDate), MONTH(orderDate)
        ORDER BY YEAR(orderDate), MONTH(orderDate)";

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
