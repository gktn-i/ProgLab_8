<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
    <script src="Backend/script.js"></script>
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
            flex-basis: 30%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .right-section {
            flex-basis: 70%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            text-align: center;
        }

        .list-group {
            padding: 0;
            list-style: none;
        }

        .list-group-item {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;

        }

        .list-group-item label {
            font-weight: bold;
        }

        .form-group, .form-group2 {
            margin-bottom: 20px;
            flex-basis: 30%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .list-group-item:hover {
            background-color: #e9e9e9;
            transition: opacity 0.3s;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
            appearance: none;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'Navbar.php'; ?>
    <?php include 'Footer.php'; ?>
    <div class="container">
        <div class="left-section">
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="filter_options">Select Time Range</label>
                <select id="filter_options" name="filter_options">
                    <option value="all">ALL</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>
            <div class="form-group2">
                <label for="filter_options1">Theme</label>
                <select id="filter_options1" name="filter_options1">
                    <option value="list">List</option>
                    <option value="chart">Chart</option>
                </select>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="firstRadio" checked>
                    <label class="form-check-label" for="firstRadio">Best seller product</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="secondRadio">
                    <label class="form-check-label" for="secondRadio">Turnover</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="thirdRadio">
                    <label class="form-check-label" for="thirdRadio">Customer Count</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="fourthRadio">
                    <label class="form-check-label" for="fourthRadio">Best ?</label>
                </li>
                <li class="list-group-item">
                    <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="" id="fifthRadio">
                    <label class="form-check-label" for="fifthRadio">Order Count</label>
                </li>
            </ul>
        </div>
        <div class="right-section">
            <h1>Statistics</h1>
<<<<<<< HEAD
=======
            
            <div class="card" id="best-store-card">
                <div class="card-header">
                    Best Store with Highest Turnover
                </div>
                <div class="card-body">
                    <h5 class="card-title" id="best-store-name"></h5>
                    <p class="card-text" id="best-store-turnover"></p>
                    <canvas id="turnoverChart"></canvas>
                </div>
            </div>

>>>>>>> parent of 247bea6 (update hidden)
            <div id="chartContainer">
                <canvas id="myChart"></canvas>
            </div>
            <ul class="list-group" id="dataList">
                <!-- Placeholder for list data -->
            </ul>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
