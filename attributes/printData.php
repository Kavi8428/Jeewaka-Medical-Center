<?php
header('Content-Type: application/json; charset=utf-8');

// Disable error display in the response
ini_set('display_errors', 0);

// Receive the JSON data from the POST request
$jsonData = file_get_contents('php://input');
error_log('Received JSON: ' . $jsonData);

// Decode the JSON data into a PHP array
$dataToPrint = json_decode($jsonData, true);

// Initialize $textContent
$textContent = '';

if (!empty($dataToPrint)) {
    // Proceed with the foreach loop
    foreach ($dataToPrint as $item) {
        $textContent .= $item['name'] . "\r\n" . $item['address'] . "\r\n" . $item['dob'] . "\r\n----------------\r\n";
    }
} else {
    // Handle the case where no data was received
    $response = ['result' => 'No data to print'];
}

// Open printer connection
$fp = fopen("LPT1", "w");  // Replace LPT1 with your printer's port

// (Optional) Send printer-specific commands (check your printer's documentation)
fwrite($fp, chr(27) . chr(64));  // Select character set (if needed)

// Send text data to printer
fwrite($fp, $textContent);

// Close printer connection
fclose($fp);

// Set the response for the JavaScript function
if (!isset($response)) {
    $response = ['result' => 'Printed successfully'];
}

// Log any PHP errors or warnings
if ($error = error_get_last()) {
    error_log('PHP Error: ' . print_r($error, true));
}


// Send a single JSON response to the JavaScript function
echo json_encode($response);
?>
