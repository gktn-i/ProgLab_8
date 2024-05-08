<?php
session_start();
$mysqli = require __DIR__ . "/Backend/database.php";

if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    exit("Benutzer-ID nicht korrekt gesetzt");
}

$user_id = $_SESSION["user_id"];

$user_check_sql = "SELECT id FROM user WHERE id = $user_id";
$user_check_result = $mysqli->query($user_check_sql);

if ($user_check_result && $user_check_result->num_rows === 0) {
    exit("Benutzer nicht gefunden");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $street_name = $_POST["street_name"];
    $house_number = $_POST["house_number"];
    $postcode = $_POST["postcode"];
    $city = $_POST["city"];
    $floor = isset($_POST["floor"]) ? $_POST["floor"] : "";
    $company_name = isset($_POST["company_name"]) ? $_POST["company_name"] : "";
    $note = isset($_POST["note"]) ? $_POST["note"] : "";
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];


    $stmt = $mysqli->prepare("INSERT INTO userinfo (user_id, street_name, house_number, postcode, city, floor, company_name, note, full_name, email, phone) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


    $stmt->bind_param("issssssssss", $user_id, $street_name, $house_number, $postcode, $city, $floor, $company_name, $note, $full_name, $email, $phone);


    if ($stmt->execute()) {
        header("Location: process_checkout.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }


}


$user_sql = "SELECT name, email FROM user WHERE id = $user_id";
$user_result = $mysqli->query($user_sql);

$full_name = "";
$email = "";

if ($user_result && $user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
    $full_name = $user_data["name"];
    $email = $user_data["email"];
}


$mysqli->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout & Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 20px auto;
        }

        .left-section {
            flex-basis: 60%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .right-section {
            flex-basis: 35%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .submit-btn {
            background-color: darkgreen;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: green;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>
    <?php include 'Footer.php'; ?>

    <div class="container">
        <div class="left-section">
            <h1>Checkout & Payment</h1>

            <section>
                <h2>Delivery Address</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="street_name">Street Name:</label>
                        <input type="text" id="street_name" name="street_name" required>
                    </div>
                    <div class="form-group">
                        <label for="house_number">House Number:</label>
                        <input type="text" id="house_number" name="house_number" required>
                    </div>
                    <div class="form-group">
                        <label for="postcode">Postcode:</label>
                        <input type="text" id="postcode" name="postcode" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="floor">Floor (optional):</label>
                        <input type="text" id="floor" name="floor">
                    </div>
                    <div class="form-group">
                        <label for="company_name">Company Name (optional):</label>
                        <input type="text" id="company_name" name="company_name">
                    </div>
                    <div class="form-group">
                        <label for="note">Add Note (optional):</label>
                        <textarea id="note" name="note" rows="4" cols="50"></textarea>
                    </div>
            </section>

            <section>
                <h2>Personal Details</h2>
                <div class="form-group">
                    <label for="name">First and Last Name:</label>
                    <input type="text" id="name" name="full_name" value="<?php echo $full_name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
            </section>

            <button type="submit" class="submit-btn">Order & Pay</button>
            </form>
        </div>

        <div class="right-section">
            <h2>Order Summary</h2>
            <!-- Bestellung anzeigen -->
        </div>
    </div>
</body>

</html>
