<?php
require "config.php"; // Include your database configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_name = mysqli_real_escape_string($con, $_POST["customer_name"]);
    $customer_address = mysqli_real_escape_string($con, $_POST["customer_address"]);
    $customer_city = mysqli_real_escape_string($con, $_POST["customer_city"]);
    $customer_email = mysqli_real_escape_string($con, $_POST["customer_email"]);

    // Insert data into the database
    $sql = "INSERT INTO customer (customer_name, customer_address, customer_city, customer_email) VALUES ('$customer_name', '$customer_address', '$customer_city', '$customer_email')";
    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Customer data inserted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 500px;
            margin: 0 auto;
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        button[type="submit"] {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Customer</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="form-group">
                <label for="customer_address">Customer Address:</label>
                <input type="text" class="form-control" id="customer_address" name="customer_address" required>
            </div>
            <div class="form-group">
                <label for="customer_city">Customer City:</label>
                <input type="text" class="form-control" id="customer_city" name="customer_city" required>
            </div>
            <div class="form-group">
                <label for="customer_email">Customer Email:</label>
                <input type="email" class="form-control" id="customer_email" name="customer_email" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
