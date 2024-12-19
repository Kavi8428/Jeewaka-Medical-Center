<?php

include '../connection.php';

// Retrieve POST data
$id = $_POST['id'];
$code = $_POST['code'];
$company = $_POST['company'];
$tel = $_POST['tel'];
$name = $_POST['name'];
$sponseDate = $_POST['sponseDate'];
$sponseValue = $_POST['sponseValue'];
$remarks = $_POST['remarks'];

// Check if the id exists to decide between INSERT and UPDATE
$idCheckQuery = "SELECT id FROM medical_rep WHERE id = '$id'";
$idCheckResult = $conn->query($idCheckQuery);

if ($idCheckResult->num_rows > 0) {
    // Data already exists, update the row
    $updateQuery = "UPDATE medical_rep SET 
        code = '$code', 
        name = '$name', 
        company = '$company', 
        tel = '$tel', 
        sponserDueDate = '$sponseDate', 
        sponserValue = '$sponseValue', 
        remarks = '$remarks', 
        updated_at = NOW() 
        WHERE id = '$id'";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Check if the code already exists in the table for INSERT operation
    $codeCheckQuery = "SELECT id FROM medical_rep WHERE code = '$code'";
    $codeCheckResult = $conn->query($codeCheckQuery);

    if ($codeCheckResult->num_rows > 0) {
        echo "THE REP CODE '$code' IS ALREADY EXIST. PLEASE TRY NEW CODE";
    } else {
        // Data doesn't exist, insert a new row
        $insertQuery = "INSERT INTO medical_rep (id, code, name, company, tel, sponserDueDate, sponserValue, remarks, created_at, updated_at) 
            VALUES ('$id', '$code', '$name', '$company', '$tel', '$sponseDate', '$sponseValue', '$remarks', NOW(), NOW())";
        
        if ($conn->query($insertQuery) === TRUE) {
            echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
}

$conn->close();

?>
