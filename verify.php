<div class="col-md-6">                    
	<div class="panel panel-info" >
		<div class="panel-heading">
			<div class="panel-title">Enter OTP</div>                        
		</div> 
		<div style="padding-top:30px" class="panel-body" >
			<?php if ($errorMessage != '') { ?>
				<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
			<?php } ?>
			<form id="authenticateform" class="form-horizontal" role="form" method="POST" action="">  					
				<div style="margin-bottom: 25px" class="input-group">
					<label class="text-success">Check your email for OTP</label>
					<input type="text" class="form-control" id="otp" name="otp" placeholder="One Time Password">                       
				</div>                          
				<div style="margin-top:10px" class="form-group">                               
					<div class="col-sm-12 controls">
					  <input type="submit" name="authenticate" value="Submit" class="btn btn-success">						  
					</div>
				</div>                                
			</form>   
		</div>                     
	</div>  
</div>

<?php
if(!empty($_POST["authenticate"]) && $_POST["otp"]!='') {
	$sqlQuery = "SELECT * FROM authentication WHERE otp='". $_POST["otp"]."' AND expired!=1 AND NOW() <= DATE_ADD(created, INTERVAL 1 HOUR)";
	$result = mysqli_query($conn, $sqlQuery);
	$count = mysqli_num_rows($result);
	if(!empty($count)) {
		$sqlUpdate = "UPDATE authentication SET expired = 1 WHERE otp = '" . $_POST["otp"] . "'";
		$result = mysqli_query($conn, $sqlUpdate);
		header("Location:welcome.php");
	} else {
		$errorMessage = "Invalid OTP!";
	}	
} else if(!empty($_POST["otp"])){
	$errorMessage = "Enter OTP!";	
}	
?>