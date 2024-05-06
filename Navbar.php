<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar {
            background-color: #3C5131;
            box-shadow: 10px 13px 40px rgba(71, 71, 71, 0.658);
            border-radius: 5px;
            margin: 20px;
            backdrop-filter: blur(200px);
            


        }

        .navbar-dark .navbar-nav .nav-link {
            color: white;
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
            margin-right: 20px;
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
            height: 70px;
            margin-left: 20px;
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

        
    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <b>
                <a href="index.php?page=start">
                    <img src="Frontend/img/AD Logo.png" alt="" class="navimg" style="height: 80px; width: 80px;">
                </a>
            </b>
            <form class="search-bar d-flex">
                <input class="form-control me-2" type="search" placeholder="Suchen" aria-label="Search">
                <button class="btn btn-outline-primary white-button" type="submit">Suchen</button>
            </form>

            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION["user_id"])): ?>

                    <a class="navbar-sign" href="Backend/logout.php">
                        <img src="Frontend/img/login.svg" alt="" class="Sign-img">
                    </a>
                <?php else: ?>

                    <a class="navbar-sign" href="Signin.php?page=Anmelden">
                        <img src="Frontend/img/einloggen.svg" alt="" class="Sign-img">
                    </a>
                <?php endif; ?>
                <a class="navbar" href="Order.php?page=Warenkorb">
                    <img src="Frontend/img/cart.svg" alt="" class="white-img">
                    <span class="badge bg-white text-dark">2</span>
                </a>
                <a class="navbar-brand" href="Profil.php?page=Log In " style="margin-top: 5px;">
                    <img src="Frontend/img/profil.svg" alt="" class="white-img">
                </a>
            </div>
        </div>
    </nav>

    <?php
    /* echo ' <h1>' . $_GET['page'] . ' </h1>'; */
    ?>
</body>

</html>
