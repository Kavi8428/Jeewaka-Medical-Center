<?php
include '../connection.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $postData = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($postData, true);

    // Check if data is not empty
    if (!empty($data)) {
        // Extract general data
        $generalData = $data['generalData'];
        $serial = $generalData[0]['serial'];
        $name = $generalData[0]['name'];
        $age = $generalData[0]['age'];
        $status = $generalData[0]['status'];
        $nurse = $generalData[0]['nurseCode'];

        // Initialize arrays to hold medication data
        $medicationItems = array();
        $morningValues = array();
        $noonValues = array();
        $eveningValues = array();
        $nightValues = array();
        $daysValues = array();
        $qtyValues = array();
        $costValues = array();
        $discount = array();
        $dPrice = array();

        // Extract medication data
        $medicationData = $data['medicationData'];
        foreach ($medicationData as $medication) {
            $medicationItems[] = $medication['name'];
            $morningValues[] = $medication['morning'];
            $noonValues[] = $medication['noon'];
            $eveningValues[] = $medication['evening'];
            $nightValues[] = $medication['night'];
            $daysValues[] = $medication['days'];
            $qtyValues[] = $medication['qty'];
            $costValues[] = $medication['cost'];
            $discount[] = $medication['discount'];
            $dPrice[] = $medication['dPrice'];
        }

        // Calculate total cost
        $totalCost = array_sum($dPrice);

        // Prepare the INSERT query for pharmacygeneraldata table
        $sqlGeneralData = "INSERT INTO pharmacygeneraldata (serial, total, status, name , age, nurse ) VALUES ('$serial', '$totalCost', '$status', '$name', '$age', '$nurse')";

        // Execute the INSERT query for pharmacygeneraldata table
        if ($conn->query($sqlGeneralData) !== TRUE) {
            // Send error response if insertion into pharmacygeneraldata fails
            echo json_encode(array('success' => false, 'message' => 'Error: ' . $conn->error));
            exit(); // Stop further execution
        }   

        $updateQuery = "UPDATE patient SET jd = '$totalCost', pharmacyNurse= '$nurse' WHERE serial = '$serial'";
        if ($conn->query($updateQuery) !== TRUE) {
            // Send error response if insertion into pharmacygeneraldata fails
            echo json_encode(array('success' => false, 'message' => 'Error: ' . $conn->error));
            exit(); // Stop further execution
        }

        // Prepare the INSERT query for pharmacy table
        $sqlPharmacy = "INSERT INTO pharmacy (serial, itemCode, morning, afternoon, evening, night, days, qty, cost, discount, dprice) VALUES ";
        $valueStrings = array();
        for ($i = 0; $i < count($medicationItems); $i++) {
            $valueStrings[] = "('$serial', '{$medicationItems[$i]}', '{$morningValues[$i]}', '{$noonValues[$i]}', '{$eveningValues[$i]}', '{$nightValues[$i]}', '{$daysValues[$i]}', '{$qtyValues[$i]}', '{$costValues[$i]}', '{$discount[$i]}',  '{$dPrice[$i]}')";
        }
        $sqlPharmacy .= implode(", ", $valueStrings);

        // Execute the INSERT query for pharmacy table
        if ($conn->query($sqlPharmacy) === TRUE) {
            // Send success response
            echo json_encode(array('success' => true, 'message' => 'Data saved successfully.'));
        } else {
            // Send error response if insertion into pharmacy fails
            echo json_encode(array('success' => false, 'message' => 'Error: ' . $conn->error));
        }

        // Close connection
        $conn->close();
    } else {
        // Send error response if data is empty
        echo json_encode(array('success' => false, 'message' => 'No data received.'));
    }
} else {
    // Send error response if request method is not POST
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}
?>
