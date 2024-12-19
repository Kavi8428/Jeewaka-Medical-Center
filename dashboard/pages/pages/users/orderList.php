


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








<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../../assets/img/favicon.png">
  <title>
    ORDER LIST
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.19/jspdf.plugin.autotable.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- Include jsPDF and html2canvas -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hyperformula/dist/hyperformula.full.min.js"></script>
  
  <style>
    /* CSS for the modal content */
.modal-content {
    width: 80%; /* Adjust the width as needed */
    max-width: 600px; /* Set a maximum width if desired */
    margin: 0 auto; /* Center the modal content horizontally */
}

/* CSS for the input fields within the modal rows */
#userRows .form-control {
    width: 100%; /* Make the input fields fill the entire width of their container */
}
.bordered-input {
        border: 1px solid #ced4da; /* Bootstrap's default input border color */
        border-radius: 0.25rem; /* Bootstrap's default border radius */
    }
th{
  font-size: smaller;
  text-align: center;
}
input{
  font-size: smaller;
  text-align: center;
}
  </style>
</head>

<body >

    <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        
          <h5>ORDER DETAILS</h5>
      
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
         
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

        <a class="navbar-brand " href="./grn.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
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
            <a href="../../../../index.php" class="nav-link text-body p-0" data-toggle="tooltip" data-placement="top" title="Log Out" >
           LOG OUT <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="py-4">
        <div id ="hot"></div>
    </div>

 <!-- Your HTML code remains unchanged -->
                <!-- First, load jQuery -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
                <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/hyperformula/dist/hyperformula.full.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
                <!-- Your script using Select2 -->
                <script>
    function getOrderMonthFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('order_month');
    }

    // Fetch the data
    fetch('../../../../attributes/fetchOrders.php')
        .then(response => response.json())
        .then(data => {
            console.log('Raw data:', data);

            // Get the order_month from the URL
            const urlOrderMonth = getOrderMonthFromUrl();
            console.log('Order month from URL:', urlOrderMonth);

            if (urlOrderMonth) {
                // Filter the data based on the order_month
                const filteredData = data.filter(order => order.order_month.startsWith(urlOrderMonth));
                
                // Log the filtered data
                console.log('Filtered data:', filteredData);
                
                // Populate Handsontable with the filtered data
                populateHandsonTable(filteredData);
            } else {
                console.log('No order_month specified in the URL');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

        function populateHandsonTable(data) {
    console.log('Raw data:', data);

    // Specify the fields to exclude
    const excludeFields = ['id', 'updated_at'];

    // Filter out the excluded fields from the headers and rows
    const filteredData = data.map(row => {
        const filteredRow = {};
        Object.keys(row).forEach(key => {
            if (!excludeFields.includes(key)) {
                filteredRow[key] = row[key];
            }
        });
        return filteredRow;
    });

    // Convert data to array format for Handsontable
    const headers = Object.keys(filteredData[0]);
    const rows = filteredData.map(Object.values);
    const columnLetters = headers.map((header, index) => String.fromCharCode(65 + index)); // A, B, C, ...

    const container = document.getElementById('hot');
    const hot = new Handsontable(container, {
        data: rows,
        rowHeaders: true,
        colHeaders: true,
        licenseKey: 'non-commercial-and-evaluation', // for non-commercial use
        nestedHeaders: [
            columnLetters, // A, B, C, ...
            headers        // Original headers
        ],
        contextMenu: true,
        formulas: {
            engine: HyperFormula
        },
        width: '100%',
        height: 500,
        stretchH: 'all',
        filters: true,
        manualColumnResize: true,
        manualRowResize: true,
        mergeCells: true,
        autoColumnSize: true,
        autoRowSize: true,
        cell: [
            {row: 1, col: 1, className: 'htCenter htMiddle'},
            {row: 2, col: 2, className: 'htRight htMiddle'},
        ],
        cells: function (row, col, prop) {
            const cellProperties = {};
            if (col > 0) {
                cellProperties.type = 'numeric';
                cellProperties.numericFormat = {
                    pattern: '0,0.00',
                    culture: 'en-US'
                };
            }
            return cellProperties;
        }
    });

    // Example: Add SUM formula (ensuring the cell reference is valid)
    if (rows.length > 5) {
        hot.setDataAtCell(5, 1, '=SUM(B2:B5)');
    }

    // Example: Freeze first column
    hot.updateSettings({
        fixedColumnsLeft: 1
    });

    // Example: Freeze first row
    hot.updateSettings({
        fixedRowsTop: 1
    });

    // Add custom cell renderer (optional)
    Handsontable.renderers.registerRenderer('customRenderer', function(hotInstance, TD, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        TD.style.backgroundColor = '#EEE';
        TD.style.color = '#333';
    });

    hot.updateSettings({
        cells: function (row, col) {
            const cellProperties = {};
            if (row === 0) {
                cellProperties.renderer = 'customRenderer';
            }
            return cellProperties;
        }
    });
// Fixing the download functionality
document.getElementById('download').addEventListener('click', function() {
    const exportData = [columnLetters, headers, ...rows];
    const ws = XLSX.utils.aoa_to_sheet(exportData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

    // Get the current date in YYYY-MM-DD format
    const currentDate = new Date().toISOString().split('T')[0];
    // Set the file name with the .xlsx extension
    const fileName = `Order List ${currentDate}.xlsx`;

    // Write the file
    XLSX.writeFile(wb, fileName);
});

}


//<button id="download" class="btn" >Download as Excel</button>

</script>


<div class="fixed-plugin">
    <a id="download" class="fixed-plugin-button bg-danger text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">download</i>
    </a>
    </div>

 
</body>

</html>