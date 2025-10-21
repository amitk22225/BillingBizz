<?php 
session_start();
require "config.php";
require ("fpdf/fpdf.php");

if(!isset($_SESSION['login'])){
    header("location: login.php");
}

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
<link rel="stylesheet" href="css/gstfilling.css">
<link rel="stylesheet" href="css/slider.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>
</head>

<form name= "details"   method="post" enctype="multipart/form-data">
  <div class="container">
    <div class="gst">
    <a href="home.php" >
    <i class="material-icons nav__icon">arrow_back</i>
    </a>
    <div class = "sentence"> <p> ITR Filling Solutions </p></div>
    </div>
    <p>Please fill in this form for filling ITR at an afforable cost of Rs. 499  .</p>

    <?php

        $registered_users=[
            "comname"=>"",
            "comemail"=>"",
            "cphone"=>"",
            ];

            $sql_select_registered_users = "select * from registered_users where ID='" .$_SESSION['ID']. "'";
            $res1=$con->query($sql_select_registered_users);
            if($res1->num_rows>0){
                $row=$res1->fetch_assoc();
                    $registered_users=[
                      "comname"=>$row["comname"],
                      "comemail"=>$row["comemail"],
                      "cphone"=>$row["cphone"]];
                    }

                    if(isset($_POST["button"])){
                       
                        $year=mysqli_real_escape_string($con,$_POST["year"]);
                        $comname = mysqli_real_escape_string($con,$_POST["comname"]);
                        $email = mysqli_real_escape_string($con,$_POST["email"]);
                        $cphone = mysqli_real_escape_string($con,$_POST["cphone"]);
                        
                        $sql="INSERT INTO `itrfilling` (`year`,`comname`,`comemail`,`cphone`) VALUES ('$year', '$comname', '$email', '$cphone')";
                    
                        if($con->query($sql)){
                          // $sid=$con->insert_id;
                          $_SESSION['form_submitted'] = true;
                          // Display success message or perform any other action as needed
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
    ?>


    <label for="Company Name"><b>Applicant Name</b></label>
    <input type="text" name="comname" id="comname" value="<?php echo $registered_users["comname"]; ?>" readonly>

    <label for="email"><b>Email</b></label>
    <input type="text" name="email" id="email" value= "<?php echo $registered_users["comemail"]; ?>" readonly>

    <label for="Contact Number"><b>Contact Number</b></label>
    <input type="text" name="cphone" id="cphone" value= "<?php echo $registered_users["cphone"]; ?>" readonly>

    <!--<label for="Year"><b>Financial Year</b></label>-->
    <!--<input type="text" placeholder="" name="year" id="year" value= "" required>-->
    
    <!--<label for="Year"><b>Financial Year</b></label>-->
    <!--<select class="form-control js-example-tags">-->
    <!--<option selected="selected">Select Fininacial year</option>-->
    <!--<option>2022-2023</option>-->
    <!--<option>2023-2024</option>-->
    <!--</select>-->
    
    <label for="Year"><b>Financial Year: </b></label>
    <select class="form-control js-example-tags" name="year" id="year"> 
        <option value="2022-2023">2022-2023</option> 
        <option value="2023-2024">2023-2024</option> 
        <option value="2024-2025">2024-2025</option> 
    </select>
   

    
    <hr>
    <!-- <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p> -->
    
    <input type="submit" id="button" name="button" value="Submit" class="btn btn-success mb-50">
    <!-- <button type="button" id="button" value = "Register" onclick="showMessage()" class="registerbtn"> -->
  </div>

    
  
  <!-- <div class="container signin">
    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
  </div> -->
</form>
<!-- <script src="jquery-2.1.4.js"></script>
<script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- </script> -->
</body>
</html>