<?php
include '../connection.php';

// SQL query to fetch users with level = 'doctor'
$sql = "SELECT * FROM system_user WHERE level = 'doctor'";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Fetch the data and encode it as JSON
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode(['message' => 'No doctors found.']);
}


?>
