<?php 

require "config.php";
session_start();
if(!isset($_SESSION['login'])){
    header("location: login.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/demo.css" />
    <!--<link rel="stylesheet" href="css/slider.css">-->
    <!--<link rel="stylesheet" href="css/asset.css">-->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<style>

.gst{
            max-width: auto;
            margin: auto;

            /*text-align: center;*/
            background-color: #67B26F;
            background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            display: flex;
            flex-direction: row;
            /* align-items: center;
            justify-content: center; */
        }

        .sentence {
            margin-left: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            
        }
</style>
              
<!-- Student Profile -->
      <div class="gst">
      <a href="home.php" >
      <i class="material-icons nav__icon">arrow_back</i>
      </a>
      <div class = "sentence"> <p> Profile </p></div>
      </div>
      
<div class="student-profile py-2">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent text-center">
            <img class="profile_img" src=<?php echo $_SESSION['Image'] ?> alt="student dp">
            <h3><?php echo $_SESSION['comname'] ?></h3>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>General Information</h3>
          </div>
          <div class="card-body pt-0">
            <table width="0%" class="table table-bordered">
              <tr>
                <th width="30%">Company Name</th>
                <td width="2%">:</td>
                <th width="68%"><?php echo $_SESSION['comname'] ?></th>
              </tr>
              <tr>
                <th width="30%">GSTIN</th>
                <td width="2%">:</td>
                <th width="68%"><?php echo $_SESSION['GSTIN'] ?></th>
              </tr>
              <tr>
                <th width="30%">Phone</th>
                <td width="2%">:</td>
                <th width="68%"><?php echo $_SESSION['cphone'] ?></th>
              </tr>
              <tr>
                <th width="30%">Email</th>
                <td width="2%">:</td>
                <th width="68%"> <?php echo $_SESSION['comemail'] ?></th>
              </tr>
              <tr>
                <th width="30%">Address</th>
                <td width="2%">:</td>
                <th width="68%"><?php echo $_SESSION['comaddress'] ?></th>
              </tr>
              <tr>
                <th width="30%">Signature</th>
                <td width="2%">:</td>
                <th width="68%"><img class="profile_img" style="width: 120px; height: auto;" src=<?php echo $_SESSION['signc'] ?> alt="student dp"></th>
              </tr>
            </table>
          </div>
        </div>
          <div style="height: 0px"></div>
        
      </div>
    </div>
  </div>
</div>

           
    		</div>
		</div>
    </div>

	</body>
</html>