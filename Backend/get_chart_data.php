<?php
$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $mysqli->connect_error]);
    exit;
}


$query = "SELECT p.Category, COUNT(oi.SKU) AS OrdersPerCategory
    FROM orderitems oi
    JOIN products p ON oi.SKU = p.SKU
    GROUP BY p.Category
";
$result = $mysqli->query($query);
$categories = [];
$ordersPerCategory = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['Category'];
    $ordersPerCategory[] = $row['OrdersPerCategory'];
}

$query = " SELECT YEAR(o.orderDate) AS Year, COUNT(o.orderID) AS OrdersPerYear
    FROM orders o
    GROUP BY Year
    ORDER BY Year
";
$result = $mysqli->query($query);
$years = [];
$ordersPerYear = [];
while ($row = $result->fetch_assoc()) {
    $years[] = $row['Year'];
    $ordersPerYear[] = $row['OrdersPerYear'];
}

$query = " SELECT p.Category, SUM(o.total) AS TotalRevenue
    FROM orders o
    JOIN orderitems oi ON o.orderID = oi.orderID
    JOIN products p ON oi.SKU = p.SKU
    GROUP BY p.Category
";
$result = $mysqli->query($query);
$totalRevenue = [];
while ($row = $result->fetch_assoc()) {
    $totalRevenue[] = $row['TotalRevenue'];
}

$query = "SELECT p.Category, AVG(o.total) AS AverageOrderValue
    FROM orders o
    JOIN orderitems oi ON o.orderID = oi.orderID
    JOIN products p ON oi.SKU = p.SKU
    GROUP BY p.Category
";
$result = $mysqli->query($query);
$averageOrderValue = [];
while ($row = $result->fetch_assoc()) {
    $averageOrderValue[] = $row['AverageOrderValue'];
}


$query = "SELECT YEAR(o.orderDate) AS Year, p.Category, p.Name, COUNT(oi.SKU) AS Orders
    FROM orderitems oi
    JOIN products p ON oi.SKU = p.SKU
    JOIN orders o ON oi.orderID = o.orderID
    GROUP BY Year, p.Category, p.Name
    ORDER BY Year, p.Category, Orders DESC
";
$result = $mysqli->query($query);
$mostSoldProducts = [];
while ($row = $result->fetch_assoc()) {
    $year = $row['Year'];
    $category = $row['Category'];
    if (!isset($mostSoldProducts[$year])) {
        $mostSoldProducts[$year] = [];
    }
    if (!isset($mostSoldProducts[$year][$category])) {
        $mostSoldProducts[$year][$category] = [];
    }
    $mostSoldProducts[$year][$category][] = [
        'name' => $row['Name'],
        'orders' => $row['Orders']
    ];
}

echo json_encode([
    "categories" => $categories,
    "ordersPerCategory" => $ordersPerCategory,
    "years" => $years,
    "ordersPerYear" => $ordersPerYear,
    "totalRevenue" => $totalRevenue,
    "averageOrderValue" => $averageOrderValue,
    "mostSoldProducts" => $mostSoldProducts
]);

$mysqli->close();
?>
