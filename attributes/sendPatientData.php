<?php
// Establish a connection to the database
include '../connection.php';

// Gather data from the AJAX request
$docName = $_POST['docName'];
$oppointment = $_POST['oppointment'];
$dateInput = $_POST['dateInput'];
$age = $_POST['age'];
$name = $_POST['name'];
$tel = $_POST['tel'];
$nurse = $_POST['nurse'];
$sex = $_POST['sex'];
$allergies = $_POST['allergies'];
$medicalHistory = $_POST['medicalHistory'];
$status = $_POST['status'];

// Echo the received data back to the client for debugging
echo json_encode($_POST);

// Assuming you have columns in your table corresponding to these variables
$sql = "INSERT INTO patient (doctor, oppointment, dob, name, tel, sex, nurse, allergies, medicalHistory, lv, status) VALUES ('$docName', '$oppointment', '$dateInput', '$name', '$tel', '$sex', '$nurse', '$allergies', '$medicalHistory', 0, '$status')";

// Improved error handling
if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    $errorDetails = array(
        'error' => "Error: " . $sql . "<br>" . $conn->error,
        'docName' => $docName,
        'oppointment' => $oppointment,
        'dateInput' => $dateInput,
        'age' => $age,
        'name' => $name,
        'tel' => $tel,
        'nurse' => $nurse,
        'sex' => $sex,
        'allergies' => $allergies,
        'medicalHistory' => $medicalHistory,
        'lv' => 0,
        'status' => $status,

    );

    // Log the detailed error information
    error_log(json_encode($errorDetails), 0);

    // Echo a generic error message back to the client
    echo "Error: Unable to insert data";
}

// Close the database connection
$conn->close();
?>
