<?php
// Include/configure database connection
require_once 'config.php';

// Check if product name and SID are provided via POST request
if(isset($_POST['productName']) && isset($_POST['SID'])) {
    $productName = $_POST['productName'];
    $SID = $_POST['SID'];

    echo "SID: " . $SID;
    // Perform deletion query
    $delete_query = "DELETE FROM quotation_products WHERE SID = ? AND PNAME = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("is", $SID, $productName); // "is" indicates integer and string data types
    if($stmt->execute()) {
        // Deletion successful
        echo "Product deleted successfully.";
    } else {
        // Deletion failed
        echo "Error: " . $stmt->error;
    }
} else {
    // Product name or SID not provided
    echo "Error: Product name or SID not provided.";
}
?>
