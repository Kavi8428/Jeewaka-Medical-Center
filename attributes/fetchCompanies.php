<?php
//fetchCompanies.php
include '../connection.php';

// Initialize an empty array to store user data
$data = [];

// SQL query to fetch users with level = 'doctor'
$sql = "SELECT * FROM companies ";
$result = $conn->query($sql);

// Check if there are any results
if ($result) {
    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Fetch the data and encode it as JSON
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // Return JSON data
        echo json_encode($data);
    } else {
        // No doctors found
        echo json_encode(['message' => 'No doctors found.']);
    }
} else {
    // Error in the SQL query
    echo json_encode(['error' => 'Error executing the query: ' . $conn->error]);
}

// Close the database connection
$conn->close();
?>
