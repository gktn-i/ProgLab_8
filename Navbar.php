<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .navbar {

            border-radius: 5px;
            margin: 20px;
            backdrop-filter: blur(200px);
            justify-content: center;
        }

        .navbar-brand {
            margin: 0;
        }



        .search-bar {
            width: 30%;
            margin: 0 auto;
        }

        .white-button {
            color: white;
            border-color: white;
        }

        .navbar img {
            width: 40px;

        }

        .white-img {
            filter: invert(1);
        }

        .Sign-img {
            filter: invert(1);
            width: 20px;
            margin-top: 5px;
            margin-right: 15px;
        }

        .navimg {
            height: 80px;
            width: 80px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 50%;
        }

        .btn.btn-outline-primary.white-button {
            background-color: #3C5131;
        }

        .badge {
            border-radius: 8px;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 24px;
            color: #3C5131;
            margin-right: 20px;
            margin-top: 5px;
            text-decoration: none;
        }

        .navbar-icon {
            font-size: 50px;
            color: white;
            transition: all 0.3s ease;
            margin: 12px;
        }

        .navbar-icon:hover {
            color: hsl(140, 100%, 20%);
            transition: opacity 0.3s;
            text-shadow: 0px 0px 5px rgba(0, 0, 0, 0.4);
        }

        .statistics {
            display: flex;
            justify-content: space-around;
            margin: 20px auto;
            max-width: 1200px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .stat-box {
            min-width: fit-content;
            flex: 1;
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 1s ease-in;
            border: 1px solid;
            border-color: #666;
            transition: transform 0.3s ease-in-out;
            text-decoration: none;

        }

        .stat-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-content i {
            font-size: 24px;
            margin-right: 10px;
            color: darkgreen;
        }

        .stat-box h2 {
            margin: 0;
            font-size: 24px;
            color: darkgreen;
            user-select: none
        }

        .stat-box p {
            margin: 10px 0 0;
            font-size: 18px;
            color: #666;
            font-weight: bold;
            user-select: none
        }

        .stat-box:hover {
            transform: translateY(-5px);
        }

    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid d-flex justify-content-center">
            <a href="index.php?page=start" class="navbar-brand">
                <img src="Frontend/img/AD Logo2.png" alt="" class="navimg" style="height: 90px; width: 90px;">
            </a>

    </nav>



    </div>
    </div>

    <div class="statistics">
        <a href="total_orders.php" class="stat-box">
            <h2><i class='bx bxs-user-detail'></i> <span id="totalOrders">0</span></h2>
            <p>Total Orders</p>
        </a>
        <a href="total_revenue.php" class="stat-box">
            <h2><i class='bx bxs-dollar-circle'></i> <span id="totalRevenue">$0.00</span></h2>
            <p>Total Revenue</p>
        </a>
        <a href="total_customers.php" class="stat-box">
            <h2><i class='bx bxs-group'></i> <span id="totalCustomers">0</span></h2>
            <p>Total Customers</p>
        </a>
        <a href="total_products.php" class="stat-box">
            <h2><i class='bx bxs-box'></i> <span id="totalProducts">0</span></h2>
            <p>Total Products</p>
        </a>
    </div>


    <?php
    /* echo ' <h1>' . $_GET['page'] . ' </h1>'; */
    ?>
</body>

</html>