<?php
// Database connection
include '../connection.php';

// Retrieve the GRN ID and product name from the POST request
$grnID = $_POST['grnId'];
$mediName = $_POST['mediName'];

// Delete the row from the 'grnproducts' table
$sql = "DELETE FROM grnproducts WHERE grnNo='$grnID' AND name='$mediName'";
if ($conn->query($sql) === FALSE) {
    echo "Error deleting row: " . $conn->error;
} else {
    echo "Row deleted successfully!";
}

$conn->close();
?>
