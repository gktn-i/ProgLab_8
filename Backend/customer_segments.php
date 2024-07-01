<?php
include 'database.php';
$mysqli = require __DIR__ . "/database.php";

$query = "
SELECT customers.customerID, SUM(orders.total) as total_spent
FROM customers
JOIN orders ON customers.customerID = orders.customerID
GROUP BY customers.customerID
ORDER BY total_spent DESC
";

$result = $mysqli->query($query);

if (!$result) {
    die("Error in query: $query. " . $mysqli->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Gesamtumsatz berechnen
$total_revenue = array_sum(array_column($data, 'total_spent'));

// ABC-Grenzwerte festlegen (A: Top 20%, B: Nächste 30%, C: Letzte 50%)
$a_limit = 0.2 * $total_revenue;
$b_limit = 0.5 * $total_revenue;

$a_count = 0;
$b_count = 0;
$c_count = 0;

$current_revenue = 0;
foreach ($data as $customer) {
    $current_revenue += $customer['total_spent'];
    if ($current_revenue <= $a_limit) {
        $a_count++;
    } elseif ($current_revenue <= $b_limit) {
        $b_count++;
    } else {
        $c_count++;
    }
}

// Ergebnis als JSON zurückgeben
header('Content-Type: application/json');
echo json_encode([
    'a_count' => $a_count,
    'b_count' => $b_count,
    'c_count' => $c_count,
]);

$mysqli->close();
?>