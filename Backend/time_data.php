<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = require __DIR__ . "/database.php";
if ($mysqli->connect_errno) {
    echo json_encode(["error" => "Failed to connect to MySQL: " . $mysqli->connect_error]);
    exit();
}

$query = "
WITH hours AS (
    SELECT 18 AS hour UNION ALL SELECT 19 UNION ALL SELECT 20 UNION ALL SELECT 21 UNION ALL 
    SELECT 22 UNION ALL SELECT 23 UNION ALL SELECT 0 UNION ALL SELECT 1 UNION ALL 
    SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
)
SELECT
    hours.hour AS Hour,
    COUNT(DISTINCT o.customerID) AS CustomerCount
FROM hours
LEFT JOIN orders o ON hours.hour = HOUR(o.orderDate)
GROUP BY hours.hour
ORDER BY hours.hour;
";

$result = $mysqli->query($query);
$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data['error'] = "Query failed: " . $mysqli->error;
}

echo json_encode($data);
$mysqli->close();
?>
