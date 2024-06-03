<?php
$mysqli = require __DIR__ . "/database.php";
$conn = $mysqli;
$sql = "SELECT * FROM stores";
$result = $conn->query($sql);
$stores = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stores[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($stores);

$conn->close();

