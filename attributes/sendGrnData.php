<?php
// Database connection
include '../connection.php';

// Retrieve general data from the POST request
$invoice = trim($_POST['invoice']);
$supplier = trim($_POST['supplier']);
$status = $_POST['status'];

// Insert general data into 'grn' table only once
$sql = "INSERT INTO grn (ivNumber, company, status) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $invoice, $supplier, $status);

if ($stmt->execute() === FALSE) {
    echo "Error inserting into grn table: " . $conn->error;
} else {
    echo "Data inserted into grn table successfully.<br>";
}

// Get the last inserted ID (GRN ID)
$grnID = $conn->insert_id;
echo "Last inserted GRN ID: $grnID<br>";

// Retrieve and process row-specific data from the POST request
$jsonData = $_POST['formDataArray'];
$formDataArray = json_decode($jsonData, true);

// Debug: Print the decoded JSON data
echo "Decoded formDataArray:<br>";
print_r($formDataArray);
echo "<br>";

// Prepare the SQL query for inserting into grnproducts table
$sql2 = "INSERT INTO grnproducts (grnNo, name, generic, mediRep, expiryDate, tc, pSize, pQt, totalItems, pricePI, pricePP, retailP, sp, billBonus, bBP, mrBonus, mrBP, totalRI, costPI, profit) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql2);

// Loop through each row data and insert into the database
foreach ($formDataArray as $rowData) {
    $name = trim($rowData['name']);
    $generic = trim($rowData['generic']);
    $mrn = trim($rowData['mrn']);
    $expiryDate = trim($rowData['ex']);
    $tc = trim($rowData['tc']);
    $pSize = trim($rowData['pSize']);
    $pQt = trim($rowData['pQT']);
    $totalI = trim($rowData['totalI']);
    $pricePI = trim($rowData['pricePI']);
    $pricePP = trim($rowData['pricePP']);
    $retailerP = trim($rowData['retailerP']);
    $sp = trim($rowData['sp']);
    $bBonus = floatval(trim($rowData['bBonus']));
    $bBP = trim($rowData['bBP']);
    $mrBonus = floatval(trim($rowData['mrBonus']));
    $mrBP = trim($rowData['mrBP']);
    $totalRI = trim($rowData['totalRI']);
    $costPI = trim($rowData['costPI']);
    $profit = trim($rowData['profit']);

    // Bind parameters and execute the statement
    $stmt2->bind_param('isssssiiiidddddddddd', $grnID, $name, $generic, $mrn, $expiryDate, $tc, $pSize, $pQt, $totalI, $pricePI, $pricePP, $retailerP, $sp, $bBonus, $bBP, $mrBonus, $mrBP, $totalRI, $costPI, $profit);

    // Debug: Print the SQL query being executed
    echo "Executing SQL for $name: $sql2<br>";

    if ($stmt2->execute() === FALSE) {
        echo "Error inserting into grnproducts table: " . $conn->error . "<br>";
    } else {
        echo "Data inserted into grnproducts table successfully for product: $name<br>";
    }
}

$stmt->close();
$stmt2->close();
$conn->close();
?>
