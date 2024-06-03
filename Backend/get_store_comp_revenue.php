<?php
$mysqli = require __DIR__ . "/database.php";
$conn = $mysqli;

$storeID = $_GET['storeID'];
$sql = "SELECT DATE(orderDate) as orderDate, SUM(total) as revenue
        FROM orders
        WHERE storeID = ?
        GROUP BY DATE(orderDate)
        ORDER BY orderDate";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $storeID);
$stmt->execute();
$result = $stmt->get_result();

$revenueData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $revenueData[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($revenueData);

$conn->close();
