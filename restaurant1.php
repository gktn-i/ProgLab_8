<?php
$mysqli = require __DIR__ . "/Backend/database.php";

function getProductData($sku, $mysqli) {
    $sql = "SELECT Name, Size, Price, Ingredients FROM products WHERE SKU = '$sku'";
    $result = $mysqli->query($sql);
    $productName = "Produkt nicht gefunden";
    $sizes_prices = [];
    $ingredients = '';

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $productName = $row['Name'];
            $sizes_prices[$row["Size"]] = $row["Price"];
            $ingredients = $row['Ingredients'];
        }
    } else {
        $productName = "Fehler bei der Abfrage: " . $mysqli->error;
    }

    return [
        'name' => $productName,
        'sizes_prices' => $sizes_prices,
        'ingredients' => $ingredients
    ];
}

$menuItems = [
    ['sku' => 'PZ001', 'name' => 'Margherita Pizza'],
    ['sku' => 'PZ002', 'name' => 'Gericht 2'],
    ['sku' => 'PZ003', 'name' => 'Gericht 3'],
    ['sku' => 'PZ004', 'name' => 'Gericht 4']
];

$menuData = [];

foreach ($menuItems as $menuItem) {
    $menuData[$menuItem['sku']] = getProductData($menuItem['sku'], $mysqli);
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .restaurant-info {
            padding: 20px;
            position: relative;
        }

        .restaurant-name {
            margin-top: 50px;
            font-size: 24px;
            font-weight: bold;
            margin-left: 70px;
            margin-bottom: 5px;
        }

        .rating {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            margin-left: 70px;
        }

        .delivery-minimum {
            font-size: 18px;
            margin-bottom: 5px;
            margin-left: 70px;
        }

        .waiting-time {
            font-size: 18px;
            margin-bottom: 20px;
            margin-left: 70px;
        }

        .map {
            position: absolute;
            top: 50px;
            right: 85px;
            width: 400px;
            height: 300px;
            background-image: url('placeholder-map.jpg');
            background-size: cover;
            background-position: center;
        }

        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 10px;
            margin-top: 150px;
        }

        .menu-item {
            flex: 0 0 calc(25% - 40px);
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px;
            padding: 20px;
            position: relative;
        }

        .menu-item-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .menu-item-ingredients {
            margin-bottom: 10px;
        }

        .menu-item-price {
            font-weight: bold;
        }

        .add-to-cart {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
   <?php include 'Navbar.php' ?>
    <?php include 'Footer.php' ?>
    <div class="restaurant-info">
        <div class="restaurant-name">Name of the restaurant</div>
        <div class="rating">Rating: 4.5 / 5</div>
        <div class="delivery-minimum">Minimum order amount: 10€</div>
        <div class="waiting-time">Delivery time: 30 Minuten</div>
        <div class="map">
            <!-- Testzweck -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2557.6381740955735!2d8.689929912601421!3d50.13049227141419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47bd0ec720c4d695%3A0x2fd6b25adf3bf545!2sFrankfurt%20University%20of%20Applied%20Sciences!5e0!3m2!1sde!2sde!4v1714310373498!5m2!1sde!2sde" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    <div>
        <div class="menu">
            <?php foreach ($menuData as $sku => $data): ?>
                <div class="menu-item">
                    <div class="menu-item-name"><?php echo $data['name']; ?></div>
                    <?php if (!empty($data['ingredients'])): ?>
                        <div class="menu-item-ingredients"><?php echo $data['ingredients']; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($data['sizes_prices'])): ?>
                        <?php foreach ($data['sizes_prices'] as $size => $price): ?>
                            <div><?php echo $size . ': ' . $price; ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>Größen und Preise nicht verfügbar</div>
                    <?php endif; ?>
                    <div class="add-to-cart">+</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
