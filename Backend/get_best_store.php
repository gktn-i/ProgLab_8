<?php
require 'database.php';

$query = "
    SELECT stores.store_name, SUM(orderItems.quantity * products.price) as turnover
    FROM orders
    JOIN orderItems ON orders.order_id = orderItems.order_id
    JOIN products ON orderItems.product_id = products.product_id
    JOIN stores ON orders.store_id = stores.store_id
    GROUP BY stores.store_id
    ORDER BY turnover DESC
    LIMIT 1
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$best_store = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($best_store);
?>
