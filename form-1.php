<?php
    if(isset($_POST["button"])){

      
      $target_path  =  "uploads/";
      $target_path  =  $target_path  .  basename($_FILES['imageUpload']['name']);
      $target_path1  =  "uploads/";
      $target_path1  =  $target_path1  .  basename($_FILES['signUpload']['name']);

    $comname=mysqli_real_escape_string($con,$_POST["comname"]);
    $comaddress=mysqli_real_escape_string($con,$_POST["comaddress"]);
    $email=mysqli_real_escape_string($con,$_POST["email"]);
    $GSTIN=mysqli_real_escape_string($con,$_POST["GSTIN"]);
    $cphone=mysqli_real_escape_string($con,$_POST["cphone"]);

    if (move_uploaded_file($_FILES['signUpload']['tmp_name'], $target_path1)) {
    $signc=mysqli_real_escape_string($con,$_POST["signc"]);
    echo "The file " . basename($_FILES['signUpload']['name']) . " has been uploaded";
      } 
      else {
      echo "There was an error uploading the file, please try again!";
      } 

    if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $target_path)) {
    $Image=mysqli_real_escape_string($con,$_POST["Image"]);
    $date = date('Y-m-d H:i:s', time());
    $sql="INSERT INTO `registered_users` (`comname`,`GSTIN`,`comemail`,`cphone`,`comaddress`,`Image`,`signc`,`date`) VALUES ('$comname','$GSTIN','$email','$cphone','$comaddress','$target_path','$target_path1','$date')";
    echo "The file " . basename($_FILES['imageUpload']['name']) . " has been uploaded";
     $_SESSION['Image'] =$target_path;
      } 
      else {
      echo "There was an error uploading the file, please try again!";
      } 

    if($con->query($sql)){
      $sid=$con->insert_id;
    }
    echo '<script>nextForm("form-part-1", "form-part-2");</script>';
    // header('Location: termsandconditions.php');
    // exit ();
  }
  
    ?>