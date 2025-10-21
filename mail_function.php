<?php	
    	function sendOTP($comemail,$otp) {
		require('phpmailer/src/PHPMailer.php');
		require('phpmailer/src/SMTP.php');
		require('phpmailer/src/Exception.php');
	

                $mail = new \PHPMailer\PHPMailer\PHPMailer();
		        $mail->isSMTP();
                $mail->Host = 'mail.billingbizz.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'no-reply@billingbizz.com';
                $mail->Password = 'Amit@23012345';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom("no-reply@billingbizz.com", "BillingBizz");
                $mail->addAddress($comemail);
                $mail->isHTML(true);
                $mail->Subject = "OTP Verification";
                $mail->Body = "Hi, ".$otp." is OTP BillingBizz login. Please use this OTP within the next 5 minutes";
                $result=$mail->Send();
                return $result;
                }
	
?>


	


 

 