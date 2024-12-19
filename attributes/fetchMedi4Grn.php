<?php
include '../connection.php';

// Fetch data from medicines table
$sql = "SELECT * FROM medicines";
$result = $conn->query($sql);

$medicines = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicines[] = $row;
    }
}

// Close connection
$conn->close();

// Convert PHP array to JSON
$medicines_json = json_encode($medicines);

// Set the content type to JSON
header('Content-Type: application/json');

// Output the JSON data
echo $medicines_json;
?>
