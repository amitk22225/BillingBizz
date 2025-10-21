<?php 

require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}

$query = "select * from invoicee where SID ='{$_GET["id"]}'";
$result = mysqli_query($con,$query);

if ($result) {
    // Fetch invoice details and populate the form fields
    $row = mysqli_fetch_assoc($result);
    // Populate the form fields with the fetched information
    $invoiceNo = $row['INVOICE_NO'];
    $invoiceDate = $row['INVOICE_DATE'];
    $placesupply = $row['PLACESUPPLY'];
    $caddress = $row['CADDRESS'];
    $cname = $row['CNAME'];
    $ccity = $row['CCITY'];
    $sname = $row['SNAME'];
    $saddress = $row['SADDRESS'];
    $scity = $row['SCITY'];
    $customeremail = $row['customeremail'];
    $grand_total = $row['GRAND_TOTAL'];

    // Close the result set
    mysqli_free_result($result);
}

$query_products = "select * from invoice_products where SID ='{$_GET["id"]}'";
$result_products = mysqli_query($con,$query_products);

// if ($result_products) {
//     $row = mysqli_fetch_assoc($result_products);

// }
?>
<html>
<head>
    <title>GST Invoice</title>
    
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
        <a href="home.php">
            <i class="material-icons nav__icon">arrow_back</i>
        </a>
        <div class = "sentence"> <p> GST Invoice </p></div>
    </div>
    <?php
    if(isset($_POST["submit"])){
        $invoice_no=$_POST["invoice_no"];
        $invoice_date=date("Y-m-d",strtotime($_POST["invoice_date"]));
        $placesupply=mysqli_real_escape_string($con,$_POST["placesupply"]);
        $cname=mysqli_real_escape_string($con,$_POST["cname"]);
        $caddress=mysqli_real_escape_string($con,$_POST["caddress"]);
        $ccity=mysqli_real_escape_string($con,$_POST["ccity"]);
        $scity=mysqli_real_escape_string($con,$_POST["scity"]);
        $sname=mysqli_real_escape_string($con,$_POST["sname"]);
        $customeremail=mysqli_real_escape_string($con,$_POST["customeremail"]);
        $saddress=mysqli_real_escape_string($con,$_POST["saddress"]);
        $grand_total=mysqli_real_escape_string($con,$_POST["grand_total"]);
        
        $sid = $_GET['id']; // Fetch SID from GET parameter

        // Update invoice details
        $sql="UPDATE invoicee SET 
            INVOICE_NO='{$invoice_no}',
            INVOICE_DATE='{$invoice_date}',
            PLACESUPPLY='{$placesupply}',
            CNAME='{$cname}',
            CADDRESS='{$caddress}',
            CCITY='{$ccity}',
            SNAME='{$sname}',
            SADDRESS='{$saddress}',
            SCITY='{$scity}',
            GRAND_TOTAL='{$grand_total}',
            customeremail='{$customeremail}' 
            WHERE SID = '{$sid}'";
  if ($con->query($sql)) {
    // Update invoice products
    $update_success = true;
    for ($i = 0; $i < count($_POST["pname"]); $i++) {
        $pname = mysqli_real_escape_string($con, $_POST["pname"][$i]);
        $price = mysqli_real_escape_string($con, $_POST["price"][$i]);
        $qty = mysqli_real_escape_string($con, $_POST["qty"][$i]);
        $total = mysqli_real_escape_string($con, $_POST["total"][$i]);
        $hsn = mysqli_real_escape_string($con, $_POST["hsn"][$i]);
        $sgst = mysqli_real_escape_string($con, $_POST["sgst"][$i]);
        $cgst = mysqli_real_escape_string($con, $_POST["cgst"][$i]);

        // Check if product already exists for update or insert
        $check_query = "SELECT * FROM invoice_products WHERE SID = '{$sid}' AND PNAME = '{$pname}'";
        $check_result = mysqli_query($con, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            // Product exists, perform update
            $update_query = "UPDATE invoice_products SET PRICE='{$price}', QTY='{$qty}', sgst='{$sgst}', cgst='{$cgst}', TOTAL='{$total}' WHERE SID = '{$sid}' AND PNAME = '{$pname}'";
            if (!$con->query($update_query)) {
                $update_success = false;
                break;
            }
        } else {
            // Product does not exist, perform insert
            $insert_query = "INSERT INTO invoice_products (SID, PNAME, hsn, PRICE, QTY, sgst, cgst, TOTAL) VALUES ('{$sid}', '{$pname}', '{$hsn}', '{$price}', '{$qty}', '{$sgst}', '{$cgst}', '{$total}')";
            if (!$con->query($insert_query)) {
                $update_success = false;
                break;
            }
        }
    }

    if ($update_success) {
        echo "<div class='alert alert-success'>Invoice Updated Successfully.</div> ";
    } else {
        echo "<div class='alert alert-danger'>Failed to update invoice products.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invoice Update Failed.</div>";
}
    }
    ?>
    <form method='post' action="" autocomplete='off' >
        <div class='row'>
            <div class='col-md-4'>
                <h5 class='text-success'>Invoice Details</h5>
                <div class='form-group'>
                    <label>Invoice No</label>
                    <input type='text' name='invoice_no' value="<?php echo $invoiceNo; ?>" required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Invoice Date</label>
                    <input type='text' name='invoice_date' value="<?php echo $invoiceDate; ?>" id='date' required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Place of Supply</label>
                    <input type='text' name='placesupply' value="<?php echo $placesupply; ?>" id='placesupply' required class='form-control'>
                </div>
            </div>
            <div class='col-md-4'>
                <h5 class='text-success'>Customer Details</h5>
                <div class='form-group'>
                    <label>Name</label>
                    <input type='text' name='cname' value="<?php echo $cname; ?>" required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Address</label>
                    <input type='text' name='caddress' value="<?php echo $caddress; ?>" required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>City</label>
                    <input type='text' name='ccity' value="<?php echo $ccity; ?>" required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Customer Email</label>
                    <input type='text' name='customeremail' value="<?php echo $customeremail; ?>" required class='form-control'>
                </div>
            </div>
            <div class='col-md-4'>
                <h5 class='text-success'>Shipping Details</h5>
                <div class='form-group'>
                    <label>Name</label>
                    <input type='text' name='sname' value="<?php echo $sname; ?>" required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Address</label>
                    <input type='text' name='saddress' value="<?php echo $saddress; ?>" required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>City</label>
                    <input type='text' name='scity' value="<?php echo $scity; ?>" required class='form-control'>
                </div>
            </div>
        </div>
        <div class='col-md-12'>
             <h5 class='text-success'>Product Details</h5>
                <div id="product_container">
                <div class="product_row">
            <?php
                // Loop through the product details and populate the form fields
                while ($row = mysqli_fetch_assoc($result_products)) {
                    echo "<div class='product_row'>";
                    echo "<div class='form-group'>";
                    echo "<label>Product</label>";
                    echo "<textarea class='form-control pname' required name='pname[]' rows='3' cols='40'>" . $row['PNAME'] . "</textarea>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label>HSN</label>";
                    echo "<textarea class='form-control hsn' required name='hsn[]' rows='3' cols='40'>" . $row['hsn'] . "</textarea>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label>Price</label>";
                    echo "<textarea class='form-control price' required name='price[]' rows='3' cols='40'>" . $row['PRICE'] . "</textarea>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label>Qty</label>";
                    echo "<textarea class='form-control qty' required name='qty[]' rows='3' cols='40'>" . $row['QTY'] . "</textarea>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label>SGST(%)</label>";
                    echo "<textarea class='form-control sgst' required name='sgst[]' rows='3' cols='40'>" . $row['sgst'] . "</textarea>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label>CGST(%)</label>";
                    echo "<textarea class='form-control cgst' required name='cgst[]' rows='3' cols='40'>" . $row['cgst'] . "</textarea>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label>Total</label>";
                    echo "<textarea class='form-control total' required name='total[]' rows='3' cols='40'>" . $row['TOTAL'] . "</textarea>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'>";
                    echo "<input type='hidden' class='sid' value='" . $row['SID'] . "'>";
                    echo "</div>";
                    echo "</div>";
                }
            ?>
            </div>
            </div>
            <input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'>
            <div class="form-group">
                <label>Grand Total</label>
                <input type='text' name='grand_total' id='grand_total' value= "<?php echo $grand_total; ?>" class='form-control' readonly>
            </div>
            <input type='submit' name='submit' value='Save Invoice' class='btn btn-success float-right'>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        $("#date").datepicker({
            dateFormat:"dd-mm-yy"
        });
    
        // Function to add a new product row
        $("#btn-add-row").click(function(){
            var row = "<div class='product_row'>" +
                        "<div class='form-group'>" +
                            "<label>Product</label>" +
                            "<textarea class='form-control pname' required name='pname[]' rows='3' cols='40'></textarea>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label>HSN</label>" +
                            "<textarea class='form-control hsn' required name='hsn[]' rows='3' cols='40'></textarea>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label>Price</label>" +
                            "<textarea class='form-control price' required name='price[]' rows='3' cols='40'></textarea>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label>Qty</label>" +
                            "<textarea class='form-control qty' required name='qty[]' rows='3' cols='40'></textarea>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label>SGST(%)</label>" +
                            "<textarea class='form-control sgst' required name='sgst[]' rows='3' cols='40'></textarea>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label>CGST(%)</label>" +
                            "<textarea class='form-control cgst' required name='cgst[]' rows='3' cols='40'></textarea>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<label>Total</label>" +
                            "<textarea class='form-control total' required name='total[]' rows='3' cols='40'></textarea>" +
                        "</div>" +
                        "<div class='form-group'>" +
                            "<input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'>" +
                        "</div>" +
                    "</div>";
            $("#product_container").append(row);
        });

         $("body").on("click", ".btn-row-remove", function(){
    var row = $(this).closest(".product_row");
    var productName = row.find(".pname").val(); // Assuming you have an input field with class "pname" containing the product name
    var SID = row.find(".sid").val(); // Assuming you have an input field with class "sid" containing the SID
    console.log("Product Name to delete:", productName); // For debugging

    // Send AJAX request to delete product
    $.ajax({
        url: 'delete_product.php',
        type: 'POST',
        data: { productName: productName, SID: SID }, // Pass productName and SID
        success: function(response) {
            console.log("Server response:", response); // For debugging
            // Remove the row from the HTML if deletion is successful
            row.remove();
            calculateGrandTotal();
            // Show success message if needed
            Swal.fire(
                'Deleted!',
                'Your product has been deleted.',
                'success'
            );
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); // Log the error message
            // Handle errors if any
            // Show error message if needed
            Swal.fire(
                'Error!',
                'Failed to delete the product.',
                'error'
            );
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
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
