<?php 
include '../connection.php';

$query = 'SELECT * FROM order_forcast';

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch all rows as an associative array
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Free the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);

// Send the data as JSON to the front end
header('Content-Type: application/json');
echo json_encode($data);
?>