<?php
//fetchGrnData.php
// Database connection
include '../connection.php';

// SQL query to fetch data
$sql = "SELECT * FROM grn";
$result = $conn->query($sql);

$data = array();

// Fetch associative array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close connection
$conn->close();

// Return data as JSON
echo json_encode($data);
?>