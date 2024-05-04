<?php
session_start();
$user = [];
$email = [];
$password_hash = [];

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/Backend/database.php";

    // Benutzerinformationen abrufen
    $user_sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $user_result = $mysqli->query($user_sql);
    if ($user_result && $user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
    }

    // E-Mail-Adresse abrufen
    $email_sql = "SELECT email FROM user WHERE id = {$_SESSION["user_id"]}";
    $email_result = $mysqli->query($email_sql);
    if ($email_result && $email_result->num_rows > 0) {
        $email_row = $email_result->fetch_assoc();
        $email = $email_row["email"];
    }

    // Passwort abrufen
    $password_hash_sql = "SELECT password_hash FROM user WHERE id = {$_SESSION["user_id"]}";
    $password_hash_result = $mysqli->query($password_hash_sql);
    if ($password_hash_result && $password_hash_result->num_rows > 0) {
        $password_hash_row = $password_hash_result->fetch_assoc();
        $password_hash = $password_hash_row["password_hash"];
    }
}

?>


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
        integrity="sha384-HGSIs4Jxxz+TcNHkzjQ2vsP+T7KwL5lV0Tvz4IvNh7p7bFPU7EsPtcsZYD6GoO5j" crossorigin="anonymous">
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

        .sidebar-menu li:first-child a {

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

<?php include 'Navbar.php' ?>
<?php include 'Footer.php' ?>
<main>
    <div class="container">
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
        <div class="profile-section hidden">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Profil</h5>
                    <button class="btn-close" id="close-btn"><i class="fas fa-times"></i></button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name"
                                    value="<?php echo isset($_SESSION["user_id"]) ? htmlspecialchars($user["name"]) : ''; ?>"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email"
                                    value="<?php echo isset($_SESSION["user_id"]) ? htmlspecialchars($email) : ''; ?>"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password"
                                    value="<?php echo isset($_SESSION["user_id"]) ? htmlspecialchars($password_hash) : ''; ?>"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label for="tel" class="form-label">Phone number</label>
                                <input type="tel" class="form-control" id="tel" value="0123456789">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

</html>
