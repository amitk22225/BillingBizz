<?php 

require "config.php";
require ("fpdf/fpdf.php");
?>

 <html>
 <head>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <style>
 body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: rgb(255, 255, 255);
 }

 * {
  box-sizing: border-box;
 }

/* Add padding to containers */
 .container {
  padding: 16px;
  background-color: white;
 }

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #ffffff;
  text-align: center;
}
</style>

<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" >
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>
</head>

<form name= "details" action="sun.php"  method="post" enctype="multipart/form-data">
  <div class="container">
    <h1>Please Enter Terms & Conditions of the Invoice</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <?php
    if(isset($_POST["button"])){

    $TermsConditions=mysqli_real_escape_string($con,$_POST["TermsConditions"]);
    $TermsConditions1=mysqli_real_escape_string($con,$_POST["TermsConditions1"]);
    $TermsConditions2=mysqli_real_escape_string($con,$_POST["TermsConditions2"]);
    $TermsConditions3=mysqli_real_escape_string($con,$_POST["TermsConditions3"]);
    $TermsConditions4=mysqli_real_escape_string($con,$_POST["TermsConditions4"]);


    $sql="INSERT INTO `registered_users` (`TermsConditions`, `TermsConditions1`,`TermsConditions2`,`TermsConditions3`,`TermsConditions4` ) VALUES ('$TermsConditions', '$TermsConditions1','$TermsConditions2','$TermsConditions3','$TermsConditions4')";

    if($con->query($sql)){
      $sid=$con->insert_id;
    }
    // header('Location: sun.php');
    // exit;
  }
    ?>

    <label for="Terms & Conditions"><b>Terms & Conditions of Invoice</b></label>
    <input type="text" placeholder="Terms & Conditions" name="TermsConditions" id="TermsConditions" value= "" >
    <input type="text" placeholder="Terms & Conditions" name="TermsConditions1" id="TermsConditions1" value= "" >
    <input type="text" placeholder="Terms & Conditions" name="TermsConditions2" id="TermsConditions2" value= "" >
    <input type="text" placeholder="Terms & Conditions" name="TermsConditions3" id="TermsConditions3" value= "" >
    <input type="text" placeholder="Terms & Conditions" name="TermsConditions4" id="TermsConditions4" value= "" >

 
    <hr>
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
    
    <input type="submit" id="button" name="button" value="Register" class="registerbtn">
    <!-- <button type="button" id="button" value = "Register" onclick="showMessage()" class="registerbtn"> -->
  </div>

  
  
  <div class="container signin">
    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
  </div>
</form>
<!-- <script src="jquery-2.1.4.js"></script>
<script> -->



<!-- </script> -->
</body>
</html>