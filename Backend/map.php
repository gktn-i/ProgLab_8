<?php
$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT storeID, zipcode, state_abbr, latitude, longitude, city, state 
    FROM stores";
$result = $mysqli->query($sql);

$locations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
} else {
    echo json_encode([]);
    $mysqli->close();
    exit;
}

$mysqli->close();


header('Content-Type: application/json');
http_response_code(200);
echo json_encode($locations);

