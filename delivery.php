<?php 
require "config.php"; 
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}

?>
<html>
  <head>
    <title>Delivery Challan</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/asset.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
      <div class = "sentence"> <p> Delivery Challan </p></div>
    </div>
      <?php
        if(isset($_POST["submit"])){
            // include "mail_function.php";
            // sendattachment($_POST["customeremail"]);
          $challan_no=$_POST["challan_no"];
          $challan_date=date("Y-m-d",strtotime($_POST["challan_date"]));
          $placesupply=mysqli_real_escape_string($con,$_POST["placesupply"]);
        //   $itype=mysqli_real_escape_string($con,$_POST["itype"]);
          $cname=mysqli_real_escape_string($con,$_POST["cname"]);
          $caddress=mysqli_real_escape_string($con,$_POST["caddress"]);
          $ccity=mysqli_real_escape_string($con,$_POST["ccity"]);
          $scity=mysqli_real_escape_string($con,$_POST["scity"]);
          $sname=mysqli_real_escape_string($con,$_POST["sname"]);
          $customeremail=mysqli_real_escape_string($con,$_POST["customeremail"]);
          $saddress=mysqli_real_escape_string($con,$_POST["saddress"]);
          $grand_total=mysqli_real_escape_string($con,$_POST["grand_total"]);
          $transportmode = mysqli_real_escape_string($con,$_POST["transportmode"]);
          $vehiclenumber = mysqli_real_escape_string($con,$_POST["vehiclenumber"]);
          
          $sql="insert into deliverychallan (CHALLAN_NO,CHALLAN_DATE,PLACESUPPLY,CNAME,CADDRESS,CCITY,SNAME,SADDRESS,SCITY,GRAND_TOTAL,comname,customeremail,transportmode, vehiclenumber) values ('{$challan_no}','{$challan_date}','{$placesupply}','{$cname}','{$caddress}','{$ccity}','{$sname}','{$saddress}','{$scity}','{$grand_total}','{$_SESSION['comname']}','{$customeremail}', '{$transportmode}', '{$vehiclenumber}') ";
          if($con->query($sql)){
            $sid=$con->insert_id;
            
            $sql2="insert into invoice_products (SID,PNAME,hsn,PRICE,QTY,sgst,cgst,TOTAL) values ";
            $rows=[];
            for($i=0;$i<count($_POST["pname"]);$i++)
            {
              $pname=mysqli_real_escape_string($con,$_POST["pname"][$i]);
              $price=mysqli_real_escape_string($con,$_POST["price"][$i]);
              $qty=mysqli_real_escape_string($con,$_POST["qty"][$i]);
              $total=mysqli_real_escape_string($con,$_POST["total"][$i]);
              $hsn=mysqli_real_escape_string($con,$_POST["hsn"][$i]);
              $sgst=mysqli_real_escape_string($con,$_POST["sgst"][$i]);
              $cgst=mysqli_real_escape_string($con,$_POST["cgst"][$i]);
              $rows[]="('{$sid}','{$pname}','{$hsn}','{$price}','{$qty}','{$sgst}','{$cgst}','{$total}')";
            }
            $sql2.=implode(",",$rows);
            if($con->query($sql2)){
              
            echo "<div class='alert alert-success'>Delivery Challan Added Successfully. </div> ";
                

            }else{
              echo "<div class='alert alert-danger'>Delivery Challan Added Failed.</div>";
            }
          }else{
            echo "<div class='alert alert-danger'>Delivery Challan Added Failed.</div>";
          }
        }


        
      ?>
      <form method='post' action="" autocomplete='off' >
        <div class='row'>
          <div class='col-md-4'>
            <h5 class='text-success'>Delivery Challan Details</h5>
            <div class='form-group'>
              <label>Challan No</label>
              <input type='text' name='challan_no' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Challan Date</label>
              <input type='text' name='challan_date' id='date' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Place of Supply</label>
              <input type='text' name='placesupply' id='placesupply' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Transport Mode</label>
              <input type='text' name='transportmode' id='transportmode' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Vehicle Number</label>
              <input type='text' name='vehiclenumber' id='vehiclenumber' required class='form-control'>
            </div>
      </div>
          <div class='col-md-4'>
            <h5 class='text-success'>Customer Details</h5>
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
              <label>Customer Email</label>
              <input type='text' name='customeremail' required class='form-control'>
            </div>
          </div>
      
            <div class='col-md-4'>
            <h5 class='text-success'>Shipping Details</h5>
            <div class='form-group'>
              <label>Name</label>
              <input type='text' name='sname' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>Address</label>
              <input type='text' name='saddress' required class='form-control'>
            </div>
            <div class='form-group'>
              <label>City</label>
              <input type='text' name='scity' required class='form-control'>
            </div>
          </div>
        </div>
        <!--<div class='form-group'>-->
        <!--    <label>Please select Invoice type</label> <br>-->
        <!--    <div class='form-group mb-3'>-->
        <!--    <input type="radio" name="itype" value="ORIGINAL FOR RECIPIENT" /> ORIGINAL FOR RECIPIENT-->
        <!--    <input type="radio" name="itype" value="DUPLICATE FOR RECIPIENT" /> DUPLICATE FOR RECIPIENT-->
        <!--    <input type="radio" name="itype" value="TRIPLICATE FOR RECIPIENT" /> TRIPLICATE FOR RECIPIENT-->
        <!--    </div>-->
        <!--</div>-->
        <div class='col-md-12'>
    <h5 class='text-success'>Product Details</h5>
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
                <label>Price</label>
                <textarea class="form-control price" required name='price[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <label>Qty</label>
                <textarea class="form-control qty" required name='qty[]' rows='2' cols='40'></textarea>
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
                <label>Total</label>
                <textarea class="form-control total" required name='total[]' rows='2' cols='40'></textarea>
            </div>
            <div class="form-group">
                <input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'>
            </div>
        </div>
    </div>
    <input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'>
    <div class="form-group">
    <label>Grand Total</label>
    <input type='text' name='grand_total' id='grand_total' class='form-control' readonly>
    </div>
    <input type='submit' name='submit' value='Save Invoice' class='btn btn-success float-right'>
