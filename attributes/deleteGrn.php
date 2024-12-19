
<?php
// Database connection
include '../connection.php';

// Retrieve the GRN ID from the POST request
$id = $_POST['grnId'];

// Delete the row from the 'grnproducts' table
$sql = "DELETE FROM grn WHERE id='$grnID'";
if ($conn->query($sql) === FALSE) {
    echo "Error deleting row: " . $conn->error;
} else {
    echo "Row deleted successfully!";
}

$conn->close();
?>
