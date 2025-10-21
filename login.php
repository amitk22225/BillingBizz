<?php
include "config.php";
include "mail_function.php";
session_start();
$success = "";
$error_message = "";
if(!empty($_POST["submit_email"])) {
    
    $result = mysqli_query($con,"SELECT * FROM registered_users WHERE comemail='" . $_POST["comemail"] . "'");
    $count  = mysqli_num_rows($result);
    
    
    if($count>0) {
        // generate OTP
        $otp = rand(100000,999999);
        // Send OTP

        $mail_status = sendOTP($_POST["comemail"],$otp);
        
        $row = mysqli_fetch_array($result);
        $id = $row['ID'];
        $COMNAME = $row['comname'];
        $COMEMAIL = $row['comemail'];
        $CPHONE = $row['cphone'];
        $Image = $row['Image'];
        $COMADDRESS = $row['comaddress'];
        $GSTIN = $row['GSTIN'];
        $SIGNC = $row['signc'];
        $_SESSION['ID'] = $id;
        $_SESSION['comname'] = $COMNAME;
        $_SESSION['comemail'] = $COMEMAIL;
        $_SESSION['cphone'] = $CPHONE;
        $_SESSION['Image'] = $Image;
        $_SESSION['comaddress'] = $COMADDRESS;
        $_SESSION['GSTIN'] = $GSTIN;
        $_SESSION['signc'] = $SIGNC;
        
        if($mail_status == 1) {
        $result = mysqli_query($con,"INSERT INTO otp_expiryy (otp,is_expired,create_at) VALUES ('" . $otp . "', 0, '" . date("Y-m-d H:i:s"). "')");
            $current_id = mysqli_insert_id($con);
            
            if(!empty($current_id)) {
                $success=1;
            }
        }
    } else {
        $error_message = "Email not exists!";
    }
       

    
}
if(!empty($_POST["submit_otp"])) {
    $result = mysqli_query($con,"SELECT * FROM otp_expiryy WHERE otp='" . $_POST["otp"] . "' AND is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 5 MINUTE)");
    $count  = mysqli_num_rows($result);

    if(!empty($count)) {
        $result = mysqli_query($con,"UPDATE otp_expiryy SET is_expired = 1 WHERE otp = '" . $_POST["otp"] . "'");
        
        $success = 2;
    
    } else {
        $success =1;
        $error_message = "Invalid OTP!";
    }   
}

// if($_POST["register"]){
//     header('Location: register.php');
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1696A3;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
            text-align: center; /* Center align the text */
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
    </style>
</head>
<body>
    <div class="login-container">
        <?php if(!empty($error_message)) { ?>
            <div class="error_message"><?php echo $error_message; ?></div>
        <?php } ?>
        <form name="frmUser" method="post" action="">
            <?php if(!empty($success == 1)) { ?>
                <h2 style="color: #fff;">Enter OTP</h2>
                <input type="text" name="otp" placeholder="One Time Password" class="input-field" required>
                <input type="submit" name="submit_otp" value="Submit" class="login-button">
            <?php } else if ($success == 2) { 
                $_SESSION['login'] = true;
                header('Location: home.php');
            } else { ?>
                <h2 style="color: #fff;">Login</h2>
                <p  style="color: #000;">Please Sign in to continue </p>
                <input type="text" name="comemail" placeholder="Email" class="input-field" required>
                <input type="submit" name="submit_email" value="Submit" class="login-button">
            <?php } ?>
        </form>
        <div class="signup-text">
            <p  style="color: #000;">Don't have an account? <a href="register.php">Sign up</a></p>
        </div>
    </div>
</body>
</html>

