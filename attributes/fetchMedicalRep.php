<?php
// Establish connection to MySQL
include '../connection.php';
// Fetch data from the medical_rep table
$sql = "SELECT * FROM medical_rep";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close MySQL connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
