<?php
include '../connection.php';


// SQL query to fetch data from the log table
$sql = "SELECT id, task, other, `date&time` FROM log";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Task: " . $row["task"]. " - Other: " . $row["other"]. " - Date & Time: " . $row["date&time"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
