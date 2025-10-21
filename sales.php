<?php
// Database connection
require "config.php";

// Calculate 24-hour sales
$now = date("Y-m-d H:i:s");
$twentyFourHoursAgo = date("Y-m-d H:i:s", strtotime('-24 hours'));
$sql = "SELECT SUM(amount) AS total FROM invoicee WHERE created_at BETWEEN '$twentyFourHoursAgo' AND '$now'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$sales24Hours = $row["total"];

// Calculate 3-month sales
$threeMonthsAgo = date("Y-m-d H:i:s", strtotime('-3 months'));
$sql = "SELECT SUM(amount) AS total FROM invoicee WHERE created_at BETWEEN '$threeMonthsAgo' AND '$now'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$sales3Months = $row["total"];

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            text-align: center;
        }
        .sale-info {
            margin-bottom: 20px;
        }
        .sale-info h2 {
            margin-bottom: 10px;
        }
        .sale-info p {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sale-info">
            <h2>24-Hour Sales</h2>
            <p>Total Sales: $<?php echo number_format($sales24Hours, 2); ?></p>
        </div>
        <div class="sale-info">
            <h2>3-Month Sales</h2>
            <p>Total Sales: $<?php echo number_format($sales3Months, 2); ?></p>
        </div>
    </div>
</body>
</html>
