<?php
require 'vendor/autoload.php';
require 'config.php';
session_start();


\Stripe\Stripe::setApiKey('your_stripe_api_key');

$session_id = $_GET['session_id'];



$session = \Stripe\Checkout\Session::retrieve($session_id);

echo '<pre>';
print_r($session);
echo '</pre>';

// $paymentIntentID = $session->$paymentIntentID;
// $paymentStatus = $paymentIntentID->status;
$paymentStatus = $session->payment_status;
$paymentid = $session->id;
// $expiryDate = $session->expires_at;
$amount = $session->amount_total;

// echo '<pre>';
// print_r($session);
// print_r($paymentid);
// exit;

$ed = date('Y-m-d H:i:s');

if($amount == 2900){
  $Expirydate = date('Y-m-d H:i:s', strtotime($ed . ' + 30 days'));
} if ($amount == 9900){
  $Expirydate = date('Y-m-d H:i:s', strtotime($ed . ' + 90 days'));
}
if ($amount == 29900){
  $Expirydate = date('Y-m-d H:i:s', strtotime($ed . ' + 365 days'));
}

// echo '<pre>';
// print_r($session);
// print_r($paymentid);
// exit;
// $comemail = $_SESSION['comemail'];
// after expiry update database to NULL
$sql = "INSERT into `payments` (`payment_id`, `payment_status`,`Expirydate`,`comemail`) VALUES ('$paymentid', '$paymentStatus','$Expirydate', '{$_SESSION['comemail']}')";

if($con->query($sql)){
  $id=$con->insert_id;
}

if($paymentStatus == 'unpaid'){
  echo 'payment not successfull';
  
} else {
//   echo 'payment successfull';
//   $date = date("Y-m-d H:i:s", strtotime($date . ' + 30 days'));
//   $extendeddate = date('Y-m-d H:i:s', strtotime($date . ' + 30 days'));
  
  $updateQuery = "UPDATE registered_users SET Expirydatee = '$Expirydate' , payment_status = '$paymentStatus' WHERE comemail = '" .$_SESSION['comemail']. "'";
  $updateResult = mysqli_query($con,$updateQuery);
  header('location: home.php');
}

?>


<!-- <html>
  <head><title>Thanks for your order!</title></head>
  <body>
    <h1>Your monthly subscription is active!</h1>
    <p>
      
      We appreciate your time!
      If you have any questions, please email: gjhwatters@gmail.com
      <a href="index.php">HOME</a>.
    </p>
  </body>

</html> -->
