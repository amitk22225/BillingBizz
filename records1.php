<?php 

require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}

if(isset($_SESSION['ID'])){
$query = "SELECT * from deliverychallan where comname = '" .$_SESSION['comname']. "'";
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
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/asset.css">
    <link rel="stylesheet"  href="https://cdn.datatables.net/1.13.6/css/dataTables.bulma.min.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
<div class="container">
        <div class="gst">
        <a href="dashboard.php" >
        <i class="material-icons nav__icon">arrow_back</i>
        </a>
        <div class = "sentence"> <p> Records </p></div>
        </div>
       
    </div>
        <div class="container p-30">
           
            <!--<div class="row">-->
            <!--    <div class="col m-auto">-->
            <!--        <div class="card mt-5">-->
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                <th> Challan No </th>
                                <th> Challan Date </th>
                                <th> Customer Name </th>
                                <th> Customer Email </th>
                                <th> Action  </th>
                                </tr>
                            </thead>
                           
                            <tbody>
                                <?php
                                while($row=mysqli_fetch_assoc($result))
                                {
                                $ChallanNo = $row['CHALLAN_NO'];
                                $ChallanDate = $row['CHALLAN_DATE'];
                                $cname = $row['CNAME'];
                                $customeremail = $row['customeremail'];
                                $sid = $row['SID'];
                                ?>
                                    
                                        <tr>
                                        <td><?php echo $ChallanNo ?></td>
                                        <td><?php echo $ChallanDate?></td>
                                        <td><?php echo $cname?></td>
                                        <td><?php echo $customeremail?></td>
                                        
                                        
                                        <td>
                                        <?php
                                        echo '<a href="print.php?id= ' . $row['SID'] . ' &ACTION=VIEW" class="material-icons mx-3" style="text-decoration: none;">&#xe8a0;</a>';
                                        echo '<a href="print.php?id= ' . $row['SID'] . ' &ACTION=EMAIL" class="material-icons mx-3" style="text-decoration: none;">&#xe0be;</a>';
                                        echo '<a href="print.php?id= ' . $row['SID'] . ' &ACTION=DOWNLOAD" class="material-icons mx-3" style="text-decoration: none;">&#xe2c4;</a>';
                                        echo '<a href="print.php?id= ' . $row['SID'] . ' &ACTION=DELETE" class="material-icons mx-3" style="text-decoration: none;">&#xe872;</a>';
                                        // Add more details as needed
                                        echo '<a href="edit_challan.php?id= ' . $row['SID'] . ' "class="material-icons mx-3" style="text-decoration: none;">&#xe3c9;</a>';
                                        echo '</div>';
                                        ?>
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
