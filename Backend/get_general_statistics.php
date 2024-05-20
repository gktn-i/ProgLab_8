<?php
require 'database.php'; 

$query = "SELECT 
            (SELECT COUNT(*) FROM orders) AS totalOrders, 
            (SELECT SUM(total_amount) FROM orders) AS totalRevenue, 
            (SELECT COUNT(*) FROM customers) AS totalCustomers, 
            (SELECT COUNT(*) FROM products) AS totalProducts";

$result = $conn->query($query);
$data = $result->fetch_assoc();

echo json_encode($data);
?>
