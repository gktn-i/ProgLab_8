<?php
$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection failed: " . $mysqli->connect_error]);
    exit;
}

$sku = isset($_GET['sku']) ? $_GET['sku'] : '';

$query = "SELECT Ingredients FROM products WHERE SKU = ?";

$stmt = $mysqli->prepare($query);
if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to prepare SQL statement"]);
    exit;
}

$stmt->bind_param("s", $sku);
$result = $stmt->execute();
if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to execute SQL query: " . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to get results from query"]);
    exit;
}

$product = $result->fetch_assoc();

echo json_encode($product);

$stmt->close();
$mysqli->close();
?>
