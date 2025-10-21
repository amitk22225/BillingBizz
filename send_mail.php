<?php


	require('phpmailer/src/PHPMailer.php');
		require('phpmailer/src/SMTP.php');
		require('phpmailer/src/Exception.php');
	

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];

    if (!empty($message)) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'mail.kitchenyards.in'; // Your SMTP server address
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@kitchenyards.in'; // Your SMTP username
            $mail->Password = 'Amit@23012'; // Your SMTP password
            $mail->Port = 587; // TCP port to connect to

            // Sender and recipient
            $mail->setFrom("no-reply@kitchenyards.in", "Invoice Maker");
            $mail->addAddress('amitk22225@gmail.com');

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'New Message from Contact Form';
            $mail->Body = '<p>' . $message . '</p>';

            // Send the email
            $mail->send();

            // Success response
            echo json_encode(['status' => 'success', 'message' => 'Email has been sent.']);
            header ("location:help.php");
                    
        } catch (Exception $e) {
            // Error response
            echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
        }
    } else {
        // Empty message response
        echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty.']);
    }
} else {
    // Invalid request response
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}