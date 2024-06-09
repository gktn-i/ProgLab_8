<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    http_response_code(500); 
    echo json_encode(["error" => "Database connection failed: " . $mysqli->connect_error]);
    exit;
}

$category = $_GET['category'];
$year = $_GET['year'];

$query = "SELECT Name, SUM(Quantity) as SoldQuantity FROM Products
          JOIN Orders ON Products.ProductID = Orders.ProductID
          WHERE YEAR(OrderDate) = '$year'";
if ($category !== 'all') {
    $query .= " AND Category = '$category'";
}
$query .= " GROUP BY Name ORDER BY SoldQuantity DESC LIMIT 5";

$result = $mysqli->query($query);

if (!$result) {
    http_response_code(500); 
    echo json_encode(["error" => "Failed to execute query"]);
    exit;
}

$topProducts = [];

while ($row = $result->fetch_assoc()) {
    $topProducts[] = [
        'Name' => $row['Name'],
        'SoldQuantity' => $row['SoldQuantity'],
    ];
}

header('Content-Type: application/json');
echo json_encode($topProducts);

$mysqli->close();
?>
