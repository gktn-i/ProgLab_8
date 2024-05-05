<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/Backend/database.php";

    $sql = sprintf("SELECT * FROM user 
                     WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"])
    );

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) { 
        if (password_verify($_POST["password"], $user["password_hash"])) { 
            session_start();

            $_SESSION["user_id"] = $user["id"];

            header("Location: index.php");
            exit;
        }
    }

    $is_invalid = true;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {

            height: 100vh;
            margin-top: 20px;

        }

        .container {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 50px;
            margin-top: 50px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }


        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
        }

        .container input[type="email"],
        .container input[type="password"] {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
            border-color: #ccc;
            border-radius: 5px;

        }

        .btn-login {
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

        .btn-close {
            margin-right:
        }

        .signin {
            background-color: darkgrey;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 2px 15px;
            cursor: pointer;
            width: 20%;
            margin-top: 5px;
            margin-left: 750px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php' ?>
    <?php include 'Footer.php' ?>

    <?php if ($is_invalid): ?>
        <em> Invalid Login</em>
     <?php endif; ?>

    <form method="post">
    
        <div class="container">
            <div class="form-group">
               
                <label for="exampleFormControlInput1">Email adress</label>
                <input type="email" id="email" name="email" placeholder="name@example.com"
                        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
            </div>
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" id="Password" name="password">


                <button class="btn-login">Log In</button>
            </div>
            <a href="forgot_password.php">Forgot password?</a>
        </div>
    </form>
    <a href="createaccount.php" class="text-decoration-none text-dark1">
        <button class="signin">CREATE Account</button>
    </a>
</body>

</html>