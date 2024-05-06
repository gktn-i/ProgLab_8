<?php
session_start();
$user = [];

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/Backend/database.php";

    // Benutzerinformationen abrufen
    $user_sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $user_result = $mysqli->query($user_sql);
    if ($user_result && $user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
    } else {
        echo "Keine Benutzerdaten gefunden.";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
        $iban = isset($_POST["iban"]) ? $_POST["iban"] : '';
        $securityCode = isset($_POST["security_code"]) ? $_POST["security_code"] : '';


        $update_sql = "UPDATE user SET iban = '{$iban}', SecurityCode = '{$securityCode}' WHERE id = {$_SESSION["user_id"]}";
        $update_result = $mysqli->query($update_sql);

    }
}
?>
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

    .sidebar-menu li a.zahlungsmoeglichkeiten {
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


    .btn-primary {
        background-color: darkgreen;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        font-weight: bold;
        font-size: 20px;
    }

    .btn-primary:hover {
        background-color: green;
    }

    .banksenden button {
        background-color: darkgreen;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
        font-weight: bold;
        text-align: center;
        font-size: 20px;
    }

    .banksenden button:hover {
        background-color: green;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

</head>

<body>

    <?php include 'Navbar.php' ?>
    <?php include 'Footer.php' ?>

    <main>
        <div class="container">
            <aside class="sidebar">
                <div class="sidebar-header">
                    <h3>Menu</h3>
                </div>
                <ul class="sidebar-menu">
                    <li><a href="Profil.php?page=Profil" id="profil-tab">Profil<span class="Profil"><i
                                    class="fas fa-arrow-right"></i></span></a></li>
                    <li><a href="payment.php?page=Payment" id="zahlung-tab" class="zahlungsmoeglichkeiten">Payment<span
                                class="arrow"><i class="fas fa-arrow-right"></i></span></a></li>
                    <li><a href="bestellungen.php?page=Bestellungen" id="bestellung-tab" class="ordering">Orders<span
                                class="arrow"><i class="fas fa-arrow-right"></i></span></a></li>
                </ul>
            </aside>
            <div class="profile-section hidden">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Payment</h5>
                        <button class="btn-close" id="close-btn"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form method="post">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name"
                                            value="<?php echo isset($_SESSION["user_id"]) ? htmlspecialchars($user["name"]) : ''; ?>"
                                            readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="iban" class="form-label">IBAN</label>
                                        <input type="text" class="form-control" id="iban" name="iban"
                                            value="<?php echo isset($user["iban"]) ? htmlspecialchars($user["iban"]) : ''; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="securityCode" class="form-label">Securitycode</label>
                                        <input type="text" class="form-control" id="securityCode" name="security_code"
                                            value="<?php echo isset($user["SecurityCode"]) ? htmlspecialchars($user["SecurityCode"]) : ''; ?>">
                                    </div>
                                    <div class="banksenden">
                                        <button type="submit" name="update">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>