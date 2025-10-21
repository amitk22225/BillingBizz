<?php 
session_start();
require "config.php";

$registered_users=[
    "comname"=>"",
    "comemail"=>"",
    "cphone"=>"",
    "GSTIN"=>""];

    $sql_select_registered_users = "select * from registered_users where ID='" .$_SESSION['ID']. "'";
    $res1=$con->query($sql_select_registered_users);
    if($res1->num_rows>0){
        $row=$res1->fetch_assoc();
            $registered_users=[
              "comname"=>$row["comname"],
              "comemail"=>$row["comemail"],
              "cphone"=>$row["cphone"],
              "GSTIN"=>$row["GSTIN"]];
            }

// Check if the form has been submitted
if(isset($_POST["button"])) {
    // Process the form data and insert into the database
    $month = mysqli_real_escape_string($con, $_POST["month"]);
    $year = mysqli_real_escape_string($con, $_POST["year"]);
    $comname = mysqli_real_escape_string($con, $_POST["comname"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $cphone = mysqli_real_escape_string($con, $_POST["cphone"]);
    $GSTIN = mysqli_real_escape_string($con, $_POST["GSTIN"]);

    $sql = "INSERT INTO `gstfilling` (`month`,`year`,`comname`,`comemail`,`cphone`,`GSTIN`) VALUES ('$month','$year', '$comname', '$email', '$cphone','$GSTIN')";

    if($con->query($sql)) {
        // Set session variable to indicate form submission
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

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/gstfilling.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
    <form name="details" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="gst">
                <a href="home.php">
                    <i class="material-icons nav__icon">arrow_back</i>
                </a>
                <div class="sentence">
                    <p> GST Filling Solutions </p>
                </div>
            </div>
            <p>Please fill in this form for filling GST per month at an affordable cost @199 per month.</p>
            <!-- Your form fields here -->

    <label for="Company Name"><b>Company Name</b></label>
    <input type="text" name="comname" id="comname" value="<?php echo $registered_users["comname"]; ?>" readonly>

    <label for="GSTIN"><b>GSTIN</b></label>
    <input type="text" name="GSTIN" id="GSTIN" value ="<?php echo $registered_users["GSTIN"]; ?>" readonly>

    <label for="email"><b>Email</b></label>
    <input type="text" name="email" id="email" value= "<?php echo $registered_users["comemail"]; ?>" readonly>

    <label for="Contact Number"><b>Contact Number</b></label>
    <input type="text" name="cphone" id="cphone" value= "<?php echo $registered_users["cphone"]; ?>" readonly>

    <label for="Month"><b>Month</b></label>
    <select class="form-control js-example-tags" name="month" id="month" required> 
        <option value="January">January</option> 
        <option value="February">February</option> 
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        <option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>
    </select>


    <label for="Year"><b>Year</b></label>
    <select class="form-control js-example-tags" name="year" id="year" required>
        <option value="2024">2024</option> 
        <option value="2023">2023</option> 
        <option value="2022">2022</option> 
        <option value="2021">2021</option> 
        <option value="2020">2020</option> 
        <option value="2019">2019</option> 
        <option value="2018">2018</option> 
        <option value="2017">2017</option> 
    </select>         
    <hr>
            <input type="submit" id="button" name="button" value="Submit" class="btn btn-success mb-50">
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
