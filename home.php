<?php 

require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}

// Set the default timezone to IST
date_default_timezone_set('Asia/Kolkata');

// Get the current date and time in IST
$currentDateTime = date("l, F j, Y", time());
$currentTime = date("h:i:s A", time());

function getTotalSales()
{
    global $con;
    $currentYear = date("Y");
    // Calculate fiscal year start date
    if (date("m") < 4) {
        $fiscalYearStart = ($currentYear - 1) . "-04-01";
    } else {
        $fiscalYearStart = $currentYear . "-04-01";
    }
    // Calculate fiscal year end date
    if (date("m") < 4) {
        $fiscalYearEnd = $currentYear . "-03-31";
    } else {
        $fiscalYearEnd = ($currentYear + 1) . "-03-31";
    }
    $sql = "SELECT SUM(i.GRAND_TOTAL) AS total_sales FROM registered_users ru JOIN invoicee i ON ru.comemail = '" . $_SESSION['comemail'] . "' WHERE i.comname = '" . $_SESSION['comname'] . "' AND ru.comemail = '" . $_SESSION['comemail'] . "' AND i.invoice_date >= '" . $fiscalYearStart . "' AND i.invoice_date <= '" . $fiscalYearEnd . "'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_sales'];
}


function getTotalQuotation()
{
    global $con;
    $currentYear = date("Y");
    // Calculate fiscal year start date
    if (date("m") < 4) {
        $fiscalYearStart = ($currentYear - 1) . "-04-01";
    } else {
        $fiscalYearStart = $currentYear . "-04-01";
    }
    // Calculate fiscal year end date
    if (date("m") < 4) {
        $fiscalYearEnd = $currentYear . "-03-31";
    } else {
        $fiscalYearEnd = ($currentYear + 1) . "-03-31";
    }
    $sql = "SELECT COUNT(i.comname) AS total_count FROM registered_users ru JOIN quotation i ON ru.comemail = '" . $_SESSION['comemail'] . "' WHERE i.comname = '" . $_SESSION['comname'] . "' AND ru.comemail = '" . $_SESSION['comemail'] . "' AND i.invoice_date >= '" . $fiscalYearStart . "' AND i.invoice_date <= '" . $fiscalYearEnd . "'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_count'];
}


function getTotalPurchaseOrder()
{
    global $con;
    $currentYear = date("Y");
    // Calculate fiscal year start date
    if (date("m") < 4) {
        $fiscalYearStart = ($currentYear - 1) . "-04-01";
    } else {
        $fiscalYearStart = $currentYear . "-04-01";
    }
    // Calculate fiscal year end date
    if (date("m") < 4) {
        $fiscalYearEnd = $currentYear . "-03-31";
    } else {
        $fiscalYearEnd = ($currentYear + 1) . "-03-31";
    }
    $sql = "SELECT COUNT(i.comname) AS total_count FROM registered_users ru JOIN purchase i ON ru.comemail = '" . $_SESSION['comemail'] . "' WHERE i.comname = '" . $_SESSION['comname'] . "' AND ru.comemail = '" . $_SESSION['comemail'] . "' AND i.invoice_date >= '" . $fiscalYearStart . "' AND i.invoice_date <= '" . $fiscalYearEnd . "'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_count'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home | BillingBizz</title>
<link rel="stylesheet" href="css/slider.css">
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/news.css">
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<link rel="icon" type="image/png" sizes="32x32" href="Images/favicon-32x32.png">
<!-- <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"> -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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
    <a href="help-new.php" class="nav__link">
    <i class="material-icons nav__icon">help</i>
    <span class="nav__text">Help</span>
    </a>
    <a href="logout.php" class="nav__link">
    <i class="material-icons nav__icon">logout</i>
    <span class="nav__text">Logout</span>
    </a>
    </nav>


    <div class="slider-container">
    <div class="slide">
    <img src="Images/1.png" alt="Image 1">
    </div>
    <!--<div class="slide">-->
    <!--<img src="Images/icon.png" alt="Image 2">-->
    <!--</div>-->
    <div class="slide">
    <img src="Images/2.png" alt="Image 3">
    </div>
    </div>
 
    <div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <!-- Card 1 Content -->
            <h3>Total Sales</h3>
            <h5>Last 1 year Sales </h5>
            <p><?php echo "₹" ."" .getTotalSales(); ?></p>
        </div>
        <div class="swiper-slide">
            <!-- Card 2 Content -->
            <h3>Total Quotation</h3>
            <h5>Last 1 year Quotation </h5>
            <p><?php echo getTotalQuotation(); ?></p>
        </div>
        <div class="swiper-slide">
            <!-- Card 2 Content -->
            <h3>Total Purchase Order</h3>
            <h5>Last 1 year Purchase </h5>
            <p><?php echo getTotalPurchaseOrder(); ?></p>
        </div>
        <!-- Add more swiper-slide for additional cards -->
    </div>
    <!-- Pagination dots -->
    <div class="swiper-pagination"></div>
    </div>

    



    <div class="button-container">
    <div class="button" > 
    <a href="index.php">
    <div class="icon">  <img src = "Images/invoice-icon.png" class="image" ></div>
    </a>
    <div class="label">GST Invoice</div>
    </div>
    <div class="button">
    <a href="delivery.php">
    <div class="icon">  <img src = "Images/challan-icon.png" class="image" ></div>
    </a>
    <div class="label">Delivery Challan</div>
    </div>
    <div class="button">
    <a href="quotation.php">
    <div class="icon">  <img src = "Images/challan-icon.png" class="image" ></div>
    </a>
    <div class="label">Quotation</div>
    </div>
    <div class="button">
    <a href="purchaseorder.php">
    <div class="icon">  <img src = "Images/challan-icon.png" class="image" ></div>
    </a>
    <div class="label">Purchase Order</div>
    </div>
    <div class="button">
    <a href="gstfilling.php">
    <div class="icon">  <img src = "Images/gst-icon.png" class="image" ></div>
    </a>
    <div class="label">GST Filling</div>
    </div>
    <div class="button">
    <a href="itrfilling.php">
    <div class="icon">  <img src = "Images/itr-icon.png" class="image" ></div>
    </a>
    <div class="label">ITR Return</div>
    </div>
    <div class="button">
    <a href="records-button.php">
    <div class="icon">  <img src = "Images/challan-icon.png" class="image" ></div>
    </a>
    <div class="label">Records</div>
    </div>
    
    
    <div class="button">
    <a href="Payments.php">
    <div class="icon"><img src = "Images/payment-icon.png" class="image" ></div>
    </a>
    <div class="label">Payments</div>
    </div>
   </div>
   
  <div class="news-items-container">
  <h3> Latest News </h3>
    <?php
      require "config.php";


      $sql = "SELECT id, title, summary, full_content, image_data FROM news";
      $result = $con->query($sql);
      
    
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $imageData = base64_encode($row['image_data']);
          $imageSrc = "data:image/jpeg;base64," . $imageData;
          echo "<div class='news-item'>";
          echo "<h4>" . $row['title'] . "</h4>";
          echo "<img src='$imageSrc' alt='images' />";
          echo "<p class='content'>" . $row['summary'] . "<span id='dots'>...</span>" . "<span class='more'>" . $row['full_content'] . "</span></span></p>";
          echo "<button class='read-more'>Read more</button>";
          
          echo "</div>";
          
        }
      } else {
          echo "No News as of now.";
      }
      $con->close();
    ?>
  </div>
 </div>

<script src="script/script.js"></script>
<script src="script/news-script.js"></script>

<script src="script/swipe.js"></script>
</body>
</html>