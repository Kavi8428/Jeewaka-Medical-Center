<?php
// Database connection
include '../connection.php';

// Retrieve and process row-specific data from the POST request
$jsonData = $_POST['mediDataArray'];
$mediDataArray = json_decode($jsonData, true);

// Prepare the SQL query for updating the medicines table
$sql = "UPDATE medicines SET cost = ?, qt = COALESCE(qt, 0) + ? WHERE name = ? AND mediName = ?";
$stmt = $conn->prepare($sql);

// Loop through each row data and update the corresponding record in the database
foreach ($mediDataArray as $rowData) {
    $name = trim($rowData['name']);
    $mediName = trim($rowData['generic']);
    $retailerP = trim($rowData['retailerP']);
    $totalRI = trim($rowData['totalRI']);

    // Bind parameters and execute the statement
    $stmt->bind_param('diss', $retailerP, $totalRI, $name, $mediName);

    // Debugging: Output values of variables
    echo "Company: " . $name . "<br>";
    echo "Medicine Name: " . $mediName . "<br>";
    echo "Retailer Price: " . $retailerP . "<br>";
    echo "Total RI: " . $totalRI . "<br>";

    // Debugging: Output SQL query
    echo "Executing SQL for $name: $sql<br>";

    if ($stmt->execute() === FALSE) {
        echo "Error updating row-specific data: " . $conn->error . "<br>";
    } else {
        echo "Data updated successfully for $name ($mediName)<br>";
    }
}

$stmt->close();
$conn->close();
?>
