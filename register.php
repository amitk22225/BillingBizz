<?php 

require "config.php";
?>

 <html>
 <head>
 <title>Register</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1696A3;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: 100%; */
            width: 100%;
            margin: 0;
        }
        .login-container {
            background-color: #1696A3;
            /* border-radius: 20px; */
            padding: 40px;
            width: 100%;
            /* max-width: 400px; */
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
            text-align: center;
            /* height: 100%;  */
        }
        .login-container h1 {
            color: white; /* Change the color to white */
        }
        .login-container h2 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #08d9d6;
        }
        .login-container p {
            margin-bottom: 40px;
            color: #808080;
        }
        .input-field {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 25px;
            border: 1px solid #08d9d6;
            background-color: transparent;
            color: white;
            font-size: 16px;
        }
        .login-button {
            background-color: #08d9d6;
            color: #252a41;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }
        .login-button:hover {
            background-color: #06bfb4;
            color: white;
        }
        .signup-text {
            margin-top: 20px;
        }
        .signup-text a {
            color: #08d9d6;
            text-decoration: none;
        }
        .error_message {
            color: #b12d2d;
            background: #ffb5b5;
            border: #c76969 1px solid;
            margin-top: 15px;
            padding: 10px 30px;
            border-radius: 4px;
        }
        ::placeholder {
            color: #bbb;
        }
        .input-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            color: white;
        }

        .input-container label {
            margin-bottom: 5px;
        }

        .input-field {
            display: flex;
            align-items: center;
        }

        .input-field i {
            margin-right: 10px;
        }

</style>

<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" >
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>
</head>


<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Your CSS styles */
    </style>
</head>

<body>
    <div class="login-container">
        <form name="details" method="post" enctype="multipart/form-data">
            <h1 style="color: white;">Register your Business with us</h1> <!-- Change color inline -->
            <p style="color: #000;">Please fill in this form to create an account.</p>
            <hr>

            <?php
            if (isset($_POST["button"])) {

                $target_path  =  "uploads/";
                $target_path  =  $target_path  .  basename($_FILES['imageUpload']['name']);
                $target_path1  =  "uploads/";
                $target_path1  =  $target_path1  .  basename($_FILES['signUpload']['name']);

                $comname = mysqli_real_escape_string($con, $_POST["comname"]);
                $comaddress = mysqli_real_escape_string($con, $_POST["comaddress"]);
                $email = mysqli_real_escape_string($con, $_POST["email"]);
                $GSTIN = mysqli_real_escape_string($con, $_POST["GSTIN"]);
                $cphone = mysqli_real_escape_string($con, $_POST["cphone"]);
                $TermsConditions = mysqli_real_escape_string($con, $_POST["TermsConditions"]);
                $TermsConditions1 = mysqli_real_escape_string($con, $_POST["TermsConditions1"]);
                $TermsConditions2 = mysqli_real_escape_string($con, $_POST["TermsConditions2"]);
                $TermsConditions3 = mysqli_real_escape_string($con, $_POST["TermsConditions3"]);
                $TermsConditions4 = mysqli_real_escape_string($con, $_POST["TermsConditions4"]);
                $date = date('Y-m-d H:i:s', time());

                // Check if email already exists in the database
                $check_query = "SELECT * FROM registered_users WHERE comemail = '$email'";
                $check_result = mysqli_query($con, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    echo "<div class='error_message'>Email already exists. Please use a different email.</div>";
                } else {

                    // Proceed with user registration
                    if (move_uploaded_file($_FILES['signUpload']['tmp_name'], $target_path1)) {
                        // echo "The file " . basename($_FILES['signUpload']['name']) . " has been uploaded";
                    } else {
                        echo "There was an error uploading the file, please try again!";
                    }

                    if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $target_path)) {

                        // echo "The file " . basename($_FILES['imageUpload']['name']) . " has been uploaded";
                        $_SESSION['Image'] = $target_path;
                    } else {
                        echo "There was an error uploading the file, please try again!";
                    }

                    $sql = "INSERT INTO `registered_users` (`comname`,`GSTIN`,`comemail`,`cphone`,`comaddress`,`Image`,`signc`,`date`,`TermsConditions`, `TermsConditions1`,`TermsConditions2`,`TermsConditions3`,`TermsConditions4`) VALUES ('$comname','$GSTIN','$email','$cphone','$comaddress','$target_path','$target_path1','$date','$TermsConditions', '$TermsConditions1','$TermsConditions2','$TermsConditions3','$TermsConditions4')";
                    if ($con->query($sql)) {
                        $sid = $con->insert_id;
                        echo "<script>
                        window.onload = function() {
                            Swal.fire({
                                title: 'Data Inserted',
                                text: 'Your data has been successfully inserted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href = '".$_SERVER['PHP_SELF']."'; // Redirect to the same page
                            });
                        };
                     </script>";
    } else {
                        echo "<script>
                        window.onload = function() {
                        Swal.fire({
                        title: 'Something went wrong!',
                        text: 'Please try again later or raise a complaint if error persists.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  };
                      </script>";
    }
  }
}
    ?>

            <div class="input-container">
                <!-- <i class="fas fa-building"></i> -->
                <input type="text" placeholder="Company Name" name="comname" class="input-field" required>
            </div>
            <div class="input-container">
                <!-- <i class="fas fa-id-badge"></i> -->
                <input type="text" placeholder="GSTIN" name="GSTIN" class="input-field">
            </div>
            <div class="input-container">
                <!-- <i class="fas fa-envelope"></i> -->
                <input type="text" placeholder="Email" name="email" class="input-field" required>
            </div>
            <div class="input-container">
                <!-- <i class="fas fa-map-marker-alt"></i> -->
                <input type="text" placeholder="Company Address" name="comaddress" class="input-field" required>
            </div>
            <div class="input-container">
                <!-- <i class="fas fa-phone-alt"></i> -->
                <input type="text" placeholder="Contact Number" name="cphone" class="input-field" required>
            </div>
            <input type="text" placeholder="Terms & Conditions" name="TermsConditions" class="input-field">
            <input type="text" placeholder="Terms & Conditions" name="TermsConditions1" class="input-field">
            <input type="text" placeholder="Terms & Conditions" name="TermsConditions2" class="input-field">
            <input type="text" placeholder="Terms & Conditions" name="TermsConditions3" class="input-field">
            <input type="text" placeholder="Terms & Conditions" name="TermsConditions4" class="input-field">
            
            
            
            <!-- Additional Terms & Conditions input fields go here -->
            <div class="input-container">
                <label for="imageUpload">Upload Company Logo (Image)</label>
            <div class="input-field">
                <i class="fas fa-image"></i>
            <input type="file" id="imageUpload" name="imageUpload" accept="image/*" required>
            </div>
            </div>
            <div class="input-container">
                <label for="signUpload">Upload Authorized Signature (Image)</label>
            <div class="input-field">
                <i class="fas fa-signature"></i>
            <input type="file" id="signUpload" name="signUpload" accept=".jpg, .jpeg, .png, .gif" required>
             </div>
             </div>
            <button type="submit" name="button" class="login-button">Register</button>
        </form>
        <div class="signup-text">
            <p style="color: #000;">Already have an account? <a href="login.php">Sign in</a>.</p>
        </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>