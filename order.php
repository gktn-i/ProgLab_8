<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellungen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);


        }

        .container h1 {
            font-size: 20px;
        }


        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f0f0f0;
            border-bottom: 1px solid #ccc;
        }

        .card-body {
            height: 50px
        }

        .card-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 5px;
            background-color: #f0f0f0;
            border-top: 1px solid #ccc;
            height: 40px;
        }

        .card-footerprice {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 10px;
            background-color: #f0f0f0;
            border-top: 1px solid #ccc;
            margin-top: 15px;
            height: 30px;
        }

        .btn-close {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
        }

        .btn-buy {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: darkgreen;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }

        .btn-buy:hover {
            background-color: #006400;
        }

        .quantity {
            background-color: #ddd;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .card-header h2 {
            font-size: 18px;
        }

        .card-footerprice {
            font-size: 24px;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>
    
    <div class="container">
        <h1>Orders</h1>

        <div class="card">
            <div class="card-header">
                <h2>Burger</h2>
                <button class="btn-close"><i class="fas fa-trash"></i></button>
            </div>
            <div class="card-body">
                <p>Produktbeschreibung und Details hier...</p>
            </div>
            <div class="card-footer">
                <span class="quantity">1</span>
                <span class="price">13.00€</span>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Pizza</h2>
                <button class="btn-close"><i class="fas fa-trash"></i></button>
            </div>
            <div class="card-body">
                <p>Produktbeschreibung und Details hier...</p>
            </div>
            <div class="card-footer">
                <span class="quantity">1</span>
                <span class="price">13.00€</span>

            </div>
            <div class="card-footerprice">
                <span class="sumit">Total: 26.00€</span>
            </div>

        </div>



        <a href="checkout.php" class="btn-buy">Checkout</a>
    </div>
</body>
<?php include 'Footer.php'; ?>
</html>
