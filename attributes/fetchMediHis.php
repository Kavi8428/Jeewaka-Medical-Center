<?php
header('Content-Type: application/json'); // Set the content type to JSON

include '../connection.php';

// Fetch medical history from the 'patient' table
$sql = "SELECT medicalHistory FROM patient";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as JSON
    $medicalHistory = array();
    while ($row = $result->fetch_assoc()) {
        $mh = array(
            'medicalHistory' => $row['medicalHistory']
        );
        $medicalHistory[] = $mh;
    }
    
    echo json_encode($medicalHistory);
} else {
    echo json_encode(array('error' => 'No medical history found')); // Return a JSON error message
}

// Close the connection
$conn->close();
?>
