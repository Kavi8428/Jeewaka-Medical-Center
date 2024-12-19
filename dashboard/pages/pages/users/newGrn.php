<?php
session_start();

// Include connection file
require_once '../../../../connection.php';

// Check if user_id is set in session
if (isset($_SESSION["user_id"])) {


    // Get the user ID from the session
    $user_id = $_SESSION["user_id"];

    // Prepare SQL query
    $sql = "SELECT fullName FROM system_user WHERE id = ?";

    // Prepare and execute statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if data is found
    if ($row = $result->fetch_assoc()) {
        // Extract and display full name
        $fullName = $row["fullName"];
    } else {
        // User not found, display error message
        echo "Error: User information not found.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // User not logged in, redirect to login page
    header("Location: ../../../../index.php");
    exit();
}
?>

<?php
$grnId;
// Check if the 'grnId' parameter is set in the URL
if (isset($_GET['grnId'])) {
    // Get the value of the 'grnId' parameter
    $grnId = 'hidden';
    // Echo the value
    //echo "The GRN ID is: " . htmlspecialchars($grnId);
} else {
    // If 'grnId' is not set, display an error message
    // echo "GRN ID is not set in the URL.";
    $grnId = 'enabled';
}
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../assets/img/favicon.png">
    <title>
        NEW GRN
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../../../assets/css/material-dashboard.css?v=3.0.6" rel="stylesheet" />
    <style>
        /* CSS for the modal content */
        .modal-content {
            width: 80%;
            /* Adjust the width as needed */
            max-width: 600px;
            /* Set a maximum width if desired */
            margin: 0 auto;
            /* Center the modal content horizontally */
        }

        /* CSS for the input fields within the modal rows */
        #userRows .form-control {
            width: 100%;
            /* Make the input fields fill the entire width of their container */
        }

        .bordered-input {
            border: 1px solid #ced4da;
            /* Bootstrap's default input border color */
            border-radius: 0.25rem;
            /* Bootstrap's default border radius */
        }

        th {
            font-size: smaller;
            text-align: center;
        }

        input {
            font-size: smaller;
            text-align: center;
        }
    </style>
</head>

