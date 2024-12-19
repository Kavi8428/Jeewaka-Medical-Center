<?php
// your_php_script.php

include '../connection.php';


// Receive data from frontend
$data = json_decode(file_get_contents('php://input'), true);

// Extract relevant fields from data
$serialNumber = $data['serialNumber'];
$cashNurse = $data['userCode'];
$doctor = $data['doctor'];
$card = $data['card'];
$patient = $data['patientNameInput'];
$jd = $data['jdInput'];
$jmc = $data['jmcInput'];
$np = $data['npInput'];
$received = $data['receivedInput'];
$remain = $data['remainInput'];
$total = $data['totalInput'];
$nv = $data['nextVisitDateInput'];
$medicalHistory = $data['medicalHistory'];
$medicalProblem = $data['medicalProblem'];
$allergies = $data['allergies'];
$remark = $data['remark'];
$paymentMethod = $data['paymentMethod'];

$sql = "UPDATE patient SET name ='$patient',cashNurse='$cashNurse',	allergies='$allergies',doctor='$doctor',medicalHistory='$medicalHistory', lv='1', jd ='$jd',jmc ='$jmc',np='$np',total ='$total', received ='$received',remain ='$remain',	medicalProblem ='$medicalProblem', nextVisitDate ='$nv', remark ='$remark',	paymentMethod ='$paymentMethod', card = '$card'	WHERE serial = '$serialNumber'";

// Execute SQL query
if ($conn->query($sql) === TRUE) {
    $response = array(
        'success' => true,
        'message' => 'Data updated successfully'
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Error updating data: ' . $conn->error
    );
}



//$fieldsToUpdate = array();

// Check which fields are present in the received data and add them to the fields to update
/*
if (isset($data['userCode'])) {
    $fieldsToUpdate[] = "cashNurse = '" . $data['userCode'] . "'";
}

if (isset($data['allergies'])) {
    $fieldsToUpdate[] = "allergies = '" . $data['allergies'] . "'";
}
if (isset($data['doctor'])) {
    $fieldsToUpdate[] = "doctor = '" . $data['doctor'] . "'";
}
$fieldsToUpdate[] = "lv = '1'";


if (isset($data['jdInput'])) {
    $fieldsToUpdate[] = "jd = '" . $data['jdInput']/2 . "'";

}

if (isset($data['jmcInput'])) {
    $fieldsToUpdate[] = "jmc = '" . $data['jmcInput']/2 . "'";
}
if (isset($data['npInput'])) {
    $fieldsToUpdate[] = "np = '" . $data['npInput']/2 . "'";
}
if (isset($data['totalInput'])) {
    $fieldsToUpdate[] = "total = '" . $data['totalInput']/2 . "'";
}
if (isset($data['receivedInput'])) {
    $fieldsToUpdate[] = "received = '" . $data['receivedInput']/2 . "'";
}
if (isset($data['remainInput'])) {
    $fieldsToUpdate[] = "remain = '" . $data['remainInput'] . "'";
}
if (isset($data['medicalProblem'])) {
    $fieldsToUpdate[] = "medicalProblem = '" . $data['medicalProblem'] . "'";
}
if (isset($data['nextVisitDateInput'])) {
    $fieldsToUpdate[] = "nextVisitDate = '" . $data['nextVisitDateInput'] . "'";
}
if (isset($data['remark'])) {
    $fieldsToUpdate[] = "remark = '" . $data['remark'] . "'";
}
if (isset($data['paymentMethod'])) {
    $fieldsToUpdate[] = "paymentMethod = '" . $data['paymentMethod'] . "'";
}*/



// Construct SQL query to update relevant fields based on serial number


// Send response back to frontend
echo json_encode($response);

// Close database connection
$conn->close();
?>
