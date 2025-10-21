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

    <title>Recent Transactions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/asset.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        .container {
            max-width: 600px;
            margin: 10px auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .transaction {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .transaction img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .transaction-details {
            flex-grow: 1;
        }

        .transaction h4 {
            margin: 0;
            font-size: 18px;
        }

        .transaction p {
            margin: 5px 0 0;
            color: #777;
        }
        .pay-button {
            background-color: #3498db;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
            text-decoration: none;
        }
        .paid {
            background-color: #28a745;
            color: #fff; /* Green color for paid transactions */
            padding: 8px 13px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
            text-decoration: none;
            
        }

    </style>
</head>
<body>

    <div class="container" >
    <div class="gst">
      <a href="home.php" >
      <i class="material-icons nav__icon">arrow_back</i>
      </a>
      <div class = "sentence"> <p> Transactions </p></div>
    </div>
        <?php
        require "config.php";

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $result = $con->query("SELECT * FROM transactions where comemail = '" . $_SESSION['comemail'] . "' ORDER BY timestamp DESC");

        while ($row = $result->fetch_assoc()) {
            $amount = $row['amount'];
            echo '<div class="transaction">';
            echo '<div class="transaction-details">';
            echo '<h4>' . $row['description'] . '</h4>';
            echo '<p>' . 'Amount - ' . '₹' . $row['amount'] . '</p>';
            echo '<span>' .'Date - '. date('d-m-Y', strtotime($row['timestamp'])) . '</span>';
            echo '</div>';
            if ($row['status'] == 'paid') {
            echo '<a class="paid">Paid</a>';
            } else {
            echo  '<a class="pay-button" href="upi://pay?pa=amitk22225-1@okhdfcbank&pn=%20&tr=%20&am=' . $amount . '&cu=INR">Pay via UPI</a>';
            // echo  '<a class="pay-button" href="https://internetbanking.hdfcbank.com/netbanking/?_ga=2.137206542.1399836486.1644529459-935951535.1644529459">Pay via Internet Banking</a>';
            }
            echo '</div>';
        }
        $con->close();
        
        ?>
    </div>

</body>
</html>
