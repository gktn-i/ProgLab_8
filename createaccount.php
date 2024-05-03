<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
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

        .name {

            text-align: left;
            padding-bottom: 10px;
    

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
        .container input[type="name"],
        .container input[type="password"] {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
            border-color: #ccc;
            border-radius: 5px;

        }



        .btn-close {
            margin-right:
        }

        .signin {
            background-color: #093867;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 2px 15px;
            cursor: pointer;
            width: 20%;
            margin-top: 50px;
            font-size: 20px;
            font-weight: bold;
        }

        .centered {
            text-align: center;
        }

        .logging {
            background-color: grey;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 2px 15px;
            cursor: pointer;
            font-size: 20px;
            margin-top: 0px;
            width: 100px;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php' ?>
    <?php include 'Footer.php' ?>

    <form action="Backend\signup.php" method="post">
        <div class="container">
            <div class="name">
                <label for="name">Name</label>
                <input type="text" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Email adress</label>
                <input type="email" id="email" name="email" placeholder="name@example.com">
            </div>
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" id="Password" name="password">
            </div>
            <div class="form-group">
                <label for="confirmpassword">Repeat Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>
            <button class="signin">CREATE Account</button>
        </div>
    </form>



    <div class="centered">
        <a href="Signin.php">
            <button class="logging">Log In</button>
        </a>
    </div>

</body>

</html>