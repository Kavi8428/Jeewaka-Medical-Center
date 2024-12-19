<?php

include "../connection.php";
// Collect data from POST request
$data = json_decode(file_get_contents("php://input"), true);

// Check if ID exists in the table
$stmt_check = $conn->prepare("SELECT id FROM system_user WHERE id = ?");
$stmt_check->bind_param("s", $data['userId']); // Assuming 'userId' is the correct key for the ID
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // ID exists, perform UPDATE operation
    $stmt_check->close();
    $stmt_update = $conn->prepare("UPDATE system_user SET userCode = ?, fullName = ?, userName = ?, password = ?, level = ? WHERE id = ?");
    $stmt_update->bind_param("sssssd", $data['userCode'], $data['fullName'], $data['userName'], $data['password'], $data['userLevel'], $data['userId']); // Assuming 'userId' is the correct key for the ID

    if ($stmt_update->execute()) {
        echo "<script>alert('Record updated successfully')</script>";
    } else {
        echo "Error updating record: " . $stmt_update->error;
    }

    $stmt_update->close();
} else {
    // ID doesn't exist, perform INSERT operation
    $stmt_check->close();
    $stmt_insert = $conn->prepare("INSERT INTO system_user (userCode, fullName, userName, password, level) VALUES (?, ?, ?, ?, ?)");
    $stmt_insert->bind_param("sssss", $data['userCode'], $data['fullName'], $data['userName'], $data['password'], $data['userLevel']);

    if ($stmt_insert->execute()) {
        echo "<script>alert('New record created successfully')</script>";
    } else {
        echo "Error: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

// Close connection
$conn->close();
?>
