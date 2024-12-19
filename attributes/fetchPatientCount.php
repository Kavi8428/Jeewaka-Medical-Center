<?php
include '../connection.php';

// Get today's date
$today = date("Y-m-d");

//echo 'today',$today;
// Doctor's name (you should pass this as a parameter)
$doctorName = $_GET['doctor'];

// SQL query to fetch patient count for today where doctor is the specified one and lv is 0
$sql = "SELECT COUNT(*) AS patientCount FROM patient WHERE DATE(created_at) = CURDATE() AND doctor = '$doctorName' AND lv = 0";

$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Fetch result
        $row = $result->fetch_assoc();
        $response = array(
            'success' => true,
            'patientCount' => $row['patientCount']
        );
        // Convert response to JSON and output
        echo json_encode($response);
    } else {
        // No patients found for today with the specified doctor and level
        $response = array(
            'success' => false,
            'error' => 'No patients found for today with the specified doctor and level'
        );
        // Convert response to JSON and output
        echo json_encode($response);
    }
} else {
    // Error executing query
    $response = array(
        'success' => false,
        'error' => 'Error executing query: ' . $conn->error
    );
    // Convert response to JSON and output
    echo json_encode($response);
}

// Close connection
$conn->close();
?>
