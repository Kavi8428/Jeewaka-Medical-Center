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
        $code = mysqli_real_escape_string($conn, $rowData['code']);
        $name = mysqli_real_escape_string($conn, $rowData['name']);
        $telNumber = mysqli_real_escape_string($conn, $rowData['telNumber']);

        if ($id == null){
        // Insert data into the database
        $sql = "INSERT INTO companies (code, name, telNumber) VALUES ('$code', '$name', '$telNumber')";
        if (mysqli_query($conn, $sql)) {
            // Success response
            echo json_encode(['success' => true]);
        } else {
            // Error response
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
        }
        else{
            $updateQuery = "UPDATE companies SET code = '$code' , name ='$name', telNumber = '$telNumber' WHERE id = '$id' ";

            if (mysqli_query($conn,$updateQuery)){
                echo json_encode(['success'=> true]);
            }
            else{
                echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
            }
        }

     
    }
} else {
    // If the request method is not POST
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
