<?php
// Database connection details
include '../connection.php';

// Get the data from the JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Prepare the SQL query
$sql = "INSERT INTO order_forcast (
    mediName, 
    rep, 
    expire, 
    orderQt, 
    pSize, 
    pQt, 
    tItems, 
    iPrice, 
    pPrice, 
    rPrice, 
    sPercentage, 
    bBonus, 
    bbPercentage, 
    mrBonus, 
    mrbPercentage, 
    trItems, 
    cpItem, 
    fProfit, 
    order_month
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)";

$stmt = $conn->prepare($sql);

foreach ($data as $row) {
    // Ensure the 'expire' field is not empty
    $expire = !empty($row['ex']) ? $row['ex'] : '01/01';

    // Bind the parameters for each row
    $stmt->bind_param(
        "sssiiiiiddddiiiiids",
        $row['mediName'],
        $row['mrn'],
        $expire,
        $row['tc'],
        $row['pSize'],
        $row['pQT'],
        $row['totalI'],
        $row['pricePI'],
        $row['pricePP'],
        $row['retailerP'],
        $row['cBonus'],
        $row['bBonus'],
        $row['bBP'],
        $row['mrBonus'],
        $row['mrBP'],
        $row['totalRI'],
        $row['costPI'],
        $row['profit'],
        $row['date']
    );

    // Execute the query for each row
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
        exit;
    }
}

echo "Data inserted successfully";

// Close the connection
$stmt->close();
$conn->close();
?>