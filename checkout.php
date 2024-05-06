<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Restaurant Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
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

    <main>
        <h1>Checkout</h1>

        <section>
            <h2>Delivery Address</h2>
            <form action="process_checkout.php" method="post">
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
                <label for="full_name">First and Last Name:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
        </section>

        <button type="submit" class="submit-btn">Order & Pay</button>
        </form>
    </main>

    <?php include 'Footer.php'; ?>
</body>

</html>