


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
    ORDER FORCAST
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

<body class="g-sidenav-show  bg-gray-200">

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        
          <h5>ORDER FORCAST</h5>
      
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
        <select  id="search" class="w-25 me-2 m-2 border-1 border-radius-2xl " placeholder="Search 2024-july"> </select>

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
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card  ">
                    <!-- Card header -->
                  <div class="card-header pb-0">
                    <div class="row">
                      <div class="col-2">
                        <label>ORDER MONTH : </label>
                      </div>
                      <div class="col-3">
                      <input type="month" name="month" id="month"  maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY" >
                      </div>
                      <div class="col-3 text-end">
                      <h4 class="mt-2 " >TOTAL ORDER COST = </h4>
                      </div>
                      <div class="col-1">
                      <input type="text" class="border-0 text-start text-2xl mt-2 " id="toc-input" readonly>
                      </div>
                      <div class="col-2 text-end">
                      <button type="button" class="btn btn-outline-info me-3 " onclick="download()">DOWNLOAD</button>
                      </div>
                    </div>
                  </div>
                <div class="card-body px-0 pb-0">
                <div class="container-fluid">
                    <table id="tableData" class=" table-responsive-sm table-bordered mt-4">
                      <thead>
                        <tr >
                          <th style="width:18%">Name</th>
                          <th style="width:4%">MRN</th>
                          <th style="width:5%">EX</th>
                          <th style="width:7%" >OQ</th>
                          <th >PS</th>
                          <th >PQ</th>
                          <th >TI</th>
                          <th >IP</th>
                          <th >PP</th>
                          <th >RP</th>
                          <th style="width:4%">SP%</th>
                          <th >BB</th>
                          <th style="width:4%">BB%</th>
                          <th >MRB</th>
                          <th style="width:4%" >MRB%</th>
                          <th >TRI</th>
                          <th >CPI</th>
                          <th style="width:4%" >P</th>
                          <th style="width:2%"  >A</th>
                        </tr>
                      </thead>
                      <tbody id="dataRows">
                        <tr>
                          <td>
                          <select class=" form-select form-select-sm" name="mediName" id="mediName_0" >  
                          <option>Select</option>
                          </select>
                          </td>
                          <td><input type="text" name="mrn_0" id="mrn_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="ex_0" id="ex_0" class="form-control h-25 border-0" maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY" oninput="formatDate(this)" readonly></td>
                          <td><input type="text" name="tc_0" id="tc_0" class="form-control h-25 border-0" ></td> 
                          <td><input type="text" name="pSize_0" id="pSize_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="pQT_0" id="pQT_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="totalI_0" id="totalI_0" class="form-control h-25 border-0" readonly ></td>
                          <td><input type="text" name="pricePI_0" id="pricePI_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="pricePP_0" id="pricePP_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="retailerP_0" id="retailerP_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="cBonus_0" id="cBonus_0" class="form-control h-25 border-0" readonly></td> <!--This would be use to sell percentage-->
                          <td><input type="text" name="bBonus_0" id="bBonus_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="bBP_0" id="bBP_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="mrBonus_0" id="mrBonus_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="mrBP_0" id="mrBP_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="totalRI_0" id="totalRI_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="costPI_0" id="costPI_0" class="form-control h-25 border-0" readonly></td>
                          <td><input type="text" name="profit_0" id="profit_0" class="form-control h-25 border-0" readonly></td>
                          <td><button type="button" name="removeRow" id="removeRow_0" class="form-control btn h-25 border-0" > </button></td>
                          <script>
                              function formatDate(input) {
                                  // Remove non-numeric characters
                                  input.value = input.value.replace(/\D/g, '');
                                  
                                  // Format input as MM/YY
                                  if (input.value.length > 2) {
                                      input.value = input.value.substring(0, 2) + '/' + input.value.substring(2);
                                  }
                              }
                          </script>
                        </tr>
                      </tbody>
                      <tfoot>
                        
                      </tfoot>
                    </table>
                    <div class="text-end" >
                    
                    <!--<button class="btn btn-info" onclick="status('approved')">Approved & Save</button>-->
                    <button class="btn btn-primary mt-2" onclick="addRow()">ADD ROW</button>
                    <button class="btn btn-secondary mt-2" id="save" >SAVE</button>
                    <!-- <button class="btn btn-success" onclick="submitData()" >PAYMENT DONE</button> -->
                  </div>
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
                <!-- Your script using Select2 -->
                <script>

