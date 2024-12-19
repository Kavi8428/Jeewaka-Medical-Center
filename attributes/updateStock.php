<?php

// Allow requests from any origin (CORS)
header("Access-Control-Allow-Origin: *");

// Include connection.php file
include '../connection.php';

// Get the JSON data sent from JavaScript
$data = json_decode(file_get_contents("php://input"), true);

// Initialize response array
$response = array();

// Update MySQL table based on the received data
foreach ($data as $row) {
    $genericName = $row['genericName'];
    $companyName = $row['companyName'];
    $rowQty = $row['rowQty'];
    
    // SQL query to update the table
    $sql = "UPDATE medicines SET qt = $rowQty WHERE name = '$companyName' AND mediName = '$genericName'";

    if ($conn->query($sql) === TRUE) {
        $response[] = array("success" => true, "message" => "Data updated successfully for $companyName - $genericName");
    } else {
        $response[] = array("success" => false, "message" => "Error updating data for $companyName - $genericName: " . $conn->error);
    }
}

// Send JSON response
echo json_encode($response);

$conn->close();

?>
