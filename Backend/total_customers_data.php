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
        ROUND(SUM(o.total), 2) AS Revenue,
        SUM(o.nItems) AS Total_Items
    FROM orders o
    GROUP BY o.customerID
), Ranked_Customers AS (
    SELECT 
        customerID,
        Revenue,
        Total_Items,
        SUM(Revenue) OVER (ORDER BY Revenue DESC) AS Cumulative_Revenue,
        SUM(Total_Items) OVER (ORDER BY Revenue DESC) AS Cumulative_Items,
        SUM(Revenue) OVER () AS Total_Revenue,
        SUM(Total_Items) OVER () AS Overall_Items,
        ROUND(100.0 * SUM(Revenue) OVER (ORDER BY Revenue DESC) / SUM(Revenue) OVER (), 2) AS Cumulative_Percentage_of_Revenue,
        ROW_NUMBER() OVER (ORDER BY Revenue DESC) AS Revenue_Rank,
        COUNT(*) OVER () AS Total_Customers,
        ROUND(100.0 * ROW_NUMBER() OVER (ORDER BY Revenue DESC) / COUNT(*) OVER (), 2) AS Cumulative_Percentage_of_Customers
    FROM Customer_Revenue
), ABC_Analysis AS (
    SELECT 
        customerID,
        Revenue,
        Total_Items,
        Cumulative_Revenue,
        Cumulative_Items,
        Total_Revenue,
        Overall_Items,
        Cumulative_Percentage_of_Revenue,
        Cumulative_Percentage_of_Customers,
        CASE 
            WHEN Cumulative_Percentage_of_Revenue <= 80 THEN 'A'
            WHEN Cumulative_Percentage_of_Revenue <= 95 THEN 'B'
            ELSE 'C'
        END AS ABC_Segment
    FROM Ranked_Customers
)
SELECT 
    ABC_Segment, 
    COUNT(customerID) AS Total_Customers,
    ROUND(SUM(Revenue), 2) AS Total_Revenue,
    SUM(Total_Items) AS Total_Items,
    ROUND(100.0 * COUNT(customerID) / (SELECT COUNT(customerID) FROM Customer_Revenue), 2) AS Percentage_of_Customers,
    ROUND(100.0 * SUM(Revenue) / (SELECT SUM(total) FROM orders), 2) AS Percentage_of_Revenue,
    ROUND(100.0 * SUM(Total_Items) / (SELECT SUM(nItems) FROM orders), 2) AS Percentage_of_Items
FROM ABC_Analysis
GROUP BY ABC_Segment
ORDER BY FIELD(ABC_Segment, 'A', 'B', 'C');
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
