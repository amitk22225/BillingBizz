<?php 
require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/asset.css">
    <link rel="stylesheet" href="bootstrap.min.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin: 10px auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .records-list {
            padding: 0;
        }

        .record-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 10px;
        }

        .record-item h2 {
            margin-top: 0;
        }

        .search-box {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-box label {
            font-size: 18px;
            margin-right: 10px;
        }

        .search-box select, .search-box input, .search-box button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
            font-size: 16px;
        }

        .search-box button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .search-box button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="gst">
        <a href="home.php" >
        <i class="material-icons nav__icon">arrow_back</i>
        </a>
        <div class = "sentence"> <p> Records </p></div>
        </div>

        <!-- Search Box -->
        <div class="search-box">
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="criteria">Search by:</label>
                <select id="criteria" name="criteria">
                    <option value="CNAME">Customer Name</option>
                    <option value="customeremail">Customer Email</option>
                    <option value="INVOICE_NO">Challan Number</option>
                    <option value="INVOICE_DATE">Challan Date</option>
                </select>
                <input type="text" id="search" name="search" placeholder="Search term" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit"><i class="fas fa-search"></i> Search</button>
            </form>
        </div>

        <div class="records-list">
            <?php
            require 'config.php';

            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
            $criteria = isset($_GET['criteria']) ? $_GET['criteria'] : 'CNAME';

            $result = $con->query("SELECT * FROM invoicee WHERE comname = '" . $_SESSION['comname'] . "' AND $criteria LIKE '%$searchTerm%' ORDER BY INVOICE_DATE DESC");

            while ($row = $result->fetch_assoc()) {
                echo '<div class="record-item">';
                echo '<p>Customer Name: ' . $row['CNAME'] . '</p>';
                echo '<p>Customer Email: ' . $row['customeremail'] . '</p>';
                echo '<p>Invoice No.: ' . $row['INVOICE_NO'] . '</p>';
                echo '<p>Invoice Date: ' . $row['INVOICE_DATE'] . '</p>';

                echo '<a href="print.php?id= ' . $row['SID'] . ' &ACTION=VIEW" class="material-icons mx-3" style="text-decoration: none;">&#xe8a0;</a>';
                echo '<a href="print.php?id= ' . $row['SID'] . ' &ACTION=EMAIL" class="material-icons mx-3" style="text-decoration: none;">&#xe0be;</a>';
                echo '<a href="print.php?id= ' . $row['SID'] . ' &ACTION=DOWNLOAD" class="material-icons mx-3" style="text-decoration: none;">&#xe2c4;</a>';
                echo '<a href="print.php?id= ' . $row['SID'] . ' &ACTION=DELETE" class="material-icons mx-3" style="text-decoration: none;">&#xe872;</a>';
                // Add more details as needed
                echo '<a href="edit_invoice.php?id= ' . $row['SID'] . ' "class="material-icons mx-3" style="text-decoration: none;">&#xe3c9;</a>';
                echo '</div>';
            }

            $con->close();
            ?>
        </div>
    </div>

</body>
</html>