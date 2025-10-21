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