fetch('../../../../attributes/fetchOrders.php')
    .then(response => response.json())
    .then(data => {
        console.log('Raw data:', data);

        // Extract order_month values
        const  uniqueOrderMonths  = data.map(order => order.order_month);

        // Log the order months
        
        
        
        // Remove duplicate months
        const orderMonths  = [...new Set(uniqueOrderMonths)].reverse();
        
        console.log('Order Months:', orderMonths);


    // Populate the Select2 dropdown
    $(document).ready(function() {
        const select = $('#search');

        // Clear existing options if any
        select.empty();

        // Add a placeholder option
        select.append('<option></option>'); // For placeholder

        // Append each value from the array as an option
        orderMonths.forEach(month => {
            select.append(`<option value="${month}">${month}</option>`);
        });

        // Initialize Select2
        select.select2({
            placeholder: "Select a month",
            allowClear: true
        });

        select.on('select2:select', function(e) {
            const selectedValue = e.params.data.id;
           // console.log('User selected:', selectedValue);

            window.location.href = `./orderList.php?order_month=${encodeURIComponent(selectedValue)}`;
        });

      })

        // Display order months in the DOM
        const orderMonthsDisplay = document.getElementById('orderMonthsDisplay');
        if (orderMonthsDisplay) {
            orderMonthsDisplay.textContent = orderMonths.join(', ');
        }

        // Optionally, you can create a more structured display
        const orderList = document.getElementById('orderList');
        if (orderList) {
            orderList.innerHTML = data.map(order => `
                <li>
                    Order Month: ${order.order_month}
                    <br>
                    Medicine: ${order.mediName}
                    <br>
                    Quantity: ${order.orderQt}
                </li>
            `).join('');
        }
   
  })
    .catch(error => {
        console.error('Error:', error);
    });





                  // Get the "SAVE" button
                const saveButton = document.getElementById('save');

                // Add a click event listener to the "SAVE" button
                saveButton.addEventListener('click', () => {
                  // Get all the rows in the table
                  const rows = document.querySelectorAll('#dataRows tr');

                  // Create an array to store the data
                  const data = [];

                  // Loop through each row and add the data to the array
                  rows.forEach((row, index) => {
                    // Get all the input fields and select elements in the row
                    const mediName = row.querySelector('#mediName_' + index).value;
                    const mrn = row.querySelector('#mrn_' + index).value;
                    const ex = row.querySelector('#ex_' + index).value || ' '; // Replace 'default value' with a valid default date or handle as needed
                    const tc = row.querySelector('#tc_' + index).value;
                    const pSize = row.querySelector('#pSize_' + index).value;
                    const pQT = row.querySelector('#pQT_' + index).value;
                    const totalI = row.querySelector('#totalI_' + index).value;
                    const pricePI = row.querySelector('#pricePI_' + index).value;
                    const pricePP = row.querySelector('#pricePP_' + index).value;
                    const retailerP = row.querySelector('#retailerP_' + index).value;
                    const cBonus = row.querySelector('#cBonus_' + index).value;
                    const bBonus = row.querySelector('#bBonus_' + index).value;
                    const bBP = row.querySelector('#bBP_' + index).value;
                    const mrBonus = row.querySelector('#mrBonus_' + index).value;
                    const mrBP = row.querySelector('#mrBP_' + index).value;
                    const totalRI = row.querySelector('#totalRI_' + index).value;
                    const costPI = row.querySelector('#costPI_' + index).value;
                    const profit = row.querySelector('#profit_' + index).value;
                    const date = document.getElementById('month').value;

                    // Add the data to the array
                    data.push({
                      mediName,
                      mrn,
                      ex,
                      tc,
                      pSize,
                      pQT,
                      totalI,
                      pricePI,
                      pricePP,
                      retailerP,
                      cBonus,
                      bBonus,
                      bBP,
                      mrBonus,
                      mrBP,
                      totalRI,
                      costPI,
                      profit,
                      date
                    });
                  });
                  console.log('data', data);

                  // Send the data to the PHP script using fetch
                  fetch('../../../../attributes/sendOrderData.php', {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                  })
                  .then(response => response.text())
                  .then(data => {
                    alert(data);

                    location.reload();
                    // Display a success message or perform other actions as needed
                  })
                  .catch(error => {
                    console.error('Error:', error);
                    // Display an error message or perform other actions as needed
                  });
                });

                function download() {
                    const { jsPDF } = window.jspdf;

                    // Create a new jsPDF instance
                    const doc = new jsPDF();

                    // Get the table element
                    const tableElement = document.getElementById('tableData');

                    // Define the columns for the table
                    const columns = [];
                    const headers = tableElement.querySelectorAll('thead th');
                    headers.forEach(header => {
                        columns.push(header.innerText);
                    });

                    // Define the rows for the table
                    const rows = [];
                    const bodyRows = tableElement.querySelectorAll('tbody tr');
                    bodyRows.forEach(row => {
                        const rowData = [];
                        const cells = row.querySelectorAll('td');
                        cells.forEach(cell => {
                            const inputElement = cell.querySelector('input, select');
                            if (inputElement) {
                                if (inputElement.tagName.toLowerCase() === 'select') {
                                    const selectedOption = inputElement.options[inputElement.selectedIndex];
                                    rowData.push(selectedOption ? selectedOption.text : '');
                                } else {
                                    rowData.push(inputElement.value);
                                }
                            } else {
                                rowData.push(cell.innerText);
                            }
                        });
                        rows.push(rowData);
                    });

                    // Add table to PDF
                    doc.autoTable({
                        head: [columns],
                        body: rows,
                        styles: { fontSize: 7 },
                        margin: { top: 10, right: 10, bottom: 10, left: 10 }
                    });

                    // Calculate total cost sum
                    let totalCostSum = 0;
                    document.querySelectorAll('[id^="profit_"]').forEach(input => {
                        if (input.value) {
                            totalCostSum += parseFloat(input.value);
                        }
                    });

                    // Get the last page number
                    const pageCount = doc.internal.getNumberOfPages();

                    // Go to the last page and add totalCostSum as a footer
                    doc.setPage(pageCount);
                    doc.text(`Total Cost Sum: ${totalCostSum.toFixed(2)}`, 10, doc.internal.pageSize.height - 10);

                    // Save the PDF
                    const currentDate = new Date().toISOString().split('T')[0];
                    const fileName = `ORDER FORECAST ${currentDate}.pdf`;
                    doc.save(fileName);
                }

                document.addEventListener('DOMContentLoaded', function () {
                    const select = document.getElementById('mediName_0');

                    // Fetch data from server
                    fetch('../../../../attributes/fetchMedi4Grn.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        //console.log("data",data)
                        // Format data for Choices.js
                        const formattedData = data.map(item => ({ value: item.name+'-'+ item.mediName, label: item.name+'-'+ item.mediName }));
                        
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
                });

                function addRow() {
                    const rowCount = document.querySelectorAll('#dataRows tr').length;
                    const newRow = `
                        <tr>
                            <td>
                                <select class="form-select form-select-lg" name="mediName" id="mediName_${rowCount}" readonly>
                                <option>Select</option>
                                </select>
                            </td>
                            <td><input type="text" name="mrn_${rowCount}" id="mrn_${rowCount}" class="form-control h-25 border-0" maxlength="5" readonly></td>
                            <td><input type="text" name="ex_${rowCount}" id="ex_${rowCount}" class="form-control h-25 border-0" maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY" oninput="formatDate(this)" readonly></td>
                            <td><input type="text" name="tc_${rowCount}" id="tc_${rowCount}" class="form-control h-25 border-0"></td>
                            <td><input type="text" name="pSize_${rowCount}" id="pSize_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="pQT_${rowCount}" id="pQT_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="totalI_${rowCount}" id="totalI_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="pricePI_${rowCount}" id="pricePI_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="pricePP_${rowCount}" id="pricePP_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="retailerP_${rowCount}" id="retailerP_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="cBonus_${rowCount}" id="cBonus_${rowCount}" class="form-control h-25 border-0"  readonly></td> <!--This would be use to sell percentage-->
                            <td><input type="text" name="bBonus_${rowCount}" id="bBonus_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="bBP_${rowCount}" id="bBP_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="mrBonus_${rowCount}" id="mrBonus_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="mrBP_${rowCount}" id="mrBP_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="totalRI_${rowCount}" id="totalRI_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="costPI_${rowCount}" id="costPI_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><input type="text" name="profit_${rowCount}" id="profit_${rowCount}" class="form-control h-25 border-0" readonly></td>
                            <td><button type="button" name="removeRow_${rowCount}" id="removeRow_${rowCount}"> <i class=" fa fa-trash " ></i> </button></td>

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
                        const formattedData = data.map(item => ({ value: item.name+'-'+ item.mediName, label: item.mediName +'-'+  item.name }));
                        
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
                }
                function addInputEventListeners(rowCount) {
                    
                    const select = document.getElementById(`mediName_${rowCount}`);
                    const inputs = document.querySelectorAll(`#dataRows tr:nth-child(${rowCount + 1}) input`);
                    
                    // Add event listener for select element
                    select.addEventListener('change', function() {
                        const [name, generic] = select.value.split('-').map(part => part.trim());
                        console.log(`Row ${rowCount + 1} - Name: ${name}, Generic: ${generic}`);
                        
                            fetch('../../../../attributes/fetchGrnProducts.php') // Update the path to your actual PHP script
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                              const matchingData = data.filter(item => item.name === name);
                                //console.log('Fetched medi items:', matchingData);
                                if (matchingData.length > 0) {
                                    // Sort the data by the updated_at attribute in descending order
                                    matchingData.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));
                                    // Use only the newest entry
                                    const newestData = matchingData[0];
                                  //  console.log('Newest medi item:', newestData);

                                    // Extract and log only the id, name, and generic attributes
                                    const {mediRep,expiryDate,pSize,pQt,totalItems,pricePI,pricePP,retailP,sp,billBonus,bBP,mrBonus,mrBP,totalRI,costPI,profit} = newestData;
                                    //console.log('Newest medi item:', { id, name, generic });
                                    document.getElementById(`mrn_${rowCount}`).value = mediRep;
                                    document.getElementById(`ex_${rowCount}`).value = expiryDate;
                                    document.getElementById(`pSize_${rowCount}`).value = pSize;
                                    document.getElementById(`pQT_${rowCount}`).value = pQt;
                                    document.getElementById(`totalI_${rowCount}`).value = totalItems;
                                    document.getElementById(`pricePI_${rowCount}`).value = pricePI;
                                    document.getElementById(`pricePP_${rowCount}`).value = pricePP;
                                    document.getElementById(`retailerP_${rowCount}`).value = retailP;
                                    document.getElementById(`cBonus_${rowCount}`).value = sp;
                                    document.getElementById(`bBonus_${rowCount}`).value = billBonus;
                                    document.getElementById(`mrBonus_${rowCount}`).value = mrBonus;
                                    document.getElementById(`bBP_${rowCount}`).value = bBP;
                                    document.getElementById(`mrBP_${rowCount}`).value = mrBP;
                                    document.getElementById(`totalRI_${rowCount}`).value = totalRI;
                                    document.getElementById(`costPI_${rowCount}`).value = costPI;
                                   // document.getElementById(`profit_${rowCount}`).value = profit;
                       
                                } else {
                                    console.log('No matching data found');
                                    alert('THERE IS NO ANY GRN RECORD ACCORDING TO THE SELECTED ITEM')
                                }
                            }) 
                            .catch(error => {
                                console.error('There was a problem with the fetch operation:', error);
                                alert('PLEASE CHECK YOUR INTERNET CONNECTION');
                                
                            });
                        });

                    // Add event listeners for input elements
                    inputs.forEach((input, index) => {
                        input.addEventListener('input', function () {
                            const rowData = Array.from(inputs).map(input => input.value);

                            let oq = rowData[2];
                            let pp = rowData[7];
                            let cost = inputs[16];
                            cost.value =  oq * pp;
                            //console.log(oq ,'x',pp,'=', cost);

                            totalCostSum = 0; // Reset the sum
                            document.querySelectorAll('[id^="profit_"]').forEach(input => {
                                if (input.value) {
                                    totalCostSum += parseFloat(input.value);

                                }
                            });
                            const totalCostInput = document.getElementById('toc-input');
                            totalCostInput.value = totalCostSum.toFixed(2);

                            console.log('Total Cost Sum:', totalCostSum);
                                                
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
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Cryptech Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Sidenav Mini</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarMinimize" onclick="navbarMinimize(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        
        </div>
      </div>
    </div>
  </div>
 
</body>

</html>