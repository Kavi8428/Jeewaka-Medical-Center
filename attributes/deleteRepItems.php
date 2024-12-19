<?php
// Database connection
include '../connection.php';

// Retrieve the GRN ID from the POST request
$table = $_POST['table'];
$primaryKey = $_POST['primaryKey'];
$primaryKeyValue = $_POST['primaryKeyValue'];
$id= $_POST['id'];
$idValue= $_POST['idValue'];


if ($primaryKeyValue != null){
// Delete the row from the 'grnproducts' table
$sql = "DELETE FROM `$table` WHERE `$id`='$idValue' AND `$primaryKey`='$primaryKeyValue'";
if ($conn->query($sql) === FALSE) {
    echo "Error deleting row: " . $conn->error;
} else {
    echo "Row deleted successfully!";
}
}
else{
    echo "Unable to delete. please contact developer";
}



$conn->close();
?>
