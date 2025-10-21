<?php
session_start();
require "config.php";
$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

$comname = $_SESSION['comname'];
$cphone = $_SESSION['cphone'];
$comemail = $_SESSION['comemail'];


// Upload the file
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
    // File uploaded successfully
    $additionalData = $_POST['additionalData'];

    // Database connection (replace with your database credentials)


    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO uploads (file_path, additional_data,comname,cphone,comemail) VALUES 
    ('$targetFile', '$additionalData','$comname','$cphone','$comemail')";

    if ($con->query($sql) === TRUE) {
        echo "File uploaded and data inserted into the database successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
} else {
    // Error uploading file
    echo "Error uploading file.";
}
?>
