<?php
require 'database.php';

$query = "
    SELECT stores.store_id, stores.store_name, SUM(orderItems.quantity * products.price) as turnover
    FROM stores
    JOIN orders ON stores.store_id = orders.store_id
    JOIN orderItems ON orders.order_id = orderItems.order_id
    JOIN products ON orderItems.product_id = products.product_id
    GROUP BY stores.store_id, stores.store_name
    ORDER BY turnover DESC
    LIMIT 1
";

$result = mysqli_query($conn, $query);

$bestStore = mysqli_fetch_assoc($result);

header('Content-Type: application/json');
echo json_encode($bestStore);

mysqli_close($conn);
?>
