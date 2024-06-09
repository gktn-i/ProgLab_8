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

$size = isset($_GET['size']) ? $_GET['size'] : 'Medium';
$query = "SELECT * FROM products WHERE Size = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $size);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$mysqli->close();
?>