<body class="  bg-gray-200">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg position-sticky px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
            <div class="container-fluid px-3">
                <h2 class="ms-4">GRN</h2>
                <div class="collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4" id="navbar">
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <a class="navbar-brand active" href="./grn.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
                    target="_blank">
                    GRN LIST
                </a>
                <a class="navbar-brand" href="./items.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
                    target="_blank">
                    ITEMS
                </a>
                <a class="navbar-brand" href="./companies.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
                    target="_blank">
                    COMPANIES
                </a>
                <a class="navbar-brand" href="./reportGenerator.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
                    target="_blank">
                    REPORTS
                </a>

                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item px-3">
                        <a href="../../../../index.php" class="nav-link text-body p-0" data-toggle="tooltip" data-placement="top" title="Log Out">
                            LOG OUT <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card  ">
                        <!-- Card header -->
                        <div class="card-header pb-0">
                            <div class="row border-1">
                                <div class="col-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control bordered-input" id="serial" placeholder="Serial Number">
                                        <label for="serial"> Serial Number </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control bordered-input" id="invoice" placeholder="Invoice Number">
                                        <label for="invoice">Invoice Number</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating">
                                        <select class="form-select bg-transparent bordered-input" id="supplier" name="supplier"
                                            aria-label="Floating label select example">
                                            <option selected>Company</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control bordered-input" id="date" placeholder="Date">
                                        <label for="date">Date</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control bg-danger-soft bordered-input" id="grnTotal" placeholder="TOTAL" readonly>
                                        <label for="invoice">Total</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="container-fluid ">
                                <table style="font-size: smaller;" class=" table-bordered text-sm">
                                    <thead>
                                        <tr>
                                            <th style="width:22%;">Name</th>
                                            <th style="width:5%; font-size:smaller;">MRN</th>
                                            <th style="width:5%">Ex</th>
                                            <th style="width:7%">TC</th>
                                            <th>PS</th>
                                            <th>PQ</th>
                                            <th>TI</th>
                                            <th>IP</th>
                                            <th>PP</th>
                                            <th>RP</th>
                                            <th style="width:4%">SP%</th>
                                            <th>BB</th>
                                            <th style="width:4%">BB%</th>
                                            <th>MRB</th>
                                            <th style="width:4%">MRB%</th>
                                            <th>TRI</th>
                                            <th>CPI</th>
                                            <th style="width:4%">FP%</th>
                                            <th style="width:2%">A</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataRows">
                                        <tr>
                                            <td>
                                                <select class=" text-sm" name="mediName" id="mediName_0">
                                                    <option>Please fill Requiered Fields to see Items</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="mrn_0" id="mrn_0" class="form-control h-25 border-0 text-sm " readonly>
                                                <input type="text" name="mrnB_0" id="mrnB_0" class="h-25 w-100 border-0">
                                            </td>
                                            <td><input type="text" name="ex_0" id="ex_0" class="form-control h-25 border-0" maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY" oninput="formatDate(this)"></td>
                                            <td><input type="text" name="tc_0" id="tc_0" class="form-control h-25 border-0"></td>
                                            <td><input type="text" name="pSize_0" id="pSize_0" class="form-control h-25 border-0"></td>
                                            <td><input type="text" name="pQT_0" id="pQT_0" class="form-control h-25 border-0"></td>
                                            <td><input type="text" name="totalI_0" id="totalI_0" class="form-control h-25 border-0" readonly></td>
                                            <td><input type="text" name="pricePI_0" id="pricePI_0" class="form-control h-25 border-0" readonly></td>
                                            <td><input type="text" name="pricePP_0" id="pricePP_0" class="form-control h-25 border-0" readonly></td>
                                            <td><input type="text" name="retailerP_0" id="retailerP_0" class="form-control h-25 border-0"></td>
                                            <td><input type="text" name="cBonus_0" id="cBonus_0" class="form-control h-25 border-0"></td> <!--This would be use to sell percentage-->
                                            <td><input type="text" name="bBonus_0" id="bBonus_0" class="form-control h-25 border-0"></td>
                                            <td><input type="text" name="bBP_0" id="bBP_0" class="form-control h-25 border-0" readonly></td>
                                            <td><input type="number" name="mrBonus_0" id="mrBonus_0" class="form-control h-25 border-0"></td>
                                            <td><input type="text" name="mrBP_0" id="mrBP_0" class="form-control h-25 border-0" readonly></td>
                                            <td><input type="text" name="totalRI_0" id="totalRI_0" class="form-control h-25 border-0" readonly></td>
                                            <td><input type="text" name="costPI_0" id="costPI_0" class="form-control h-25 border-0" readonly></td>
                                            <td><input type="text" name="profit_0" id="profit_0" class="form-control h-25 border-0" readonly></td>
                                            <td><button type="button" name="removeRow" id="removeRow_0" class="form-control btn h-25 border-0"> </button></td>
                                            <script>
                                                function formatDate(input) {
                                                    // Get the input value as a string
                                                    const inputValue = input.value.toString();

                                                    // Check if the input value has exactly 4 digits
                                                    if (inputValue.length !== 4) {

                                                        return;
                                                    }

                                                    // Extract the month and year from the input value
                                                    const monthFromInput = parseInt(inputValue.substring(0, 2));
                                                    const yearFromInput = parseInt(inputValue.substring(2));

                                                    // Validate the month
                                                    if (monthFromInput < 1 || monthFromInput > 12) {
                                                        alert('Invalid month....! Enter Valid Month First');
                                                        input.value = ''; // Clear the input value    return;
                                                        return
                                                    }

                                                    // Get the current year
                                                    const currentYear = new Date().getFullYear();
                                                    const currentYearLastTwoDigits = currentYear.toString().substring(2);

                                                    // Validate the year
                                                    if (yearFromInput > currentYearLastTwoDigits) {
                                                        // If the input year is greater than the current year, assume it's a future year
                                                        const fullYear = '20' + yearFromInput;
                                                        input.value = `${monthFromInput.toString().padStart(2, '0')}/${fullYear.toString().substring(2)}`;
                                                    } else {
                                                        alert('Invalid year');
                                                        input.value = ''; // Clear the input value
                                                        return;
                                                    }
                                                }
                                            </script>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-end">
                                    <div class="btn-group dropup">
                                        <button type="button" id="save" class="btn bg-gradient-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            SAVE
                                        </button>
                                        <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item border-radius-md" id="completeWithoutMrBonus" href="javascript:;" onclick="status('pending')">COMPLETE WITHOUT MR BONUS</a></li>
                                            <li><a class="dropdown-item border-radius-md" id="completeWithMrBonus" href="javascript:;" onclick="status('approved')">COMPLETE WITH MR BONUS</a></li>
                                            <li><a class="dropdown-item border-radius-md" id="addMrBonusToStock" href="javascript:;" onclick="status('addMrToStock')">ADD MR BONUS TO STOCK</a></li>
                                            <li><a class="dropdown-item border-radius-md" id="markAsPaymentDone" href="javascript:;" onclick="paymentDone()">MARK AS PAYMENT DONE</a></li>
                                        </ul>
                                    </div>
                                    <!--<button class="btn btn-info" onclick="status('approved')">Approved & Save</button>-->
                                    <button class="btn btn-primary" id="addRow" onclick="addRow()" <?php echo  $grnId; ?>>ADD ROW</button>
                                    <!-- <button class="btn btn-success" onclick="submitData()" >PAYMENT DONE</button> -->
                                </div>
                            </div>
                            <!-- Your HTML code remains unchanged -->
                            <!-- First, load jQuery -->
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
                            <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

                            <!--   Core JS Files   -->
                            <script src="../../../assets/js/core/popper.min.js"></script>
                            <script src="../../../assets/js/core/bootstrap.min.js"></script>
                            <!-- Your script using Select2 -->
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    // Parse the URL to extract the query parameters
                                    const queryParams = new URLSearchParams(window.location.search);
                                    const grnId = queryParams.get('grnId');

                                    if (grnId) {
                                        // Do something with the GRN ID, such as displaying it on the page
                                        //console.log("GRN ID:", grnId);
                                    }
                                });
                                document.addEventListener("DOMContentLoaded", function() {
                                    // Parse the URL to extract the query parameters
                                    const queryParams = new URLSearchParams(window.location.search);
                                    const grnId = queryParams.get('grnId');

                                    if (grnId) {
                                        document.getElementById("completeWithMrBonus").hidden = true;
                                        document.getElementById("completeWithoutMrBonus").hidden = true;
                                        // Fetch data from PHP script for GRN data
                                        fetch("../../../../attributes/fetchGrnData.php")
                                            .then(response => {
                                                if (!response.ok) {
                                                    throw new Error('Network response was not ok');
                                                }
                                                return response.json();
                                            })
                                            .then(grnData => {
                                                // Filter the GRN data to get only the rows with the matching GRN ID
                                                const filteredGrnData = grnData.filter(row => row.id === grnId);

                                                fetch("../../../../attributes/fetchGrnProducts.php")
                                                    .then(response => {
                                                        if (!response.ok) {
                                                            throw new Error('Network response was not ok');
                                                        }
                                                        return response.json();
                                                    })
                                                    .then(grnProduct => {
                                                        // Filter the GRN data to get only the rows with the matching GRN ID
                                                        const filteredGrnProduct = grnProduct.filter(row => row.grnNo === grnId);
                                                        //console.log('filteredGrnProduct',filteredGrnProduct);

                                                        if (filteredGrnProduct.length > 0) {
                                                            // Access the first matched row
                                                            const rowProduct = filteredGrnProduct[0];

                                                            const mrBonusValue = rowProduct.mrBonus;
                                                            //console.log('rowData',rowProduct);

                                                            if (mrBonusValue > 0) {

                                                                // document.getElementById("addMrBonusToStock").hidden = true;

                                                            }
                                                        }
                                                    });
                                                // Check if any data matches the GRN ID
                                                if (filteredGrnData.length > 0) {
                                                    // Access the first matched row
                                                    const rowData = filteredGrnData[0];
                                                    // Set values to input fields
                                                    //document.getElementById("mediRep").value = rowData.mediRep;
                                                    document.getElementById("invoice").value = rowData.ivNumber;
                                                    document.getElementById("serial").value = rowData.id;

                                                    var grnDate = new Date(rowData.created_at);

                                                    // Get day, month, and year
                                                    var day = grnDate.getDate();
                                                    var month = grnDate.getMonth() + 1; // Months are zero-based, so add 1
                                                    var year = grnDate.getFullYear();

                                                    // Add leading zeros to day and month if needed
                                                    if (day < 10) {
                                                        day = '0' + day;
                                                    }
                                                    if (month < 10) {
                                                        month = '0' + month;
                                                    }

                                                    // Format as "yyyy-mm-dd"
                                                    var formattedDate = `${year}-${month}-${day}`;

                                                    // Assuming you have an input element with the ID "date"
                                                    document.getElementById("date").value = formattedDate;
                                                    // console.log('formattedDate', formattedDate);


                                                    const status = rowData.status;
                                                    const mrBonusValue = rowData.mrBonus;
                                                    const payment = rowData.payment;
                                                    //console.log('payment',payment);
                                                    if (status == 'approved' || status == 'addMrToStock') {
                                                        document.getElementById("completeWithMrBonus").hidden = true;
                                                        document.getElementById("completeWithoutMrBonus").hidden = true;
                                                        document.getElementById("addMrBonusToStock").hidden = true;
                                                    } else {
                                                        document.getElementById("completeWithMrBonus").hidden = true;
                                                        document.getElementById("completeWithoutMrBonus").hidden = true;
                                                        document.getElementById("addMrBonusToStock").hidden = false;
                                                    }
                                                    if (payment == 'done') {
                                                        document.getElementById("markAsPaymentDone").hidden = true;
                                                    }
                                                    // Fetch data from server for company data
                                                    fetch('../../../../attributes/fetchCompanies.php')
                                                        .then(response => {
                                                            if (!response.ok) {
                                                                throw new Error('Network response was not ok');
                                                            }
                                                            return response.json();
                                                        })
                                                        .then(companyData => {
                                                            // Initialize dropdown for company selection
                                                            const select = document.getElementById('supplier');

                                                            // Format company data for Choices.js
                                                            const formattedData = companyData.map(item => ({
                                                                value: item.code,
                                                                label: item.code
                                                            }));

                                                            // Initialize Choices.js with the fetched data
                                                            const choices = new Choices(select, {
                                                                placeholder: true,
                                                                searchEnabled: true,
                                                                searchChoices: true,
                                                                removeItemButton: true,
                                                                choices: formattedData // Pass the formatted data to Choices.js
                                                            });

                                                            // Preselect the company in the dropdown
                                                            choices.setChoiceByValue(rowData.company);
                                                        })
                                                        .catch(error => {
                                                            console.error('Error fetching company data:', error);
                                                        });
                                                } else {
                                                    console.log("No data found for the provided GRN ID");
                                                }
                                            })
                                            .catch(error => {
                                                console.error("Error fetching GRN data:", error);
                                            });
                                    } else {
                                        document.getElementById("addMrBonusToStock").hidden = true;

                                        var xhr = new XMLHttpRequest();
                                        // Configure it: GET-request for the URL of the PHP script
                                        xhr.open('GET', '../../../../attributes/fetchGrnData.php', true);

                                        // Set up the onload event handler
                                        xhr.onload = function() {
                                            if (xhr.status >= 200 && xhr.status < 300) {
                                                // Parse the JSON response
                                                var data = JSON.parse(xhr.responseText);

                                                // Log the entire data to the console
                                                //console.log('Fetched Data:', data);

                                                // Check if data is not empty
                                                if (data.length > 0) {
                                                    // Get the last item in the array
                                                    var lastItem = data[data.length - 1];
                                                    const lastId = lastItem.id;
                                                    const nextId = parseFloat(lastId) + 1;
                                                    // Log the ID of the last item
                                                    //console.log('Next ID:',nextId); // Assuming 'id' is the field name for the ID
                                                    document.getElementById('serial').value = nextId;
                                                } else {
                                                    alert('No data found');
                                                }
                                            } else {
                                                alert('Error fetching data:', xhr.statusText);
                                            }
                                        };

                                        // Set up the onerror event handler
                                        xhr.onerror = function() {
                                            alert('Request failed');
                                        };

                                        // Send the request
                                        xhr.send();
                                        //console.log('This is for new id area');

                                        fetch('../../../../attributes/fetchCompanies.php')
                                            .then(response => {
                                                if (!response.ok) {
                                                    throw new Error('Network response was not ok');
                                                }
                                                return response.json();
                                            })
                                            .then(companyData => {
                                                // Initialize dropdown for company selection
                                                const select = document.getElementById('supplier');

                                                // Format company data for Choices.js
                                                const formattedData = companyData.map(item => ({
                                                    value: item.code,
                                                    label: item.code
                                                }));

                                                // Initialize Choices.js with the fetched data
                                                const choices = new Choices(select, {
                                                    placeholder: true,
                                                    searchEnabled: true,
                                                    searchChoices: true,
                                                    removeItemButton: true,
                                                    choices: formattedData // Pass the formatted data to Choices.js
                                                });

                                                // Preselect the company in the dropdown
                                            })
                                            .catch(error => {
                                                alert('Error fetching company data:', error);
                                            });
                                    }
                                });

                                document.addEventListener("DOMContentLoaded", function() {
                                        // Parse the URL to extract the query parameters
                                        const queryParams = new URLSearchParams(window.location.search);
                                        const grnId = queryParams.get('grnId');

                                        if (grnId) {
                                            // Fetch data from PHP script
                                            fetch("../../../../attributes/fetchGrnProducts.php")
                                                .then(response => response.json())
                                                .then(data => {
                                                    //console.log("Fetch Products Data:", data);

                                                    // Filter the data to get only the rows with the matching GRN ID
                                                    const filteredData = data.filter(row => row.grnNo === grnId);

                                                    // Log the filtered data to the console
                                                    //console.log("Filtered Data:", filteredData);

                                                    // Get the table body element
                                                    const tableBody = document.getElementById("dataRows");

                                                    // Clear existing rows
                                                    tableBody.innerHTML = "";

                                                    // Iterate over each product in the filtered data
                                                    filteredData.forEach((product, index) => {
                                                        // Create a new table row
                                                        const newRow = document.createElement("tr");

                                                        const readonly = true; // Assuming you want it to be readonly
                                                        const readonlyAttribute = readonly ? 'readonly' : '';
                                                        //console.log('product.name',product.name);
                                                        //  console.log('product', product);

                                                        // Set the HTML content for the row
                                                        newRow.innerHTML = `
                                          <td>
                                              <select class="form-select form-select-sm" name="mediName" id="mediName_${index}" ${readonlyAttribute} readonly >
                                                  <option value='${product.name}-${product.generic}' >${product.name}-${product.generic}</option>
                                              </select>
                                          </td>                          
                                          <td><input type="text" name="mrn_${index}" id="mrn_${index}" class="form-control h-25 border-0" value="${product.mediRep}" ${readonlyAttribute}><input type="text" value="${product.billBonus+' '+product.mrBonus+' '+product.cBonus}" ${readonlyAttribute}  class="h-25 border-0"> </td>
                                          <td><input type="text" name="ex_${index}" id="ex_${index}" class="form-control h-25 border-0" value="${product.expiryDate}" ${readonlyAttribute} maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY"  oninput="formatDate(this)"></td>
                                          <td><input type="text" name="tc_${index}" id="tc_${index}" class="form-control  h-25 border-0" value="${product.tc}" ${readonlyAttribute} readonly></td>
                                          <td><input type="text" name="pSize_${index}" id="pSize_${index}" class="form-control h-25 border-0" value="${product.pSize}" ${readonlyAttribute} readonly></td>
                                          <td><input type="text" name="pQT_${index}" id="pQT_${index}" class="form-control h-25 border-0" value="${product.pQt}" readonly></td>
                                          <td><input type="text" name="totalI_${index}" id="totalI_${index}" class="form-control h-25 border-0" value="${product.totalItems} " readonly></td>
                                          <td><input type="text" name="pricePI_${index}" id="pricePI_${index}" class="form-control h-25 border-0" value="${product.pricePI}" readonly></td>
                                          <td><input type="text" name="pricePP_${index}" id="pricePP_${index}" class="form-control h-25 border-0" value="${product.pricePP}" readonly></td>
                                          <td><input type="text" name="retailerP_${index}" id="retailerP_${index}" class="form-control bg-danger text-white text-bold h-25 border-0" value="${product.retailP}" readonly ></td>
                                          <td><input type="text" name="cBonus_${index}" id="cBonus_${index}" class="form-control  h-25 border-0" value="${product.sp}" ${readonlyAttribute}></td> <!--This would be use to sell percentage-->
                                          <td><input type="text" name="bBonus_${index}" id="bBonus_${index}" class="form-control h-25 border-0" value="${product.billBonus}" ${readonlyAttribute}></td>
                                          <td><input type="text" name="bBP_${index}" id="bBP_${index}" class="form-control h-25 border-0" value="${product.bBP}" readonly></td>
                                          <td><input type="number" name="mrBonus_${index}" id="mrBonus_${index}" class="form-control bg-info text-light text-bolder  h-25 border-0" value="${product.mrBonus}"></td>
                                          <td><input type="text" name="mrBP_${index}" id="mrBP_${index}" class="form-control h-25 border-0" value="${product.mrBP}" readonly></td>
                                          <td><input type="text" name="totalRI_${index}" id="totalRI_${index}" class="form-control h-25 border-0" value="${product.totalRI}" readonly></td>
                                          <td><input type="text" name="costPI_${index}" id="costPI_${index}" class="form-control h-25 border-0" value="${product.costPI}" readonly></td>
                                          <td><input type="text" name="profit_${index}" id="profit_${index}" class="form-control h-25 border-0" value="${product.profit}" readonly></td>
                                          <td><button type="button" name="removeRow_${index}" id="removeRow_${index}"> <i class=" fa fa-trash " ></i> </button></td>

                                      `;


                                                        // Append the new row to the table body
                                                        tableBody.appendChild(newRow);

                                                        // Call addInputEventListeners for the newly added row
                                                        mrbEventListener(index);
                                                        updateTotal();


                                                        // Get the newly added select element
                                                        const select = document.getElementById(`mediName_${index}`);

                                                        // Fetch data from server for the new dropdown
                                                        fetch('../../../../attributes/fetchMedi4Grn.php')
                                                            .then(response => {
                                                                if (!response.ok) {
                                                                    throw new Error('Network response was not ok');
                                                                }
                                                                return response.json();
                                                            })
                                                            .then(data => {

                                                                // Format data for Choices.js
                                                                const formattedData = data.map(item => ({
                                                                    value: item.name + '-' + item.mediName,
                                                                    label: item.name + '-' + item.mediName,
                                                                    selected: (item.name + '-' + item.mediName === `${product.name}-${product.generic}`) // Pre-select if matches product
                                                                }));

                                                                // Initialize Choices.js with the fetched data for the new dropdown
                                                                const choices = new Choices(select, {
                                                                    placeholder: true,
                                                                    searchEnabled: true,
                                                                    searchChoices: true,
                                                                    removeItemButton: true,
                                                                    choices: formattedData // Pass the formatted data to Choices.js
                                                                });
                                                                select.disabled = true;
                                                            })
                                                            .catch(error => {
                                                                console.error('There was a problem with the fetch operation:', error);
                                                            });
                                                        checkFields();

                                                    });
                                                })
                                                .catch(error => console.error("Error fetching data:", error));
                                        }
                                    }

                                );

                                function status(status) {
                                    // Gather general data
                                    //const mediRep = document.getElementById('mediRep').value;
                                    const invoice = document.getElementById('invoice').value;
                                    const supplier = document.getElementById('supplier').value;
                                    //const serial = document.getElementById('serial').value;
                                    if (!invoice.trim() || !supplier.trim()) {
                                        alert('Please fill in both Invoice and Supplier fields.');
                                        return; // Exit the function if any input is empty
                                    }
                                    const queryParams = new URLSearchParams(window.location.search);

                                    // Array to store data for all rows
                                    const formDataArray = [];
                                    const mediDataArray = [];

                                    // Gather data for existing rows
                                    const rows = document.querySelectorAll('#dataRows tr');
                                    rows.forEach((row, index) => {
                                        const mediNameValue = document.getElementById(`mediName_${index}`).value;
                                        // console.log('mediNameValue',mediNameValue)
                                        // Split the mediName value into name and mediName based on the hyphen "-"
                                        const [name, generic] = mediNameValue.split('-').map(part => part.trim());
                                        //console.log('oldName',name);
                                        //console.log('oldGeneric',generic);

                                        const rowData = {
                                            grnId: queryParams.get('grnId'),
                                            name: name,
                                            generic: generic,
                                            mrn: document.getElementById(`mrn_${index}`).value,
                                            ex: document.getElementById(`ex_${index}`).value,
                                            tc: document.getElementById(`tc_${index}`).value,
                                            pSize: document.getElementById(`pSize_${index}`).value,
                                            pQT: document.getElementById(`pQT_${index}`).value,
                                            totalI: document.getElementById(`totalI_${index}`).value,
                                            pricePI: document.getElementById(`pricePI_${index}`).value,
                                            pricePP: document.getElementById(`pricePP_${index}`).value,
                                            retailerP: document.getElementById(`retailerP_${index}`).value,
                                            sp: document.getElementById(`cBonus_${index}`).value,
                                            bBonus: document.getElementById(`bBonus_${index}`).value,
                                            bBP: document.getElementById(`bBP_${index}`).value,
                                            mrBonus: document.getElementById(`mrBonus_${index}`).value,
                                            mrBP: document.getElementById(`mrBP_${index}`).value,
                                            totalRI: document.getElementById(`totalRI_${index}`).value,
                                            costPI: document.getElementById(`costPI_${index}`).value,
                                            profit: document.getElementById(`profit_${index}`).value
                                        };
                                        mrBonus = document.getElementById(`mrBonus_${index}`).value;
                                        pQT = document.getElementById(`pQT_${index}`).value,
                                            totalMrBonus = mrBonus * pQT;
                                        console.log('totalMrBonus', totalMrBonus);
                                        total = document.getElementById(`totalRI_${index}`).value;
                                        console.log('total', total);
                                        tti = total - totalMrBonus;
                                        console.log('tti', tti);


                                        if (status == 'pending') {
                                            console.log('status', status);
                                            const mediData = {
                                                name: name,
                                                generic: generic,
                                                retailerP: document.getElementById(`retailerP_${index}`).value,
                                                totalRI: tti

                                            };
                                            mediDataArray.push(mediData);
                                        }
                                        if (status == 'approved') {
                                            console.log('status', status);
                                            const mediData = {
                                                name: name,
                                                generic: generic,
                                                retailerP: document.getElementById(`retailerP_${index}`).value,
                                                totalRI: document.getElementById(`totalRI_${index}`).value
                                            };
                                            mediDataArray.push(mediData);

                                        }
                                        if (status == 'addMrToStock') {
                                            //console.log('status',status);
                                            const mediData = {
                                                name: name,
                                                generic: generic,
                                                retailerP: document.getElementById(`retailerP_${index}`).value,
                                                totalRI: totalMrBonus
                                            };
                                            mediDataArray.push(mediData);

                                        }

                                        formDataArray.push(rowData);
                                    });

                                    if (status === 'addMrToStock' || status === 'approved') {
                                        const confirmation = confirm("Are you sure you want to add MR to stock?");
                                        if (!confirmation) {
                                            return; // Exit the function if the user clicks "Cancel"
                                        }
                                    }


                                    // Stringify the formDataArray
                                    const jsonData = JSON.stringify(formDataArray);
                                    const jsonData1 = JSON.stringify(mediDataArray);
                                    console.log('Data to be sent to medicines:', mediDataArray);
                                    console.log('Data to be sent to patients:', formDataArray);
                                    // Parse the URL to extract the query parameters
                                    const grnId = queryParams.get('grnId');

                                    // Determine the URL to which data will be submitted
                                    let url;
                                    let url1 = '../../../../attributes/updateMedicines.php';

                                    if (grnId) {
                                        url = '../../../../attributes/updateGrnData.php';
                                    } else {
                                        url = '../../../../attributes/sendGrnData.php';
                                    }

                                    //send data to updateMedicines.php

                                    $.ajax({
                                        type: 'POST',
                                        url: url1,
                                        data: {
                                            mediDataArray: jsonData1
                                        }, // Include general data, the JSON string of formDataArray, and the grnId parameter

                                        success: function(response) {
                                            if (response) {
                                                alert('Data updated in medicines.php successfully!');
                                                 console.log('Response from ',url1,' = ',  response);
                                               // location.replace("./grn.php");
                                            } else {
                                                alert('Empty response received from server.');
                                                console.log(response);
                                                console.log('Response from ',url1,' = ',  response);


                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error:', error);
                                            alert('Please contact developer');
                                        }
                                    });


                                    // Send data to PHP script using AJAX
                                    $.ajax({
                                        type: 'POST',
                                        url: url,
                                        data: {
                                            grnId: grnId, // Pass the grnId parameter
                                            //mediRep: mediRep,
                                            invoice: invoice,
                                            supplier: supplier,
                                            //serial: serial,
                                            status: status,
                                            formDataArray: jsonData
                                        }, // Include general data, the JSON string of formDataArray, and the grnId parameter

                                        success: function(response) {
                                            if (response) {
                                                alert('Data inserted successfully!');
                                                console.log(response);
                                                // console.log('Response from ',url,' = ',  response);

                                               // location.replace("./grn.php")
                                            } else {
                                                alert('Empty response received from server.');
                                                //console.log('Response from ',url,' = ',  response);

                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error:', error);
                                            alert('An error occurred . Please contact developer');

                                        }
                                    });
                                }

                                function showToast(message) {
                                    toast.textContent = message;
                                    toast.style.display = 'block';
                                    setTimeout(() => {
                                        toast.style.display = 'none';
                                    }, 3000);
                                }

                                function paymentDone() {
                                    // Gather general data
                                    //const mediRep = document.getElementById('mediRep').value;
                                    const invoice = document.getElementById('invoice').value;
                                    const supplier = document.getElementById('supplier').value;
                                    const serial = document.getElementById('serial').value;


                                    //console.log('supplier',supplier);
                                    // Parse the URL to extract the query parameters
                                    const queryParams = new URLSearchParams(window.location.search);
                                    const grnId = queryParams.get('grnId');

                                    // Determine the URL to which data will be submitted

                                    if (grnId) {
                                        // Send data to PHP script using AJAX
                                        url = '../../../../attributes/grnPaymentDone.php';

                                        $.ajax({
                                            type: 'POST',
                                            url: url,
                                            data: {
                                                grnId: grnId, // Pass the grnId parameter
                                                //mediRep: mediRep,
                                                invoice: invoice,
                                                supplier: supplier,
                                                //serial: serial,
                                            }, // Include general data, the JSON string of formDataArray, and the grnId parameter  
                                            success: function(response) {
                                                if (response) {
                                                    alert('Data inserted successfully!');
                                                    console.log(response);
                                                    location.replace("./grn.php")
                                                    showToast('Date range cannot exceed 3 days.');

                                                } else {
                                                    alert('Empty response received from server.');
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error:', error);
                                                alert('An error occurred while inserting data! Please contact kaveesh');
                                            }
                                        });
                                    } else {
                                        alert('Please add this GRN first. then make it payment done')
                                    }
                                }

                                // Disable select menu initially
                                document.getElementById('mediName_0').disabled = true;

                                // Add event listeners to input fields
                                document.getElementById('invoice').addEventListener('input', checkFields);
                                document.getElementById('supplier').addEventListener('input', checkFields);
                                document.getElementById('date').addEventListener('input', checkFields);
                                document.getElementById('addRow').disabled = true;
                                document.getElementById('save').disabled = true;


                                function checkFields() {
                                    const invoice = document.getElementById('invoice').value;
                                    const supplier = document.getElementById('supplier').value;
                                    const date = document.getElementById('date').value;

                                    // Check if all fields are filled
                                    if (invoice && supplier && date) {
                                        console.log('ALLOW');
                                        document.getElementById('addRow').disabled = false;
                                        document.getElementById('save').disabled = false;


                                        document.getElementById('mediName_0').disabled = false; // Enable select menu

                                        // Fetch data from server if select is enabled
                                        const select = document.getElementById('mediName_0');
                                        fetch('../../../../attributes/fetchMedi4Grn.php')
                                            .then(response => {
                                                if (!response.ok) {
                                                    throw new Error('Network response was not ok');
                                                }
                                                return response.json();
                                            })
                                            .then(data => {
                                                // Format data for Choices.js
                                                const formattedData = data.map(item => ({
                                                    value: item.name + '-' + item.mediName,
                                                    label: item.name + '-' + item.mediName
                                                }));

                                                // Initialize Choices.js with the fetched data
                                                const choices = new Choices(select, {
                                                    placeholder: true,
                                                    searchEnabled: true,
                                                    searchChoices: true,
                                                    removeItemButton: true,
                                                    choices: formattedData // Pass the formatted data to Choices.js
                                                });
                                            })
                                            .catch(error => {
                                                console.error('There was a problem with the fetch operation:', error);
                                            });
                                    } else {
                                        // console.log('DONT ALLOW');
                                        document.getElementById('mediName_0').disabled = true; // Keep select menu disabled
                                    }
                                }

                                // Function to update the total value of tc fields
                                function updateTotal() {
                                    const tcFields = document.querySelectorAll('[id^="tc_"]');
                                    let total = 0;

                                    tcFields.forEach(field => {
                                        const value = parseFloat(field.value) || 0;
                                        total += value;
                                    });

                                    document.getElementById('grnTotal').value = total;
                                }

                                // Function to add a new row
                                function addRow() {
                                    const rowCount = document.querySelectorAll('#dataRows tr').length;
                                    const newRow = `
        <tr id="row_${rowCount}">
            <td>
                <select class="form-select form-select-sm" name="mediName" id="mediName_${rowCount}" readonly>
                <option>Select</option>
                </select>
            </td>
            <td><input type="text" name="mrn_${rowCount}" id="mrn_${rowCount}" class="form-control h-25 border-0" maxlength="5"> <input type="text" id="mrnB_${rowCount}" class="h-25 border-0"> </td>
            <td><input type="text" name="ex_${rowCount}" id="ex_${rowCount}" class="form-control h-25 border-0" maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY" oninput="formatDate(this)"></td>
            <td><input type="text" name="tc_${rowCount}" id="tc_${rowCount}" class="form-control h-25 border-0"></td>
            <td><input type="text" name="pSize_${rowCount}" id="pSize_${rowCount}" class="form-control h-25 border-0"></td>
            <td><input type="text" name="pQT_${rowCount}" id="pQT_${rowCount}" class="form-control h-25 border-0"></td>
            <td><input type="text" name="totalI_${rowCount}" id="totalI_${rowCount}" class="form-control h-25 border-0" readonly></td>
            <td><input type="text" name="pricePI_${rowCount}" id="pricePI_${rowCount}" class="form-control h-25 border-0" readonly></td>
            <td><input type="text" name="pricePP_${rowCount}" id="pricePP_${rowCount}" class="form-control h-25 border-0" readonly></td>
            <td><input type="text" name="retailerP_${rowCount}" id="retailerP_${rowCount}" class="form-control h-25 border-0"></td>
            <td><input type="text" name="cBonus_${rowCount}" id="cBonus_${rowCount}" class="form-control h-25 border-0" ></td>
            <td><input type="text" name="bBonus_${rowCount}" id="bBonus_${rowCount}" class="form-control h-25 border-0"></td>
            <td><input type="text" name="bBP_${rowCount}" id="bBP_${rowCount}" class="form-control h-25 border-0" readonly></td>
            <td><input type="text" name="mrBonus_${rowCount}" id="mrBonus_${rowCount}" class="form-control h-25 border-0"></td>
            <td><input type="text" name="mrBP_${rowCount}" id="mrBP_${rowCount}" class="form-control h-25 border-0" readonly></td>
            <td><input type="text" name="totalRI_${rowCount}" id="totalRI_${rowCount}" class="form-control h-25 border-0" readonly></td>
            <td><input type="text" name="costPI_${rowCount}" id="costPI_${rowCount}" class="form-control h-25 border-0" readonly></td>
            <td><input type="text" name="profit_${rowCount}" id="profit_${rowCount}" class="form-control h-25 border-0" readonly></td>
            <td><button type="button" name="removeRow_${rowCount}" id="removeRow_${rowCount}" onclick="removeRow(${rowCount})"> <i class="fa fa-trash"></i> </button></td>
        </tr>
    `;

                                    // Insert the new row
                                    document.getElementById('dataRows').insertAdjacentHTML('beforeend', newRow);

                                    // Get the newly added select element
                                    const select = document.getElementById(`mediName_${rowCount}`);

                                    // Fetch data from server for the new dropdown
                                    fetch('../../../../attributes/fetchMedi4Grn.php')
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return response.json();
                                        })
                                        .then(data => {

                                            // Format data for Choices.js
                                            const formattedData = data.map(item => ({
                                                value: item.name + '-' + item.mediName,
                                                label: item.mediName + '-' + item.name
                                            }));

                                            // Initialize Choices.js with the fetched data for the new dropdown
                                            const choices = new Choices(select, {
                                                placeholder: true,
                                                searchEnabled: true,
                                                searchChoices: true,
                                                removeItemButton: true,
                                                choices: formattedData // Pass the formatted data to Choices.js
                                            });
                                        })
                                        .catch(error => {
                                            console.error('There was a problem with the fetch operation:', error);
                                        });

                                    // Add event listeners to the new row inputs
                                    addInputEventListeners(rowCount);

                                    // Add event listener to the tc field of the new row to update the total
                                    document.getElementById(`tc_${rowCount}`).addEventListener('input', updateTotal);

                                    // Update the total initially after adding the new row
                                    updateTotal();
                                }

                                // Function to add event listeners to input fields
                                function addInputEventListeners(rowCount) {
                                    // Add any necessary event listeners here
                                    // For example, adding an event listener to the tc field of the new row
                                    document.getElementById(`tc_${rowCount}`).addEventListener('input', updateTotal);
                                }

                                // Call updateTotal initially to set the total if there are pre-existing rows
                                document.addEventListener('DOMContentLoaded', (event) => {
                                    updateTotal();

                                });


                                function removeRow(rowId) {
                                    const row = document.getElementById(`row_${rowId}`);
                                    if (row) {
                                        row.remove();
                                    }
                                    updateTotal();

                                }


                                //////////////////////////////////////////////////////////




                                function mrbEventListener(rowCount) {
                                    const inputs = document.querySelectorAll(`#dataRows tr:nth-child(${rowCount + 1}) input`);

                                    // Add event listeners for input elements
                                    inputs.forEach((input, index) => {
                                        input.addEventListener('input', function() {
                                            const rowData = Array.from(inputs).map(input => input.value);
                                            nameT = rowData[0];
                                            mrnT = rowData[1];
                                            exT = rowData[2];
                                            tcT = rowData[3];
                                            psT = rowData[4];
                                            pqT = rowData[5];
                                            tiT = rowData[6];
                                            ipT = rowData[7];
                                            ppT = rowData[8];
                                            rpT = rowData[9];
                                            spT = rowData[10];
                                            bbT = rowData[11];
                                            bbpT = rowData[12];
                                            mrbT = rowData[13];
                                            mrbpT = rowData[14];
                                            triT = rowData[15];
                                            cpiT = rowData[16];
                                            fpT = rowData[17];



                                            const bbp = Number(bbT / Number(psT));
                                            // rowData[11] = bbp * 100;
                                            bbpt = bbp * 100;
                                            inputs[12].value = bbpt.toFixed(1);

                                            const mrbp = Number(mrbT / Number(pqT));
                                            //rowData[13] = mrbp * 100;
                                            inputs[14].value = mrbp * 100;

                                            const totalReceivedItems = ((Number(rowData[11]) + Number(rowData[13])) * Number(rowData[4])) + Number(rowData[4]) * Number(rowData[5]);
                                            rowData[15] = totalReceivedItems;
                                            inputs[15].value = totalReceivedItems;

                                            const cpi = Number(rowData[3]) / totalReceivedItems;
                                            rowData[16] = cpi;
                                            inputs[16].value = cpi.toFixed(2);

                                            const profit = ((Number(rowData[9]) - cpi) / cpi) * 100;
                                            rowData[17] = profit.toFixed(1); // Format profit with one decimal point
                                            inputs[17].value = profit.toFixed(1); // Assign formatted profit to the input field

                                            // console.log(`Row ${rowCount + 1} - Data: `, rowData);
                                        });
                                    });
                                }






                                //////////////////////////////////////////////////////////
                                function addInputEventListeners(rowCount) {
                                    let bb, mrb, cb;
                                    const select = document.getElementById(`mediName_${rowCount}`);
                                    const inputs = document.querySelectorAll(`#dataRows tr:nth-child(${rowCount + 1}) input`);

                                    // Add event listener for select element
                                    select.addEventListener('change', function() {
                                        const [name, generic] = select.value.split('-').map(part => part.trim());

                                        fetch('../../../../attributes/fetchMediRepItem.php')
                                            .then(response => {
                                                if (!response.ok) {
                                                    throw new Error('Network response was not ok');
                                                }
                                                return response.json();
                                            })
                                            .then(data => {
                                                const matchingData = data.filter(item => item.mediItem === name);
                                                if (matchingData.length > 0) {
                                                    const repCode = matchingData[0].repCode;

                                                    $(document).ready(function() {
                                                        $.ajax({
                                                            url: '../../../../attributes/fetchMedicalRep.php',
                                                            type: 'GET',
                                                            dataType: 'json',
                                                            success: function(response) {
                                                                const filteredData = response.filter(item => item.id === repCode);

                                                                $.ajax({
                                                                    url: '../../../../attributes/fetchMediRepItem.php',
                                                                    type: 'GET',
                                                                    dataType: 'json',
                                                                    success: function(response) {
                                                                        const filteredRepData = response.filter(repItem => repItem.repCode === repCode && repItem.mediItem == name);

                                                                        if (filteredRepData.length > 0) {
                                                                            bb = filteredRepData[0].bb;
                                                                            mrb = filteredRepData[0].mrBonus;
                                                                            cb = filteredRepData[0].cashBonus;

                                                                            if (filteredData.length > 0) {
                                                                                const code = filteredData[0].code;
                                                                                inputs[0].value = code;
                                                                                document.getElementById(`mrnB_${rowCount}`).value = '' + bb + '' + mrb + '' + cb;
                                                                            } else {
                                                                                console.log(`No matching data found for repCode ${repCode}`);
                                                                            }
                                                                        } else {
                                                                            console.log(`No matching data found for repCode ${repCode}`);
                                                                        }
                                                                    },
                                                                    error: function(xhr, status, error) {
                                                                        console.error(xhr.responseText);
                                                                    }
                                                                });
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.error(xhr.responseText);
                                                            }
                                                        });
                                                    });
                                                } else {
                                                    console.log('No matching data found');
                                                }
                                            })
                                            .catch(error => {
                                                console.error('There was a problem with the fetch operation:', error);
                                            });
                                    });

                                    // Add event listeners for input elements
                                    inputs.forEach((input, index) => {
                                        input.addEventListener('input', function() {
                                            const rowData = Array.from(inputs).map(input => input.value);

                                            // Calculate the product of values at indices 4 and 5 and assign to the 6th element
                                            const product = rowData[4] && rowData[5] ? rowData[4] * rowData[5] : '';
                                            rowData[6] = product;
                                            const sellP = (rowData[9] - rowData[7]) / rowData[7];
                                            const sellPercentage = sellP * 100;
                                            const askAround = Math.ceil(sellPercentage);
                                            inputs[10].value = askAround;

                                            if (index === 5) { // Check if it's the 5th input field
                                                inputs[6].value = product;
                                            }

                                            //  console.log(`Row ${rowCount + 2} - Data: `, rowData);

                                            const ppi = rowData[3] && rowData[6] ? rowData[3] / rowData[6] : '';
                                            rowData[7] = ppi;

                                            if (index === 5) { // Check if it's the 5th input field
                                                inputs[7].value = ppi.toFixed(2);
                                            }

                                            const ppp = rowData[3] && rowData[5] ? rowData[3] / rowData[5] : '';
                                            rowData[8] = ppp;

                                            if (index === 5) { // Check if it's the 5th input field
                                                inputs[8].value = ppp.toFixed(2);
                                            }

                                            const bbp = Number(rowData[11] / Number(rowData[5]));
                                            rowData[12] = bbp * 100;
                                            bbpt = bbp * 100
                                            inputs[12].value = bbpt.toFixed(2);

                                            const mrbp = Number(rowData[13] / Number(rowData[5]));
                                            rowData[14] = mrbp * 100;
                                            mrbpt = mrbp * 100
                                            inputs[14].value = mrbpt.toFixed(2);

                                            const totalReceivedItems = ((Number(rowData[11]) + Number(rowData[13])) * Number(rowData[4])) + Number(rowData[4]) * Number(rowData[5]);
                                            rowData[15] = totalReceivedItems;
                                            inputs[15].value = totalReceivedItems;

                                            const cpi = Number(rowData[3]) / totalReceivedItems;
                                            rowData[16] = cpi;
                                            inputs[16].value = cpi.toFixed(2);

                                            const profit = ((Number(rowData[9]) - cpi) / cpi) * 100;
                                            rowData[17] = profit.toFixed(1); // Format profit with one decimal point
                                            inputs[17].value = profit.toFixed(1); // Assign formatted profit to the input field

                                            // console.log(`Row ${rowCount + 1} - Data: `, rowData);
                                        });
                                    });
                                }

                                // Add event listeners to the inputs in the initial row
                                addInputEventListeners(0);
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <footer class="footer py-4 mt-7  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a class="font-weight-bold" target="_blank">Cryptech Solutions</a>
                            for a better web.
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </footer>
        </div>
    </main>

    </div>
    </div>



    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
</body>

</html>