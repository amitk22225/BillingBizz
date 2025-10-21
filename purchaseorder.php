<?php 

require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}

$query = "select * from registered_users where ID ='" .$_SESSION['ID']. "'";
$result = mysqli_query($con,$query);

if ($result) {
  $row = $result->fetch_assoc();
  $dateFromDatabase = $row['date'];
  $Expiryy = $row['Expirydatee'];
  $payment_status = $row['payment_status'];

  // Compare the date
  $currentDate = new DateTime();
  $databaseDate = new DateTime($dateFromDatabase);
  $difference = $currentDate->diff($databaseDate);
  
  $databaseexpiry = new DateTime($Expiryy);

  // Check if the difference is more than 14 days
  $daysDifference = $difference->days;
  
  if  (($databaseexpiry < $currentDate) and ($daysDifference > 14)) {
       echo 'The current date is more than 14 days or subscription validity end from the date in the database.';
    //   print_r ($currentDate);
      header('location: subsciptions.php');
    } else if($payment_status == 'paid' and $daysDifference < 14 and $databaseexpiry > $currentDate) {
      // echo 'The current date is within 14 days from the date in the database.';
      // header('location: dashboard.php');
      // header('location: subsciptions.php');
     
        
        $query = "SELECT Expirydate FROM payments WHERE comemail ='" .$_SESSION['comemail']. "'";
        $result = mysqli_query($con,$query);

        if ($result) {
         $row = $result->fetch_assoc();
         $dateFromDatabase = $row['Expirydate'];

         // Check if the date has passed
         $currentDate = new DateTime();
         $databaseDate = new DateTime($dateFromDatabase);


        // if ($currentDate > $databaseDate) {
        // // Update the date to NULL
        // $update = " UPDATE registered_users SET payment_status = 0 WHERE comemail = '" .$_SESSION['comemail']. "'";
        // $updateresult = mysqli_query($con,$update);
        // $updateQuery = "DELETE FROM payments WHERE comemail = '" .$_SESSION['comemail']. "'";
        // $updateResult = mysqli_query($con,$updateQuery);

        if ($result) {
            echo 'Date has passed. Deleted record';
            header('location: subsciptions.php');
        } else {
            echo 'Error updating date: ' . $mysqli->error;
        }
    } else {
        // if date not passed
    }
} else {
   // echo 'Error retrieving date from the database: ' . $mysqli->error;
}}


// } else {
//   echo 'Error retrieving date from the database: ' . $mysqli->error;
// }


