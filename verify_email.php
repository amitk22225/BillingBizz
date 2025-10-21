<?php
session_start();

if (isset($_POST['token'])) {
    $enteredToken = $_POST['token'];
    $otp = $_SESSION['otp'];

    if ($enteredToken === $otp) {
        // Authentication successful, perform further actions (e.g., log the user in)
        echo 'Authentication successful. You can now access your account.';
    } else {
        echo 'Invalid authentication token. Please try again.';
    }
} else {
    echo 'Token not provided.';
}
?>
