<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        form {
            width: 300px;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
        }

        .rahmen {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            margin: 70px auto;
            width: 900px;
            height: 500px;
        }

    

        input[type="email"] {
            width: 100%;
            box-sizing: border-box;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); 
            margin-top: 30px;
            margin-bottom: 80px;
        }

        button {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 40px;
            border-radius: 20px;
            cursor: pointer;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); 
            width: 150px;
            text-align: center;
            border-radius: 8px;
            
        }

        button:hover {
            background-color: darkgreen;
        }
        label{
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>
    <?php include 'Footer.php'; ?>
    <div class="rahmen">
        <form method="post" action="send_password_reset.php">
            <label for="email">Please enter your Email</label>
            <input type="email" name="email" id="email">

            <button>Send</button>
        </form>
    </div>
</body>

</html>
