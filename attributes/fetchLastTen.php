<?php
 include '../connection.php';
// SQL query to fetch the last 10 entries from the patient table
$sql = "SELECT * FROM patient ORDER BY serial DESC LIMIT 10";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data and store it in an array
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Convert data to JSON and echo it
    echo json_encode($data);
} else {
    echo json_encode(array('message' => 'No results'));
}
// Close the connection
$conn->close();
?>
