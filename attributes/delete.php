<?php
// Database connection
include '../connection.php';

// Retrieve the GRN ID from the POST request
$grnID = $_POST['id'];
$table = $_POST['table'];
$primaryKey = $_POST['primaryKey'];

// Delete the row from the 'grnproducts' table
$sql = "DELETE FROM $table WHERE $primaryKey ='$grnID'";
if ($conn->query($sql) === FALSE) {
    echo "Error deleting row: " . $conn->error;
} else {
    echo "Row deleted successfully!";
}

$conn->close();
?>

