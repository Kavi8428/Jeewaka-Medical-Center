<?php
// Database connection
include '../connection.php';

// Retrieve general data from the POST request
//$mediRep = $_POST['mediRep'];
$invoice = $_POST['invoice'];
$supplier = $_POST['supplier'];
//$serial = $_POST['serial'];
$status = $_POST['status'];

// Retrieve the GRN ID from the POST request
$grnID = $_POST['grnId'];

// Update general data in the 'grn' table
$sql = "UPDATE grn SET ivNumber='$invoice', company='$supplier',status = '$status' WHERE id='$grnID'";
if ($conn->query($sql) === FALSE) {
    echo "Error updating general data: " . $conn->error;
}

// Retrieve and process row-specific data from the POST request
$jsonData = $_POST['formDataArray'];
$formDataArray = json_decode($jsonData, true);

// Loop through each row data and update or insert the corresponding record in the database
foreach ($formDataArray as $rowData) {
    $name = $rowData['name'];
    $generic = $rowData['generic'];
    $mrn = $rowData['mrn'];
    $expiryDate = $rowData['ex'];
    $tc = $rowData['tc'];
    $pSize = $rowData['pSize'];
    $pQt = $rowData['pQT'];
    $totalI = $rowData['totalI'];
    $pricePI = $rowData['pricePI'];
    $pricePP = $rowData['pricePP'];
    $retailerP = $rowData['retailerP'];
    $sp = $rowData['sp'] ;
    $bBonus = $rowData['bBonus'];
    $bBP = $rowData['bBP'];
    $mrBonus = $rowData['mrBonus'];
    $mrBP = $rowData['mrBP'];
    $totalRI = $rowData['totalRI'];
    $costPI = $rowData['costPI'];
    $profit = $rowData['profit'];

    // Check if the row with the same grnNo and name already exists
    $checkSql = "SELECT * FROM grnproducts WHERE grnNo='$grnID' AND name='$name' AND generic ='$generic'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
       
        // Update row-specific data in the 'grnproducts' table
        $sql2 = "UPDATE grnproducts SET mrBonus='$mrBonus', mrBP='$mrBP', totalRI='$totalRI', costPI='$costPI', profit='$profit' WHERE grnNo='$grnID' AND name='$name' AND generic = '$generic'";
        if ($conn->query($sql2) === FALSE) {
            echo "Error updating row-specific data: " . $conn->error;
        }

       //$sql3 = "UPDATE medicines SET  cost='$retailerP' WHERE id ='$grnID' AND name='$name'";
        

    } else {
        // Insert new row-specific data into the 'grnproducts' table
        $updatedTc = $tc;
        $updatedPricePI = $pricePI;
        $updatedPricePP = $pricePP;
        $updatedRetailerP = $retailerP;
        $updatedCostPI = $costPI;

        $sql2 = "INSERT INTO grnproducts (grnNo, name, generic, mediRep, expiryDate, tc, pSize, pQt, totalItems, pricePI, pricePP, retailP, sp, billBonus, bBP, mrBonus, mrBP, totalRI, costPI, profit) VALUES ('$grnID', '$generic', '$name', '$mrn', '$expiryDate', '$updatedTc', '$pSize', '$pQt', '$totalI', '$updatedPricePI', '$updatedPricePP', '$updatedRetailerP', '$sp', '$bBonus', '$bBP', '$mrBonus', '$mrBP', '$totalRI', '$updatedCostPI', '$profit')";
        if ($conn->query($sql2) === FALSE) {
            echo "Error inserting new row-specific data: " . $conn->error;
        }
    }
}

$conn->close();
?>

?>
