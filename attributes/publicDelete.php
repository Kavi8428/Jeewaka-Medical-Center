<?php
// Database connection
include '../connection.php';

// Retrieve the GRN ID from the POST request
$table = $_POST['table'];
$primaryKey = $_POST['primaryKey'];
$id= $_POST['id'];

// Delete the row from the 'grnproducts' table
$sql = "DELETE FROM `$table` WHERE `$primaryKey`='$id'";
if ($conn->query($sql) === FALSE) {
    echo "Error deleting row: " . $conn->error;
} else {
    echo "Row deleted successfully!";
}

$conn->close();
?>
