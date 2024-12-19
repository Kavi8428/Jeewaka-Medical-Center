<?php
header('Content-Type: application/json'); // Set the content type to JSON

include '../connection.php';

// Fetch allergies from the 'patient' table
$sql = "SELECT allergies FROM patient";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as JSON
    $allergies = array();
    while ($row = $result->fetch_assoc()) {
        $allergy = array(
            'allergies' => $row['allergies']
        );
        $allergies[] = $allergy;
    }
    
    echo json_encode($allergies);
} else {
    echo json_encode(array('error' => 'No allergies found')); // Return a JSON error message
}

// Close the connection
$conn->close();
?>
