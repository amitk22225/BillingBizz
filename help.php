<?php
require "config.php";
$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

// Upload the file
move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);

// Get other form data

// Connect to the database (replace with your database credentials)

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Insert data into the database
$sql = "INSERT INTO uploads (file_path) VALUES ('$targetFile')";

if ($con->query($sql) === TRUE) {
    echo "File uploaded successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}

$con->close();
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="css/help.css"
</head>
<body>

    <div>
        <form id="contactForm" method="post" action="send_mail.php">
            <label for="messageInput">Enter your message:</label>
            <textarea id="messageInput" name="message" rows="3" cols="0" placeholder="Type your message here..."></textarea>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <button type="button" value= "upload" >Upload</button>
            <button type="button" onclick="submitForm()">Submit</button>
        </form>
    </div>
    



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function submitForm() {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to submit the form?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit!',
                cancelButtonText: 'Cancel',
                customClass: {
                     popup: 'small-swal'
                }
            }).then(() => {
                    return Swal.fire({
                    icon: 'success',
                    title: 'Message Sent!',
                    text: 'Your message has been sent successfully.',
                    // confirmButtonText: 'Ok',
                });
                }).then((result) => {
                //      Swal.fire({
                //     icon: 'success',
                //     title: 'Message Sent!',
                //     text: 'Your message has been sent successfully.',
                //     // confirmButtonText: 'Ok',
                // });
                if (result.isConfirmed) {
                    document.getElementById('contactForm').submit();
                    
                }
            });
        }
    </script>

</body>
</html>
