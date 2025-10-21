<?php 

require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}

?>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Help</title>
<link rel="stylesheet" href="css/slider.css">
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/news.css">
<link rel="icon" type="image/png" sizes="32x32" href="Images/favicon-32x32.png">
<!-- <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"> -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<style>
form {
  font-family: 'Arial', sans-serif;
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  max-width: 80%; /* Adjust the maximum width as needed */
  width: 100%;
  margin: auto;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
}

input, textarea {
  width: 100%;
  padding: 8px;
  margin-bottom: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type="submit"] {
  background-color: #4caf50;
  color: #fff;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

@media screen and (min-width: 768px) {
  form {
    max-width: 400px;
  }
}
</style>
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

  <form id="attachmentForm" method="post" action="send_mail.php">
    <label for="additionalData"><b>Message:</b></label>
    <textarea name="additionalData" id="additionalData" rows="4" cols="52" required></textarea>
  
    <label for="fileToUpload"><b>Attach Documents:</b></label>
    <input type="file" name="fileToUpload" id="fileToUpload" cols="50" required>
    
    <input type="submit" value="Submit">
  </form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("attachmentForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        Swal.fire({
            title: 'Message Sent!',
            text: 'Message sent successfully. Your query will be resolved within the next 24 hours.',
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'small-swal'
            }
        }).then((result) => {
            // Redirect to the same page
            window.location.href = window.location.href;
        });
    });
</script>
<script src="upload.js"></script>
</body>
</html>
