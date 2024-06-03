<?php
include 'Backend/get_total_product.php';
$products = get_unique_products();


if ($products === null || !is_array($products)) {
    echo "Fehler beim Abrufen der Produkte.";

    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Backend/total_product_script.js"></script>
    <title>Total Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1300px;
            margin: 50px auto;
            animation: fadeIn 1s ease-in;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .product-card {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            text-align: center;
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 300px;
            transition: all 0.3s ease;
            position: relative;
            
        }

        .product-card h2 {
            font-size: 18px;;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 1.2em;
            color: #333;
        }

        .info-button {
            background-color: #2d6a4f;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 1.5em;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: absolute;
            bottom: 10px; 
            right: 10px;
            transition: background-color 0.3s;
        }

        .info-button:hover {
            background-color: #1b4332;
        }

        .product-info {
            display: none;
            margin-top: 10px;
            text-align: left;
        }

        .section-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .section {
            flex: 1;
            background-color: #fff;
            border-radius: 10px;
            padding: 10px;
            margin: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            height: 500px;
            width: calc(50% - 40px);
            max-width: 600px;
            border-color: #666666;
            border: 1px solid;

        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <h1 style="text-align: center; margin: 20px 0; font-size: 20px;">Productlist</h1>
    <div class="container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <h2><?php echo htmlspecialchars($product['Name']); ?></h2>
                <p>$<?php echo htmlspecialchars($product['Price']); ?></p>
                <div id="info-<?php echo htmlspecialchars($product['SKU']); ?>" class="product-info"></div>
                <button class="info-button"
                    onclick="toggleIngredients('<?php echo htmlspecialchars($product['SKU']); ?>')">i</button>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="section-container">
        <div class="section"></div>
        <div class="section"></div>
    </div>

    <div class="section-container">
        <div class="section"></div>
        <div class="section"></div>
    </div>

</body>

</html>
