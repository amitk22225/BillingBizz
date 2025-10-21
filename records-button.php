<?php 

require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home | Invoice Maker</title>
<link rel="stylesheet" href="css/slider.css">
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/news.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>

<div class="app-container">

    <header class="app-header">
        <div class="profile-section">
            <img src= <?php echo $_SESSION['Image'] ?> alt="Profile Picture" class="profile-pic">
            <div class="user-info">
                <p>Hi, <?php echo $_SESSION['comname'] ?></p>
                <p><?php echo $_SESSION['cphone'] ?></p>
            </div>
        </div>
    </header>
    
    
    <nav class="nav">
    <a href="home.php" class="nav__link">
    <i class="material-icons nav__icon">home</i>
    <span class="nav__text">Home</span>
    </a>
    <a href="records-button.php" class="nav__link">
    <i class="material-icons nav__icon">description</i>
    <span class="nav__text">Records</span>
    </a>
    <!--<a href="#" class="nav__link">-->
    <!--<i class="material-icons nav__icon">devices</i>-->
    <!--<span class="nav__text">Devices</span>-->
    <!--</a>-->
    <a href="profile.php" class="nav__link">
    <i class="material-icons nav__icon">person</i>
    <span class="nav__text">Profile</span>
    </a>
    <a href="help.php" class="nav__link">
    <i class="material-icons nav__icon">help</i>
    <span class="nav__text">Help</span>
    </a>
    <a href="logout.php" class="nav__link">
    <i class="material-icons nav__icon">logout</i>
    <span class="nav__text">Logout</span>
    </a>
    </nav>

 
    <div class="button-container">
    <div class="button" > 
    <a href="records-new.php">
    <div class="icon">  <img src = "Images/invoice-icon.png" class="image" ></div>
    </a>
    <div class="label">Invoice Records</div>
    </div>
    <div class="button">
    <a href="records-delivery.php">
    <div class="icon">  <img src = "Images/gst-icon.png" class="image" ></div>
    </a>
    <div class="label">Delivery Challan Records</div>
    </div>
    <div class="button">
    <a href="records-quotation.php">
    <div class="icon">  <img src = "Images/gst-icon.png" class="image" ></div>
    </a>
    <div class="label">Quotation Records</div>
    </div>
    <div class="button">
    <a href="records-purchase.php">
    <div class="icon">  <img src = "Images/gst-icon.png" class="image" ></div>
    </a>
    <div class="label">Purchase Order Records</div>
    </div>
   </div>
 </div>

<!--<script src="script/script.js"></script>-->
<!--<script src="script/news-script.js"></script>-->
</body>
</html>