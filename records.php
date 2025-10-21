<?php 

require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}

if(isset($_SESSION['ID'])){
$query = "SELECT * from invoicee where comname = '" .$_SESSION['comname']. "'";
$result = mysqli_query($con,$query);
}
// if($_POST["viewpdf"]){
// $query = "SELECT * from invoicee where SID = '{$_GET['sid']}'";
// $result = mysqli_query($con,$query);
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css"/>
    <link rel="stylesheet" a href="bootstrap.min.css"/>
    <link rel="stylesheet"  href="https://cdn.datatables.net/1.13.6/css/dataTables.bulma.min.css"/>
    <title>View Records</title>
<body class="bg-white">
<style>
    .container{
      overflow-x:auto; 
      width:auto;
    }
    .header {
        background:#f1f1f1;
        padding: 10px;
        color: #000;
        text-indent: 100px;
    }
    .back {
        padding: 10px;
        
          
    }
    .previous {
    background-color: #f1f1f1;
    color: white;
    text-align: top;
    }


.round {
  border-radius: 50%;
}
    
</style>
<div class="header">
    <i class="fas fa-arrow-left" onclick="history.back()">&#8249;</i>
         <h3>
             View Records
         </h3>
       
        
    </div>
    <div class="back">
       
    </div>
        <div class="container p-30">
           
            <!--<div class="row">-->
            <!--    <div class="col m-auto">-->
            <!--        <div class="card mt-5">-->
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                <th> Invoice No </th>
                                <th> Invoice Date </th>
                                <th> Customer Name </th>
                                <th> Customer Email </th>
                                <th> Action  </th>
                                </tr>
                            </thead>
                           
                            <tbody>
                                <?php
                                while($row=mysqli_fetch_assoc($result))
                                {
                                $InvoiceNo = $row['INVOICE_NO'];
                                $InvoiceDate = $row['INVOICE_DATE'];
                                $cname = $row['CNAME'];
                                $customeremail = $row['customeremail'];
                                $sid = $row['SID'];
                                ?>
                                    
                                        <tr>
                                        <td><?php echo $InvoiceNo ?></td>
                                        <td><?php echo $InvoiceDate?></td>
                                        <td><?php echo $cname?></td>
                                        <td><?php echo $customeremail?></td>
                                        
                                        
                                        <td>
                                        <a href="print.php?id=<?php echo $row['SID']; ?> &ACTION=VIEW" class="btn btn-primary md-3" > View PDF</a>  
                                        <a href="print.php?id=<?php echo $row['SID']; ?> &ACTION=EMAIL" class="btn btn-success md-3">Send Email</a>
                                        <a href="print.php?id=<?php echo $row['SID']; ?> &ACTION=DOWNLOAD" class="btn btn-danger md-3">Download PDF</a>
                                        <a href="print.php?id=<?php echo $row['SID']; ?> &ACTION=DELETE" class="btn btn-danger md-3">Delete</a>
                                        <!--<div class='form-group'>-->
                                        <!--<label>Please select Invoice type</label> <br>-->
                                        <!--<div class='form-group mb-3'>-->
                                        <!--<input type="radio" name="itype" value="ORIGINAL FOR RECIPIENT" /> ORIGINAL FOR RECIPIENT-->
                                        <!--<input type="radio" name="itype" value="DUPLICATE FOR RECIPIENT" /> DUPLICATE FOR RECIPIENT-->
                                        <!--<input type="radio" name="itype" value="TRIPLICATE FOR RECIPIENT" /> TRIPLICATE FOR RECIPIENT-->
                                        <!--</div>-->
                                        <!--</div>-->
                                        </td>
                                        </tr>
                                           
                                         <?php
                                             }
                                         ?>
                                    </tbody>
                                   

                        </table>
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            
        </div>
        
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bulma.min.js"></script>
<script>
    $(document).ready(function(){
        $('#example').DataTable();
        
    });

</script>
</body>


</head>
</html>
