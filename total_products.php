<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Products</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="Backend/total_product_script.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1300px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }


        .highlighted-row {
            background-color: #2d6a4f;
            color: #fff;

        }

        .highlighted-row td {
            border-radius: 8px;
        }

        .product-card {
            margin: 20px;
            padding: 20px;
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
        }

        .product-card h2 {
            font-size: 24px;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 18px;
            color: #333;
        }

        .info-button {
            background-color: #2d6a4f;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: absolute;
            bottom: 20px;
            right: 20px;
            transition: background-color 0.3s;
        }

        .info-button:hover {
            background-color: #1b4332;
        }

        .product-card p {
            font-size: 18px;
            line-height: 1.5;
            color: #333;
        }

        .section-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 0px;
            margin-bottom: 20px;
        }

        .section {
            flex: 1;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            border: 1px solid #666666;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .dropdown-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .dropdown-select {
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #2d6a4f;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        #mostSoldProductsTableContainer table tbody td {
            padding: 5px 10px 5px 10px;
            /* Reduced left padding */
            font-size: 18px;
            text-align: right;
            /* Align text to the right */
        }

        #mostSoldProductsTableContainer table th,
        #mostSoldProductsTableContainer table td {
            padding: 5px 65px;
            font-size: 18px;
            word-spacing: 5px;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <h1 style="text-align: center; margin: 20px 0; font-size: 20px;">Productlist</h1>
    <div class="dropdown-container">
        <select id="sizeSelect" class="dropdown-select" onchange="filterProducts()">
            <option class="dropdown-option" value="Small">Small</option>
            <option class="dropdown-option" value="Medium">Medium</option>
            <option class="dropdown-option" value="Large">Large</option>
            <option class="dropdown-option" value="Extra Large">Extra Large</option>
        </select>
    </div>
    <div class="container" id="productList"></div>

    <h1 style="text-align: center; margin: 20px 0; font-size: 20px;">Order Statistics</h1>

    <div class="dropdown-container">
        <select id="categorySelect" class="dropdown-select">
        </select>
    </div>

    <div class="container">
        <section class="section">
            <canvas id="ordersPerCategoryChart"></canvas>
        </section>
        <section class="section">
            <canvas id="ordersPerYearChart"></canvas>
        </section>
    </div>
    <div class="container">
        <section class="section">
            <div id="mostSoldProductsTableContainer"></div>
        </section>
        <section class="section">
            <canvas id="averageOrderValueChart"></canvas>
        </section>
    </div>
</body>

</html>