</div>

        <!-- <div class='rowScroll'>
          <div class='col-md-12'>
            <h5 class='text-success'>Product Details</h5>
            <table class='table table-bordered'>
              <thead>
                <tr>
                  <th>Product</th>
                  <th>HSN</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>SGST(%)</th>
                  <th>CGST(%)</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id='product_tbody'>
                <tr>
                  <td> <textarea class="form-control" required name='pname[]' rows="3" cols="40" style="width: 120px; height: 100px;"></textarea> </td>
                  <td> <textarea class="form-control hsn" required name='hsn[]' rows="3" cols="40" style="width: 120px; height: 100px;"></textarea> </td>
                  <td><input type='text' required name='hsn[]' class='form-control hsn'></td> -->
                  <!-- <td> <textarea class="form-control price" required name='price[]' rows="3" cols="40" style="width: 120px; height: 100px;"></textarea> </td>
                  <td> <textarea class="form-control qty" required name='qty[]' rows="3" cols="40" style="width: 120px; height: 100px;"></textarea> </td>
                  <td> <textarea class="form-control sgst" required name='sgst[]' rows="3" cols="40" style="width: 120px; height: 100px;"></textarea> </td>
                  <td> <textarea class="form-control cgst" required name='cgst[]' rows="3" cols="40" style="width: 120px; height: 100px;"></textarea> </td>
                  <td> <textarea class="form-control total" required name='total[]' rows="3" cols="40" style="width: 120px; height: 100px;"></textarea> </td> -->

                  <!-- <td> <input type='text' required name='price[]' class='form-control price'></td>
                  <td><input type='text' required name='qty[]' class='form-control qty'></td>
                  <td><input type='text' required name='sgst[]' class='form-control sgst'></td>
                  <td><input type='text' required name='cgst[]' class='form-control cgst'></td>
                  <td><input type='text' required name='total[]' class='form-control total'></td> -->
                  <!-- <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td><input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'></td>
                  <td colspan='5' class='text-right'>Total</td>
                  <td><input type='text' name='grand_total' id='grand_total' class='form-control' required></td>
                </tr>
              </tfoot>
            </table> -->
            <!-- <input type='submit' name='submit' value='Save Invoice' class='btn btn-success float-right'> -->
          <!-- </div>
        </div> -->
      </form>
    </div>
    <script>
      $(document).ready(function(){
        $("#date").datepicker({
          dateFormat:"dd-mm-yy"
        });
        
        //   $("#btn-add-row").click(function(){
        //   var row="<tr> <td> <textarea class='form-control' required name='pname[]' rows='3' cols='40' style='width: 120px; height: 100px;'></textarea> </td> <td> <textarea class='form-control hsn' required name='hsn[]' rows='3' cols='40' style='width: 120px; height: 100px;'></textarea> </td>  <td> <textarea class='form-control price' required name='price[]' rows='3' cols='40' style='width: 120px; height: 100px;'></textarea> </td> <td> <textarea class='form-control qty' required name='qty[]' rows='3' cols='40' style='width: 120px; height: 100px;'></textarea> </td> <td> <textarea class='form-control sgst' required name='sgst[]' rows='3' cols='40' style='width: 120px; height: 100px;'></textarea> </td> <td> <textarea class='form-control cgst' required name='cgst[]' rows='3' cols='40' style='width: 120px; height: 100px;'></textarea> </td> <td> <textarea class='form-control total' required name='total[]' rows='3' cols='40' style='width: 120px; height: 100px;'></textarea> </td> <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";
        //   $("#product_tbody").append(row);
        // });
        
       
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
    
        // $("body").on("click",".btn-row-remove",function(){
        //   if(confirm("Are You Sure you want to remove item?")){
        //     $(this).closest("tr").remove();
        //     grand_total();
        //   }
        // });

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

        // $("body").on("keyup",".price",function(){
        //   var price=Number($(this).val());
        //   var qty=Number($(this).closest("tr").find(".qty").val());
        //   var cgst=Number($(this).closest("tr").find(".cgst").val());
        //   var sgst=Number($(this).closest("tr").find(".sgst").val());
        //   $(this).closest("tr").find(".total").val(price*qty);
        //   grand_total();
        // });
        
        // $("body").on("keyup",".sgst",function(){
        //   var price=Number($(this).closest("tr").find(".price").val());
        //   var qty=Number($(this).closest("tr").find(".qty").val());
        //   var sgst=Number($(this).val());
        //   var cgst=Number($(this).closest("tr").find(".cgst").val());
        //   $(this).closest("tr").find(".total").val((price*qty*(sgst/100))+(price*qty*(cgst/100))+(price*qty));
        //   grand_total();
        // });

        // $("body").on("keyup",".cgst",function(){
        //   var price=Number($(this).closest("tr").find(".price").val());
        //   var qty=Number($(this).closest("tr").find(".qty").val());
        //   var cgst=Number($(this).val());
        //   var sgst=Number($(this).closest("tr").find(".sgst").val());
        //   $(this).closest("tr").find(".total").val((price*qty*(sgst/100))+(price*qty*(cgst/100))+(price*qty));
        //   grand_total();
        // });

        // $("body").on("keyup",".qty",function(){
        //   var qty=Number($(this).val());
        //   var price=Number($(this).closest("tr").find(".price").val());
        //   var cgst=Number($(this).closest("tr").find(".cgst").val());
        //   var sgst=Number($(this).closest("tr").find(".sgst").val());
        //   $(this).closest("tr").find(".total").val(price*qty);
        //   grand_total();
        // });      
        
      //   function grand_total(){
      //     var tot=0;
      //     $(".total").each(function(){
      //       tot+=Number($(this).val());
      //     });
      //     $("#grand_total").val(tot);
      //   }
      // });


    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>