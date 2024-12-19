<?php
include '../connection.php';
header('Content-Type: application/json');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch relevant fields from the patient table
$sql = "SELECT 
            serial,
            doctor, 
            nurse, 
            jd, 
            jmc, 
            total, 
            remain, 
            paymentMethod, 
            nextVisitDate, 
            name, 
            dob, 
            sex, 
            medicalProblem, 
            created_at, 
            updated_at 
        FROM patient WHERE lv = 1" ;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as JSON
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(["message" => "0 results"]);
}
?>
