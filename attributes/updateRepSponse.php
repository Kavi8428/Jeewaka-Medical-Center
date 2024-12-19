<?php

include '../connection.php';

// Get the JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    foreach ($data as $row) {
        $repID = $conn->real_escape_string($row['repID']);
        $sponseDate = $conn->real_escape_string($row['sponseDate']);
        $sponseValue = $conn->real_escape_string($row['sponseValue']);

        $sql = "INSERT INTO rep_sponse (repID, sponseDate, sponseValue) VALUES ('$repID', '$sponseDate', '$sponseValue')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "No data received"]);
}

$conn->close();
?>
