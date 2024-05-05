<?php
session_start();

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">


    <style>
        .custom-sidebar {
            margin-left: -130px;
            padding-top: 40px;
        }

        .custom-main-content {
            margin-left: 130px;
            padding-top: 30px;
        }
    </style>
</head>



<body>
<!-- <?php if (isset($_SESSION["user_id"])): ?>
   
    <p><a href="Backend\logout.php">Log out</a></p>

    <?php  else: ?>
        <p><a href = "Signin.php">Log in </a> or <a href="createaccount.php">sign up</a></p>


        <?php endif;
        ?>  -->

    <?php include 'Navbar.php' ?>
    <?php include 'Footer.php' ?>

    <main class="container">
        <div class="row mt-3">
            <!-- Sidebar -->
            <aside class="col-md-3 custom-sidebar">
                <div class="mb-3 custom-card">
                    <h5>Now open</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="openstatus" Default>
                        <label class="form-check-label" for="openstatus">now open</label>
                    </div>
                </div>

                <div class="mb-3 custom-card">
                    <h5>Free delivery</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="freeDelivery">
                        <label class="form-check-label" for="freeDelivery">Free delivery</label>
                    </div>
                </div>
                <div class="mb-3 custom-card">
                    <div class="mb-3">
                        <h5>Minimum order</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="displayyall">
                            <label class="form-check-label" for="displayall">View all</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="underten">
                            <label class="form-check-label" for="underten">Under 10€</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="undertwenty">
                            <label class="form-check-label" for="undertwenty">Under 20€</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 custom-card">
                    <h5>Rating</h5>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="displayyall">
                            <label class="form-check-label" for="displayall">View all</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="underten">
                            <label class="form-check-label" for="underten">Over 4 stars</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="undertwenty">
                            <label class="form-check-label" for="undertwenty">over 3 stars</label>
                        </div>
                    </div>
                </div>
            </aside>


            <!-- Main Content -->
            <section class="col-md-9 custom-main-content">
                <div class="white-bg">
                    <div class="card mb-3">
                        <a href="restaurant1.php" class="text-decoration-none text-dark">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="..." class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Restaurant 1</h5>
                                        <p class="card-text">Kleine Beschreibung</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card mb-3">
                        <a href="restaurant1.php" class="text-decoration-none text-dark">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="..." class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Restaurant 2</h5>
                                        <p class="card-text">Kleine Beschreibung</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card mb-3">
                        <a href="restaurant1.php" class="text-decoration-none text-dark">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="..." class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Restaurant 3</h5>
                                        <p class="card-text">Kleine Beschreibung</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card mb-3">
                        <a href="restaurant1.php" class="text-decoration-none text-dark">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="..." class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Restaurant 4</h5>
                                        <p class="card-text">Kleine Beschreibung</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card mb-3">
                        <a href="restaurant1.php" class="text-decoration-none text-dark">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="..." class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Restaurant 5</h5>
                                        <p class="card-text">Kleine Beschreibung</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card mb-3">
                        <a href="restaurant1.php" class="text-decoration-none text-dark">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="..." class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Restaurant 6</h5>
                                        <p class="card-text">Kleine Beschreibung</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>