<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/Backend/database.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user == null) {
    die("token not found");

}

if (strtotime($user["reset_token_expires_at"]) <= time()) {

    die("token has expired");

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        form {
            width: 300px;
            margin: 0 auto;
            text-align: center;
            margin-top: 70px;
            font-size: 20px;

        }

        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;

        }

        input[type="password"] {
            width: 100%;
            box-sizing: border-box;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .unique-button {
            width: 100%;
            background-color: green;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .unique-button:hover {
            background-color: darkgreen;
        }
    </style>
</head>

<body>

    <?php include 'Navbar.php'; ?>
    <?php include 'Footer.php'; ?>


    <form method="post" action="process_reset_password.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="info">Please enter your new password</label>
      <br>
      <br>
        <label for="password">New password</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button class="unique-button">Send</button>
    </form>
</body>

</html>