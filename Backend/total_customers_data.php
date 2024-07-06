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
WITH Customer_Revenue AS (
    SELECT 
        o.customerID, 
        ROUND(SUM(o.total), 2) AS Revenue
    FROM orders o
    GROUP BY o.customerID
), Cumulative AS (
    SELECT 
        DENSE_RANK() OVER(ORDER BY Revenue DESC) AS Customer_Rank_By_Revenue,
        customerID,
        Revenue,
        SUM(Revenue) OVER(ORDER BY Revenue DESC) AS Cumulative_Revenue,
        SUM(Revenue) OVER() AS Total_Revenue,
        ROUND(100 * SUM(Revenue) OVER(ORDER BY Revenue DESC) / SUM(Revenue) OVER(), 2) AS Cumulative_Percentage_of_Revenue
    FROM Customer_Revenue
), ABC_Analysis AS (
    SELECT 
        Customer_Rank_By_Revenue, 
        customerID, 
        Revenue, 
        Cumulative_Revenue, 
        Total_Revenue, 
        Cumulative_Percentage_of_Revenue,
        IF(Cumulative_Percentage_of_Revenue < 40, 'A', IF(Cumulative_Percentage_of_Revenue < 70, 'B', 'C')) AS ABC_Segment
    FROM Cumulative
)
SELECT 
    ABC_Segment, 
    COUNT(customerID) AS Total_Customers,
    ROUND(SUM(Revenue), 2) AS Total_Revenue,
    ROUND(100 * COUNT(customerID) / (SELECT COUNT(*) FROM customers), 0) AS Percentage_of_Customers,
    ROUND(100 * SUM(Revenue) / (SELECT SUM(total) FROM orders), 2) AS Percentage_of_Revenue
FROM ABC_Analysis
GROUP BY ABC_Segment;
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
