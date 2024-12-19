<?php
// Database connection
include '../connection.php';

// Retrieve general data from the POST request
//$mediRep = $_POST['mediRep'];
$grnId = $_POST['grnId'];
//$invoice = $_POST['invoice'];
$supplier = $_POST['supplier'];
//$serial = $_POST['serial'];
$payment = 'done';


// Update general data in the 'grn' table
$sql = "UPDATE grn SET payment='$payment' WHERE id='$grnId' AND company = '$supplier' ";
if ($conn->query($sql) === FALSE) {
    echo "Error updating general data: " . $conn->error;
}
// Retrieve and process row-specific data from the POST request


$conn->close();
?>
