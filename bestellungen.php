<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-HGSIs4Jxxz+TcNHkzjQ2vsP+T7KwL5lV0Tvz4IvNh7p7bFPU7EsPtcsZYD6GoO5j"
        crossorigin="anonymous">
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
        }

        .sidebar {
            margin-right: 100px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            height: 420px
        }

        .sidebar-header {
            border-radius: 10px;
            padding: 5px 10px;
        }

        .sidebar-menu {
            list-style-type: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            color: #333;
            text-decoration: none;
        }

        .sidebar-menu li a:hover {
            text-decoration: underline;
            background-color: lightgrey;
            border-radius: 5px;
        }

        .sidebar-menu li a.ordering {
            background-color: #c0c0c0; 
            font-weight: bold;
            border-radius: 5px;
            padding: 5px;
        }

        .profile-section {
            width: 1000px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            padding-top: 50px;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php' ?>
    <?php include 'Footer.php' ?>
    <main>
        <div class="container">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-header">
                    <h3>Menu</h3>
                </div>
                <ul class="sidebar-menu">
                    <li><a href="Profil.php?page=Profil" id="profil-tab">Profil<span class="Profil"><i class="fas fa-arrow-right"></i></span></a></li>
                    <li><a href="payment.php?page=Payment" id="zahlung-tab" class="zahlungsmoeglichkeiten">Payment<span class="arrow"><i class="fas fa-arrow-right"></i></span></a></li>
                    <li><a href="bestellungen.php?page=Bestellungen" id="bestellung-tab" class="ordering">Orders<span class="arrow"><i class="fas fa-arrow-right"></i></span></a></li>
                </ul>
            </aside>

            <!-- Main Content -->

            <div class="profile-section hidden">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Statics</h5>
                        <button class="btn-close" id="close-btn"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                       
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    </div>


</body>

</html>
