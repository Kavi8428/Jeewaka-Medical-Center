<?php
include '../connection.php';

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the array of form data
    $formDataArray = $_POST['rows'];

    // Iterate over each row of form data
    foreach ($formDataArray as $rowData) {
        // Sanitize and validate input data (you should add more validation)
        $id = mysqli_real_escape_string($conn, $rowData['id']);
        $itemName = mysqli_real_escape_string($conn, $rowData['itemName']);
        $generic = mysqli_real_escape_string($conn, $rowData['generic']);
        $quantity = mysqli_real_escape_string($conn, $rowData['quantity']);
        $remarks = mysqli_real_escape_string($conn, $rowData['remarks']);

        if ($id == null){
            // Insert data into the database
            $sql = "INSERT INTO medicines (name, mediName, remark) VALUES ('$itemName', '$generic', '$remarks')";
            if (mysqli_query($conn, $sql)) {
                // Success response
                echo json_encode(['success' => true]);
            } else {
                // Error response
                echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
            }
        } else {
            // Update existing record
            $updateQuery = "UPDATE medicines SET name = '$itemName', mediName = '$generic', remark = '$remarks', qt = '$quantity' WHERE id = '$id' ";
            if (mysqli_query($conn, $updateQuery)) {
                // Success response
                echo json_encode(['success' => true]);
            } else {
                // Error response
                echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
            }
        }   
    }
} else {
    // If the request method is not POST
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
