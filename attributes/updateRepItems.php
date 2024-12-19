<?php
// Database connection details
include '../connection.php';


// Get the JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

if ($data === null) {
    die('Invalid JSON');
}

// Prepare statements for checking existence and inserting/updating
$checkStmt = $conn->prepare("SELECT id FROM rep_items WHERE repCode = ? AND mediItem = ?");
$updateStmt = $conn->prepare("UPDATE rep_items SET bb = ?, mrBonus = ?, cashBonus = ? WHERE repCode = ? AND mediItem = ?");
$insertStmt = $conn->prepare("INSERT INTO rep_items (repCode, mediItem, bb, mrBonus, cashBonus, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");

// Initialize a variable to collect response messages
$responseMessages = [];

// Loop through the received data
foreach ($data as $item) {
    $repCode = $item['repMediID'];
    $mediItem = $item['mediItem'];
    $bb = $item['bBonus'];
    $mrBonus = $item['mrBonus'];
    $cashBonus = $item['cBonus'];

    // Check if the record already exists
    $checkStmt->bind_param("ss", $repCode, $mediItem);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Record exists, update it
        $updateStmt->bind_param("ddsss", $bb, $mrBonus, $cashBonus, $repCode, $mediItem);
        if ($updateStmt->execute()) {
            $responseMessages[] = "Updated: repCode = $repCode, mediItem = $mediItem";
        } else {
            $responseMessages[] = "Failed to update: repCode = $repCode, mediItem = $mediItem. Error: " . $conn->error;
        }
    } else {
        // Record does not exist, insert a new one
        $insertStmt->bind_param("ssddd", $repCode, $mediItem, $bb, $mrBonus, $cashBonus);
        if ($insertStmt->execute()) {
            $responseMessages[] = "Inserted: repCode = $repCode, mediItem = $mediItem";
        } else {
            $responseMessages[] = "Failed to insert: repCode = $repCode, mediItem = $mediItem. Error: " . $conn->error;
        }
    }
}

// Close statements and connection
$checkStmt->close();
$updateStmt->close();
$insertStmt->close();
$conn->close();

// Send response back to the client as plain text
echo implode("\n", $responseMessages);
?>
