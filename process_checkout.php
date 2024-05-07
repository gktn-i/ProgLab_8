<?php
session_start();
$mysqli = require __DIR__ . "/Backend/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["card_number"]) && isset($_POST["expiration_date"]) && isset($_POST["cvv"])) {
     
        $card_number = $_POST["card_number"];
        $expiration_date = $_POST["expiration_date"];
        $cvv = $_POST["cvv"];
        $user_id = $_SESSION["user_id"]; // Benutzer-ID aus der Session erhalten

        $stmt = $mysqli->prepare("INSERT INTO payments (user_id, card_number, expiration_date, cvv) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $card_number, $expiration_date, $cvv);
        $stmt->execute();
        
        header("Location: order_success.php");
        exit();
    } else {
       
        $error_message = "Bitte füllen Sie alle erforderlichen Felder aus.";
    }
}

$user_id = $_SESSION["user_id"];

$user_check_sql = "SELECT id FROM user WHERE id = $user_id";
$user_check_result = $mysqli->query($user_check_sql);

if ($user_check_result && $user_check_result->num_rows === 0) {
    exit("Benutzer nicht gefunden");
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

<!DOCTYPE html>
<html lang="en">

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
            max-width: 1200px;
            margin: 20px auto;
        }

        .left-section {
            flex-basis: 50%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .right-section {
            flex-basis: 50%;
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
            width: calc(100% - 20px);
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        .form-group textarea {
            height: 100px;
        }

        .submit-btn {
            background-color: darkgreen;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
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
            <h1>Payment</h1>

            <?php if(isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="card_number">Card Number:</label>
                    <input type="text" id="card_number" name="card_number" required>
                </div>
                <div class="form-group">
                    <label for="expiration_date">Expiration Date:</label>
                    <input type="text" id="expiration_date" name="expiration_date" placeholder="MM/YYYY" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required>
                </div>
                <input type="submit" value="Submit Payment" class="submit-btn">
            </form>
        </div>

        <div class="right-section">
            <h1>Order Summary</h1>
           


        </div>
    </div>
</body>

</html>