?>
<html>
  <head>
    <title>Purchase Order</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/asset.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
      
      
    <style>
    
    .rowScroll{
      overflow-x:auto; 
      width:auto;

    }
    </style>
    <div class='container'>
      <div class="gst">
      <a href="home.php" >
      <i class="material-icons nav__icon">arrow_back</i>
      </a>
      <div class = "sentence"> <p> Purchase Order </p></div>
    </div>
      <?php
        if(isset($_POST["submit"])){
          $invoice_no=$_POST["invoice_no"];
          $invoice_date=date("Y-m-d",strtotime($_POST["invoice_date"]));
          $placesupply=mysqli_real_escape_string($con,$_POST["placesupply"]);
          $cname=mysqli_real_escape_string($con,$_POST["cname"]);
          $caddress=mysqli_real_escape_string($con,$_POST["caddress"]);
          $ccity=mysqli_real_escape_string($con,$_POST["ccity"]);
          $customeremail=mysqli_real_escape_string($con,$_POST["customeremail"]);
          $start_date=mysqli_real_escape_string($con,$_POST["start_date"]);
          $end_date=mysqli_real_escape_string($con,$_POST["end_date"]);
          $qref=mysqli_real_escape_string($con,$_POST["qref"]);
          $cperson=mysqli_real_escape_string($con,$_POST["cperson"]);
          $tandc=mysqli_real_escape_string($con,$_POST["tandc"]);
          $grand_total=mysqli_real_escape_string($con,$_POST["grand_total"]);
          
          $sql="insert into purchase (INVOICE_NO,INVOICE_DATE,PLACESUPPLY,CNAME,CADDRESS,CCITY,start_date,end_date,qref,cperson,GRAND_TOTAL,comname,customeremail,tandc) values ('{$invoice_no}','{$invoice_date}','{$placesupply}','{$cname}','{$caddress}','{$ccity}','{$start_date}','{$end_date}','{$qref}','{$cperson}','{$grand_total}','{$_SESSION['comname']}','{$customeremail}','{$tandc}') ";
          if($con->query($sql)){
            $sid=$con->insert_id;
            
            $sql2="insert into purchase_products (SID,PNAME,hsn,unit,PRICE,QTY,sgst,cgst,TOTAL) values ";
            $rows=[];
            for($i=0;$i<count($_POST["pname"]);$i++)
            {
              $pname=mysqli_real_escape_string($con,$_POST["pname"][$i]);
              $price=mysqli_real_escape_string($con,$_POST["price"][$i]);
              $qty=mysqli_real_escape_string($con,$_POST["qty"][$i]);
              $total=mysqli_real_escape_string($con,$_POST["total"][$i]);
              $hsn=mysqli_real_escape_string($con,$_POST["hsn"][$i]);
              $unit=mysqli_real_escape_string($con,$_POST["unit"][$i]);
              $sgst=mysqli_real_escape_string($con,$_POST["sgst"][$i]);
              $cgst=mysqli_real_escape_string($con,$_POST["cgst"][$i]);
              $rows[]="('{$sid}','{$pname}','{$hsn}','{$unit}','{$price}','{$qty}','{$sgst}','{$cgst}','{$total}')";
            }
            $sql2.=implode(",",$rows);
            if($con->query($sql2)){
              
                echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Data Inserted',
                        text: 'Purchase Order created Successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = '".$_SERVER['PHP_SELF']."'; // Redirect to the same page
                    });
                };
             </script>";


            }else{
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
          }else{
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
      <form method='post' action="" autocomplete='off' >
        <div class='row'>
          <div class='col-md-4'>
            <h5 class='text-success'>Order Details</h5>
            <div class='form-group'>
              <label>Order No.</label>
              <input type='text' name='invoice_no' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Order Date</label>
              <input type='text' name='invoice_date' id='date' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Place of Supply</label>
              <input type='text' name='placesupply' id='placesupply' required class='form-control'>
            </div>
      </div>
          <div class='col-md-4'>
            <h5 class='text-success'>Vendor Details</h5>
            <div class='form-group'>
              <label>Name</label>
              <input type='text' name='cname' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Address</label>
              <input type='text' name='caddress' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>City</label>
              <input type='text' name='ccity' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Vendor Email</label>
              <input type='text' name='customeremail' required class='form-control'>
            </div>
          </div>
      
            <div class='col-md-4'>
            <h5 class='text-success'>Work Specific Details</h5>
            <div class='form-group'>
              <label>Order Validity Start Date </label>
              <input type='text' name='start_date' id='start_date' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Order Validity End Date</label>
              <input type='text' name='end_date' id='end_date' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Quotation Ref. No</label>
              <input type='text' name='qref' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Contact Person</label>
              <input type='text' name='cperson' required class='form-control'>
            </div>
          </div>

    <div class='col-md-12'>
    <h5 class='text-success'>Item Details</h5>
    <div id="product_container">
    <div class="product_row">
 
            <div class="form-group">
                <label>Product</label>
                <textarea class="form-control pname" required name='pname[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <label>HSN</label>
                <textarea class="form-control hsn" required name='hsn[]' rows='2' cols='40'></textarea>
            </div>
 
            <div class="form-group">
                <label>Qty</label>
                <textarea class="form-control qty" required name='qty[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <textarea class="form-control unit" required name='unit[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <label>Rate</label>
                <textarea class="form-control price" required name='price[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <label>SGST(%)</label>
                <textarea class="form-control sgst" required name='sgst[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <label>CGST(%)</label>
                <textarea class="form-control cgst" required name='cgst[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <textarea class="form-control total" required name='total[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'>
            </div>
        </div>
    </div>
    <input type='button' value='+ Add Item' class='btn btn-primary btn-sm' id='btn-add-row'>
    <div class="form-group">
    <label>Grand Total</label>
    <input type='text' name='grand_total' id='grand_total' class='form-control' readonly>
    </div>
    <div class="form-group">
    <label>Terms & Conditions</label>
    <textarea class="form-control tandc" required name='tandc' rows='2' cols='40'></textarea>
    </div>
    <input type='submit' name='submit' value='Create Order' class='btn btn-success float-right'>
    </div>
      </form>
    </div>
    <script>
      $(document).ready(function(){
        $("#date").datepicker({
          dateFormat:"dd-mm-yy"
        });
    
        $(document).ready(function(){
        $("#end_date").datepicker({
          dateFormat:"dd-mm-yy"
        });

        $(document).ready(function(){
        $("#start_date").datepicker({
          dateFormat:"dd-mm-yy"
        });
        
       
    // Function to add a new product row
         $("#btn-add-row").click(function(){
        var row = "<div class='product_row'>" +
                    "<div class='form-group'>" +
                        "<label>Product</label>" +
                        "<textarea class='form-control pname' required name='pname[]' rows='2' cols='40'></textarea>" +
                    "</div>" +
                    "<div class='form-group'>" +
                        "<label>HSN</label>" +
                        "<textarea class='form-control hsn' required name='hsn[]' rows='2' cols='40'></textarea>" +
                    "</div>" +
                    "<div class='form-group'>" +
                        "<label>Qty</label>" +
                        "<textarea class='form-control qty' required name='qty[]' rows='2' cols='40'></textarea>" +
                    "</div>" +
                    "<div class='form-group'>" +
                        "<label>Unit</label>" +
                        "<textarea class='form-control unit' required name='unit[]' rows='2' cols='40'></textarea>" +
                    "</div>" +
                    "<div class='form-group'>" +
                        "<label>Rate</label>" +
                        "<textarea class='form-control price' required name='price[]' rows='2' cols='40'></textarea>" +
                    "</div>" +
                    "<div class='form-group'>" +
                        "<label>SGST(%)</label>" +
                        "<textarea class='form-control sgst' required name='sgst[]' rows='2' cols='40'></textarea>" +
                    "</div>" +
                    "<div class='form-group'>" +
                        "<label>CGST(%)</label>" +
                        "<textarea class='form-control cgst' required name='cgst[]' rows='2' cols='40'></textarea>" +
                    "</div>" +
                    "<div class='form-group'>" +
                        "<label>Amount</label>" +
                        "<textarea class='form-control total' required name='total[]' rows='2' cols='40'></textarea>" +
                    "</div>" +
                    "<div class='form-group'>" +
                        "<input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'>" +
                    "</div>" +
                "</div>";
        $("#product_container").append(row);
    });

    $("body").on("click",".btn-row-remove",function(){
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, remove the row
                    $(this).closest(".product_row").remove();
                    calculateGrandTotal();
                    // Show success message
                    Swal.fire(
                        'Deleted!',
                        'Your row has been deleted.',
                        'success'
                    )
                }
            }); 
        });
    
        function calculateGrandTotal(){
        var total = 0;
        $(".total").each(function(){
            total += parseFloat($(this).val());
        });
        $("#grand_total").val(total);
    }

    $("body").on("keyup",".price, .qty, .sgst, .cgst",function(){
        var price = parseFloat($(this).closest(".product_row").find(".price").val());
        var qty = parseFloat($(this).closest(".product_row").find(".qty").val());
        var sgst = parseFloat($(this).closest(".product_row").find(".sgst").val());
        var cgst = parseFloat($(this).closest(".product_row").find(".cgst").val());
        var total = (price * qty) + ((price * qty * sgst) / 100) + ((price * qty * cgst) / 100);
        $(this).closest(".product_row").find(".total").val(total);
        calculateGrandTotal();
    });

            });
        });
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>