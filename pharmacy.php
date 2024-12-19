<?php
session_start();
// Include connection file
require_once './connection.php';

// Check if user_id is set in session
if (isset($_SESSION["user_id"])) {
    // Get the user ID from the session
    $user_id = $_SESSION["user_id"];

    // Prepare SQL query
    $sql = "SELECT fullName,userCode FROM system_user WHERE id = ?";

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
        $nurseCode = $row["userCode"];



    } else {
        // User not found, display error message
        echo "Error: User information not found.";
    }

    // Close statement and connection
  
} else {
    // User not logged in, redirect to login page using JavaScript
    echo '<script>window.location.href = "./index.php";</script>';
    exit();
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHARMACY</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./attributes/background.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./attributes/background.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add this script tag before your JavaScript code -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
 <!-- Include jQuery -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Include Select2 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
       table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 0px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    input[type="text"],
    input[type="number"] {
        width: 80%;
        
        box-sizing: border-box;
        border: none;
        font-size: larger ;
       
    }
    textarea{
        
        width: 100%;
        box-sizing: border-box;
        border: none;
    }

    .item-input {
        width: 80%; /* Adjust this value according to your needs */
    }
        .add-row-btn {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        #suggestions {
            position: absolute;
            background-color: #f1f1f1;
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ddd;
        }
        #suggestions div {
            padding: 8px;
            cursor: pointer;
        }
        #suggestions div:hover {
            background-color: #ddd;
        }

        .small-text {
            font-size: 5px;
        }
#printArea {
    width: 100%;
    height: auto;
    overflow: hidden;
    padding: 10px;
    box-sizing: border-box;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #000;
    padding: 5px;
}
#mymodal{
  width: 150%;
}
/* Target Choices.js select element and options */
.choices[data-type*="select-one"] .choices__list .choices__item {
    font-weight: bold; /* Make the options bold */
    font-size: 1.2em; /* Increase the font size (adjust as needed) */
}

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info ">
      <div class="container-fluid">
        <a style="font-family: cursive ; color:purple;" class="navbar-brand" href="#">Jeewaka Medical Centre</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active font-weight-bold me-5 " aria-current="page" href="">PHARMACY</a>
            </li>
            <li class="nav-item me-5">
            <a class="nav-link  font-weight-bold btn btn-outline-dark " aria-current="page" href="./home.php">PATIENT REGISTER</a>
            </li>
            <li class="nav-item">
            <a  class="nav-link  font-weight-bold btn btn-outline-dark " aria-current="page" href="./dashboard/pages/pages/users/newGrn.php">NEW GRN</a>
            </li>
          </ul>
        <div>
          <div class="d-flex align-items-center">
            <img src="./src/img/nurse1.png" class="rounded-circle" width="30" height="30" alt="User image" data-toggle="modal" data-target="#myModal">
            <input style="background:transparent; border: none; " class="form-control" type="text" id="nurseName1" value="<?php echo $fullName;?>" readonly>
          </div>
        </div>
        <!-- Bootstrap Modal -->
        <div style="color: black;" class="modal " id="myModal">
          <div class="modal-dialog  ">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">PHARMACY REPORT</h4>

                <button type="button" onclick="model()" class="close" data-dismiss="modal">&times;</button>

              </div>
              <!-- Modal Body -->
              <div class="modal-body ">
                <input type="date" id="modalDate">
                <button id="dateButton" type="button" onclick="modalFilter()" class="btn btn-secondary ">FILTER</button>
                <button type="button" class="btn btn-secondary" onclick="printModel()">DOWNLOAD</button>
                <button type="button" class="btn btn-secondary" onclick="logout()">LOGOUT</button>


                <div id="printArea">
                    <label id="date"></label>
                    <script>
                        const d = new Date();
                        const formattedTimestamp = `${d.getFullYear()}/${(d.getMonth() + 1).toString().padStart(2, '0')}/${d.getDate().toString().padStart(2, '0')} ${d.getHours().toString().padStart(2, '0')}.${d.getMinutes().toString().padStart(2, '0')}.${d.getSeconds().toString().padStart(2, '0')}`;
                        document.getElementById("date").textContent = `${formattedTimestamp}`;
                    </script>
                  
                  <table id="modeltable" class=" table-borderless text-sm  " >
                    <thead>
                      <th style="font-size: smaller;">S NO</th>
                      <th style="font-size: smaller;">STATUS</th>
                      <th style="font-size: smaller;">ITEM</th>
                      <th style="font-size: smaller;">QTY</th>
                      <th style="font-size: smaller;">TOTAL</th>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                    <tr>
                      <td>TOTAL</td>
                      <td colspan="3" ></td>
                      <td id="grandTotal"></td><!--sum of total will display here-->
                    </tr>
                    </tfoot>
                  </table>
                  </div>
                
              </div>
              <!-- Modal Footer -->   
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
              </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </nav>    
    <div class="m-4">
      <h3 class="mt-3" >PHARMACY</h3>
      <div class="ms-2 mt-3">
        <div class="container-fluid" >
          <div class="row">
            <div class="col-4">
              <select  class=" form-select border-0 " style="height: 100%; width:auto;" name="serial" id="serial" onchange="logSelectedValue()" >
                  <option>Serial Number</option>
              </select>
            </div>
            <div class="col-4">
              <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="name" value="" >
                  <label for="name">Name</label>
              </div>
            </div>
            <div class="col-4">
              <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="age" value="" >
                  <label for="age">Age</label>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <table   id="pharmacyTable">
                <thead>
                    <tr  >
                        <th style="width: 25%;" > <b >Item Code</b> </th>
                        <th>M</th>
                        <th>N</th>
                        <th>E</th>
                        <th>Nt</th>
                        <th>D</th>
                        <th>Qt</th>
                        <th>A+/A-</th>
                        <th>D%</th>
                        <th>P</th>
                        <th>PFD</th>
                    </tr>
                </thead>
                <tbody>
                  <tr id="row_0">
                    <td>
                        <select class="form-select" name="mediName_0" id="mediName_0" >
                            <option>SELECT</option>
                            <option  value="1">select serial to display medicines</option>
                        </select>
                    </td>
                    <td><input type="number" name="morning_0" id="morning_0" class="morning-meds-input" min = '0'></td>
                    <td><input type="number" name="noon_0" id="noon_0" class="noon-meds-input" min = '0'></td>
                    <td><input type="number" name="evening_0" id="evening_0" class="night-meds-input " min = '0'></td>
                    <td><input type="number" name="night_0" id="night_0" class="remark-input" min = '0'></td>
                    <td><input type="number" name="days_0" id="days_0" class="days-input" min = '0'></td>
                    <td>
                      <input type="number" name="qty_0" id="qty_0" class="days-input" min = '0' readonly></>
                      <input type="number" name="staticQty_0" id="staticQty_0" value="" hidden >
                      <input type="number" name="rowQty_0" id="rowQty_0" value="" hidden >
                      <input type="number" name="up_0" id="up_0"  min = '0' hidden >
                    </td>
                    <td><input class="text-end" name="add_0" id="add_0" type="number" min = '0'></td>
                    <td><input class="text-end"  name="dis_0" id="dis_0" type="number" min = '0'></td> 
                    <td><input class="text-end  cost-input" name="cost_0" id="cost_0" type="number" readonly min = '0'></td>
                    <td><input class="text-end  disPrice-input" name="dp_0" id="dp_0" type="number" readonly min = '0'></td>
                  </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td  class="text-start" colspan="9" >Total:</td>
                        <td style="width:12%" class="text-end" ><input name="total" id="total" class="text-end ms-4 form-control" type="number" readonly  ></td>
                        <td  style="width:12% ; align-content: end; " ><input name="dpTotal" id="dpTotal" class="text-end ms-4 form-control" type="number" readonly  ></td>

                    </tr>
                </tfoot>
            </table>
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-2">
                <button class="btn btn-primary  m-1" onclick="printReceipt()">QUOTATION</button>
                </div>
                <div class="col-2">
                  <button class="btn btn-info  mt-1" id="submit" onclick="save('PAYMENT')" > <b class="ms-3 me-3" >SAVE</b> </button>
                </div>
                <div class="col-2">
                  <button class="btn btn-secondary mt-1 " id="p&s" onclick="printANDsave()" > <b>SALE PRINT</b> </button>
                </div>
                <div class="col-2">
                <button class="btn btn-danger m-1" id="clear" ><b class="ms-3 me-3" >CLEAR</b></button>
                </div>
                <div class="col-2">
                <button class=" btn btn-success m-1 " onclick="addNewRow()">ADD ROW</button>
                </div>
            </div> 
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<?php
// MySQL database connection parameters
include './connection.php';

// SQL query to fetch the last ID from pharmacygeneraldata table
$sql = "SELECT id FROM pharmacygeneraldata ORDER BY id DESC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $billNo = $row["id"]+1;
    }
} else {
    echo "0 results";
}
$conn->close();
?>


    <script>

function logSelectedValue() {
    const selectElement = document.getElementById('serial');
    const selectedValue = selectElement.value;
    console.log('Selected Serial Number:', selectedValue);
    enableSelectMenu(selectedValue);
}

function enableSelectMenu(selectedValue) {
    const mediNameElement = document.getElementById('mediName_0');
    if (mediNameElement) {
        if (selectedValue == 'Serial Number') {
            location.reload();
            //console.log('pass');
        } else {
            mediNameElement.disabled = false;
            //console.log('fail');
        }
    } else {
        console.log('mediName_0 element not found');
    }
}
       
        
async function modalFilter() {
    const modalDate = document.getElementById('modalDate').value;
    try {
        // Fetch data from fetchPharmacy.php
        const response1 = await fetch('./attributes/fetchPharmacy.php');
        if (!response1.ok) {
            throw new Error('Network response was not ok ' + response1.statusText);
        }
        const data = await response1.json();

        // Filter the data based on modalDate
        const filteredData = data.filter(item => {
            const itemDate = new Date(item.created_at);
            // Adjust the time to Sri Lankan time (GMT+5:30)
            itemDate.setHours(itemDate.getUTCHours() + 5);
            itemDate.setMinutes(itemDate.getUTCMinutes() + 30);
            const sriLankanDate = itemDate.toISOString().split('T')[0];
            console.log( modalDate  ,'==', sriLankanDate)
            return sriLankanDate === modalDate;
        });


        //console.log('Filtered data:', filteredData);

        // Create a parent array to store serial numbers
        const parentArray = {};
        let grandTotal = 0;

        filteredData.forEach(item => {
            if (!parentArray[item.serial]) {
                parentArray[item.serial] = [];
            }

            // Calculate the total
            const total = parseFloat(item.dprice);
            grandTotal += total;

            // Create an object for each item and push it to the respective serial array
            parentArray[item.serial].push({
                itemCode: item.itemCode,
                qty: item.qty,
                total: total.toFixed(2), // Format total to 2 decimal places
                serial: item.serial // Include serial for later use
            });
        });

        // Fetch additional data from fetchPharmacyGener.php
        const response2 = await fetch('./attributes/fetchPharmacyGener.php');
        if (!response2.ok) {
            throw new Error('Network response was not ok ' + response2.statusText);
        }
        const genData = await response2.json();

        // Add the status to the parentArray
        genData.forEach(gData => {
            if (parentArray[gData.serial]) {
                parentArray[gData.serial].forEach(item => {
                    item.status = gData.status; // Add the status to the existing items
                });
            }
        });

        // Get the table body element
        const tableBody = document.querySelector('#modeltable tbody');
        tableBody.innerHTML = ''; // Clear existing table rows

        // Populate the table with the structured data
        Object.keys(parentArray).forEach(serial => {
            let serialTotal = 0;
            parentArray[serial].forEach((item, index) => {
                const row = document.createElement('tr');
                if (index === 0) {
                    const serialCell = document.createElement('td');
                    serialCell.rowSpan = parentArray[serial].length + 1; // +1 for the total row
                    serialCell.textContent = serial;
                    row.appendChild(serialCell);
                }

                let status;
                if (item.status == 'QUOTATION & PAYMENT' || item.status == 'PAYMENT'){
                  status= 'SALE PRINT';
                }
                if(item.status == 'QUOTATION'){
                  status= 'QUOTATION';
                }

                

                const statusCell = document.createElement('td');
                statusCell.textContent =  status;
                row.appendChild(statusCell);

                const itemCodeCell = document.createElement('td');
                itemCodeCell.textContent = item.itemCode;
                row.appendChild(itemCodeCell);

                const qtyCell = document.createElement('td');
                qtyCell.textContent = item.qty;
                row.appendChild(qtyCell);

                const totalCell = document.createElement('td');
                totalCell.textContent = item.total;
                row.appendChild(totalCell);

                tableBody.appendChild(row);
                serialTotal += parseFloat(item.total);
            });

            // Add the total row for the current serial
            const totalRow = document.createElement('tr');
            const totalLabelCell = document.createElement('td');
            totalLabelCell.colSpan = 3;
            totalLabelCell.textContent = '';

            const totalValueCell = document.createElement('td');
            totalValueCell.textContent = serialTotal.toFixed(2);

            totalRow.appendChild(totalLabelCell);
            totalRow.appendChild(totalValueCell);

            tableBody.appendChild(totalRow);
        });

        // Update the grand total in the table footer
        document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
       // console.log('Grand Total:', grandTotal);
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}


        async function printModel() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF({
          orientation: 'portrait',
          unit: 'pt',
          format: 'a4'
      });

      const table = document.getElementById('modeltable');
      const rows = table.querySelectorAll('tbody tr');
      const rowsPerPage = 50;
      let currentPage = 0;
      let currentRow = 0;

      while (currentRow < rows.length) {
          const pageTable = document.createElement('table');
          pageTable.className = 'table modeltable table-borderless text-sm';

          // Create and add the header
          const header = table.querySelector('thead').cloneNode(true);
          pageTable.appendChild(header);

          // Create tbody and add rows
          const tbody = document.createElement('tbody');
          for (let i = 0; i < rowsPerPage && currentRow < rows.length; i++, currentRow++) {
              const row = rows[currentRow].cloneNode(true);
              tbody.appendChild(row);
          }
          pageTable.appendChild(tbody);

          // Append the pageTable to the body for rendering
          document.body.appendChild(pageTable);

          // Convert the table page to canvas
          const canvas = await html2canvas(pageTable, {
              scale: 1,
              useCORS: true
          });

          // Remove the pageTable from the body after rendering
          document.body.removeChild(pageTable);

          const imgData = canvas.toDataURL('image/png');

          // Calculate image dimensions to fit into PDF
          const imgWidth = 595.28; // A4 width in points
          const pageHeight = 841.89; // A4 height in points
          const imgHeight = canvas.height * imgWidth / canvas.width;

          if (currentPage > 0) {
              doc.addPage();
          }
          doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
          currentPage++;
      }

      // Add generated date and time at the bottom
      const now = new Date();
      const options = {
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit'
      };
      const dateTimeString = now.toLocaleString('en-US', options);
      //doc.text(dateTimeString, 40, doc.internal.pageSize.height - 30);

      const currentDate = new Date().toISOString().split('T')[0];
      const fileName = `Pharmacy Report ${currentDate}.pdf`;
      doc.save(fileName);
    }async function printModel() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'pt',
        format: 'a4'
    });

    const table = document.getElementById('modeltable');
    const rows = table.querySelectorAll('tbody tr');
    const footerRow = table.querySelector('tfoot tr');  // Get the footer row
    const rowsPerPage = 45;
    let currentPage = 0;
    let currentRow = 0;

    while (currentRow < rows.length) {
        const pageTable = document.createElement('table');
        pageTable.className = 'table modeltable table-borderless text-sm';

        const header = table.querySelector('thead').cloneNode(true);
        pageTable.appendChild(header);

        const tbody = document.createElement('tbody');
        for (let i = 0; i < rowsPerPage && currentRow < rows.length; i++, currentRow++) {
            const row = rows[currentRow].cloneNode(true);
            tbody.appendChild(row);
        }
        pageTable.appendChild(tbody);

        // Append the footer row to each page
        if (currentRow >= rows.length) {
            const tfoot = document.createElement('tfoot');
            tfoot.appendChild(footerRow.cloneNode(true));
            pageTable.appendChild(tfoot);
        }

        document.body.appendChild(pageTable);

        const canvas = await html2canvas(pageTable, {
            scale: 1,
            useCORS: true
        });

        document.body.removeChild(pageTable);

        const imgData = canvas.toDataURL('image/png');

        const imgWidth = 595.28;
        const pageHeight = 839.89;
        const imgHeight = canvas.height * imgWidth / canvas.width;

        if (currentPage > 0) {
            doc.addPage();
        }
        doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
        currentPage++;
    }

    const now = new Date();
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    const dateTimeString = now.toLocaleString('en-US', options);

    const currentDate = new Date().toISOString().split('T')[0];
    const fileName = `Pharmacy Report ${currentDate}.pdf`;
    doc.save(fileName);
}



function save(status) {
    // Array to hold general data from all rows
    const generalDataArray = [];
    //console.log('status',status)

    // Array to hold medication data from all rows
    const medicationDataArray = [];

    // Array to hold both general data and medication data
    const collectedData = [];

    // New array to hold status, name, and rowQty
    const updateData = [];

    // Collecting data from the initial row
    const serial = document.getElementById('serial').value;
    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    const nurseCode ='<?php  echo $nurseCode?>';
   // console.log('nurseCode',nurseCode);
    // Creating an object for the general data of the initial row
    const generalDataInitial = {
        serial: serial,
        name: name,
        age: age,
        status : status,
        nurseCode : nurseCode,

    };

    // Pushing initial row general data to the generalDataArray
    generalDataArray.push(generalDataInitial);

    // Collecting data from additional rows
    const rowCount = rowCounter + 1; // Get total number of rows including initial row
    for (let i = 0; i < rowCount; i++) {
        let dPrice = 1 ;
        const mediName = document.getElementById(`mediName_${i}`).value;
        const morning = document.getElementById(`morning_${i}`).value;
        const noon = document.getElementById(`noon_${i}`).value;
        const evening = document.getElementById(`evening_${i}`).value;
        const night = document.getElementById(`night_${i}`).value;
        const days = document.getElementById(`days_${i}`).value;
        const qty = document.getElementById(`qty_${i}`).value;
        const cost = document.getElementById(`cost_${i}`).value;
        const add = document.getElementById(`add_${i}`).value;
        const discount = document.getElementById(`dis_${i}`).value;
        const dp = document.getElementById(`dp_${i}`).value;
        let rowQty = document.getElementById(`rowQty_${i}`).value;

        if(status == 'QUOTATION'){
        console.log('QUOTATION');
        dPrice = dp/10000;
        rowQty = parseFloat(rowQty)+ parseFloat(qty);
      }
      else{
        console.log('my bad');
        dPrice = dp;
      }
        // Creating an object for the medication data of each row
        const medicationData = {
            name: mediName,
            morning: morning,
            noon: noon,
            evening: evening,
            night: night,
            days: days,
            qty: qty,
            cost: cost,
            discount : discount,
            dPrice : dPrice,
            additionalNotes: add
        };
        
        console.log('medicationData',medicationData);

        // Pushing medication data of each row to the medicationDataArray
        medicationDataArray.push(medicationData);

        // Adding status, name, and rowQty to updateData array
        const [genericName, companyName] = mediName.split(" - ");
        if(rowQty <= 0){
          rowQty = 0;
        }
        updateData.push({
            status: status,
            genericName: genericName,
            companyName: companyName,
            rowQty: rowQty
        });

    }

    // Pushing general data array and medication data array into collectedData array
    collectedData.push(generalDataArray);
    collectedData.push(medicationDataArray);

    // Logging the collected data to the console
    //console.log("updateData Data:", updateData);

    const sendingData = {
        generalData: generalDataArray,
        medicationData: medicationDataArray
    };

    // Sending collected data to server via AJAX

    


// Sending collected data to server via AJAX



if(serial=='Serial Number'){
   alert('PLEASE SELECT A SERIAL NUMBER');
}
else{
 
  $(document).ready(function() {
    
    /// Make AJAX request to updateStock.php
    $.ajax({
        url: './attributes/updateStock.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(updateData),
        success: function(response) {
           // console.log('Response:', response);
        },
        error: function(xhr, status, error) {
            alert('Error:', error);
        }
    });});

    const xhr = new XMLHttpRequest();
xhr.open('POST', './attributes/sendPharmacy.php');
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.onload = function() {
    if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
            alert('Respons:.', response);
            location.reload();
        } else {
            alert('Error saving data:', response.message);
        }
    } else {
      alert('Error saving data:', xhr.statusText);
    }
};
xhr.send(JSON.stringify(sendingData));

}

}




    function printReceipt() {
      // Get the values to be printed
     // const name = document.getElementById('name').value;
      totalCost = parseFloat(document.getElementById('total').value).toFixed(2);
      dpTotal = parseFloat(document.getElementById('dpTotal').value).toFixed(2);
      const currentDate = new Date().toLocaleDateString(); // Get the current date
      const currentTime = new Date().toLocaleTimeString();
      let billNo = document.getElementById('serial').value;

      // Get table data
      const tableRows = document.querySelectorAll('#pharmacyTable tbody tr');

      // Construct the content of the receipt including the table
      let tableRowsContent = '';
      tableRows.forEach(row => {
        const itemCode = row.querySelector('select[name^="mediName_"]').value;
        console.log('itemCode',itemCode);
        const [generic, name] = itemCode.split(' - ');
        const qty = row.querySelector('input[name^="qty_"]').value;
        const uPrice = row.querySelector('input[name^="up_"]').value;
        let cost = parseFloat(row.querySelector('input[name^="cost_"]').value).toFixed(2); // Convert to float and round to 2 decimal places
        let dp = parseFloat(row.querySelector('input[name^="dp_"]').value).toFixed(2); // Convert to float and round to 2 decimal places
        tableRowsContent += `
          <tr style="font-size:15px;">
            <td style="text-align:start; font-size:12px;">${name}</td>
            <td style="text-align:start; font-size:12px;">@</td>
            <td style="text-align:start; font-size:12px;" >${uPrice}</td>
            <td style="text-align:center; font-size:12px;">X</td>
            <td style="text-align:start; font-size:12px;" >${qty}</td>
            <td style="text-align:end; font-size:12px;" >${cost}</td>
          </tr>
         
        `;
      });

      // Construct the receipt content
      const receiptContent = `
  
      <h1><center>RECIEPT</center></h1>
      <label><center>Bill No :${billNo}</center></label>
      <div class="row">
        <div class="col-12 text-center">
        <center>  <p>${currentDate} <strong>,</strong> ${currentTime}</p> </center>
        </div>
      </div>
      <table  >
      
        <tbody >
          ${tableRowsContent}
        </tbody>
        <tfoot>
          <tr>
          <td colspan="6" ><hr></td>
          </tr>
          <tr>
            <td style="font-size:25px;" colspan="5" class="mt-2" >TOTAL:</td>
            <td style="text-align:end; font-size:25px;" >${totalCost}</td>
          </tr>
          <tr>
            <td style="font-size:25px;" colspan="5">DISCOUNTED TOTAL:</td>
            <td style="text-align:end; font-size:25px;" >${dpTotal}</td>
          </tr>
        </tfoot>
      </table>
    `;
      // Create a hidden iframe
      const iframe = document.createElement('iframe');
      iframe.style.display = 'none';
      document.body.appendChild(iframe);

      // Write the receipt content to the iframe document
      const iframeDoc = iframe.contentWindow.document;
      iframeDoc.open();
      iframeDoc.write(`
        <html>
          <head>
            <title>Receipt</title>
            <style>
              body {
                font-family: Arial, sans-serif;
                font-size : 12px;
              }
              table {
                border-collapse: collapse;
                width: 100%;
                border:none;
                font-size : 12px;

              }
              th, td {
                text-align: left;
                font-size : 12px;

              }
              th {
                background-color: #f2f2f2;
                font-size : 12px;

              }
              tfoot td {
                font-weight: bold;
                font-size : 10px;
                margin-top: 4px;

              }
            </style>
          </head>
          <body>
              .
              <br><br>
              <br><br>
              <br><br>
            ${receiptContent}
            <hr>
            <center>    <p style="font-size: 5px ;"  >© 2024,made by Cryptech Solutions for a better web.<br>
                +94704973144 | +94775450990 | admin@mdlukavishka.online
                </p></center>
          </body>
        </html>
      `);
      iframeDoc.close();

      // Print the content of the iframe
      iframe.contentWindow.print();

      // Remove the iframe after printing
      setTimeout(() => {
        document.body.removeChild(iframe);
      }, 1000); // Delay for 1 second to ensure printing is complete
     save('QUOTATION')
    }


    function printANDsave(){
      //const name = document.getElementById('name').value;
      totalCost = parseFloat(document.getElementById('total').value).toFixed(2);
      dpTotal = parseFloat(document.getElementById('dpTotal').value).toFixed(2);
      const currentDate = new Date().toLocaleDateString(); // Get the current date
      const currentTime = new Date().toLocaleTimeString();
      let billNo = document.getElementById('serial').value;

      // Get table data
      const tableRows = document.querySelectorAll('#pharmacyTable tbody tr');

      // Construct the content of the receipt including the table
      let tableRowsContent = '';
      tableRows.forEach(row => {
        const itemCode = row.querySelector('select[name^="mediName_"]').value;
        //console.log('itemCode',itemCode);
        const [generic, name] = itemCode.split(' - ');
        const qty = row.querySelector('input[name^="qty_"]').value;
        const uPrice = row.querySelector('input[name^="up_"]').value;
        let cost = parseFloat(row.querySelector('input[name^="cost_"]').value).toFixed(2); // Convert to float and round to 2 decimal places
        let dp = parseFloat(row.querySelector('input[name^="dp_"]').value).toFixed(2); // Convert to float and round to 2 decimal places
        tableRowsContent += `
          <tr>
            <td style="text-align:start; font-size:15px;">${name}</td>
            <td style="text-align:start; font-size:15px;">@</td>
            <td style="text-align:start; font-size:15px;" >${uPrice}</td>
            <td style="text-align:center; font-size:15px;">X</td>
            <td style="text-align:start; font-size:15px;" >${qty}</td>
            <td style="text-align:end; font-size:15px;" >${cost}</td>
            
          </tr>
         
        `;
      });


      // Construct the receipt content
      const receiptContent = `
      <br><br>
      <br><br>
      <br><br>
      <h1><center>RECIEPT</center></h1>
      <label><center>Bill No :${billNo}</center></label>
      <div class="row">
        <div class="col-12 text-center">
        <center>  <p>${currentDate} <strong>,</strong> ${currentTime}</p> </center>
        </div>
      </div>
      <table   style="font-size : 15px">
      
        <tbody>
          ${tableRowsContent}
        </tbody>
        <tfoot>
         <tr>
          <td colspan="6" ><hr></td>
          </tr>
          <tr>
            <td style="font-size : 25px;" colspan="5" class="mt-2" >TOTAL:</td>
            <td style="text-align:end ; font-size : 25px;" >${totalCost}</td>
          </tr>
          <tr>
            <td style="font-size : 25px;" colspan="5">DISCOUNTED TOTAL:</td>
            <td  style="text-align:end; font-size : 25px;" >${dpTotal}</td>
          </tr>
        </tfoot>
      </table>
    `;
      // Create a hidden iframe
      const iframe = document.createElement('iframe');
      iframe.style.display = 'none';
      document.body.appendChild(iframe);

      // Write the receipt content to the iframe document
      const iframeDoc = iframe.contentWindow.document;
      iframeDoc.open();
      iframeDoc.write(`
        <html>
          <head>
            <title>Receipt</title>
            <style>
              body {
                margine-top: 30px,
                font-family: Arial, sans-serif;
                font-size : 12px;
              }
              table {
                border-collapse: collapse;
                width: 100%;
                border:none;
                font-size : 12px;

              }
              th, td {
                text-align: left;
                font-size : 12px;

              }
              th {
                background-color: #f2f2f2;
                font-size : 12px;

              }
              tfoot td {
                font-weight: bold;
                font-size : 12px;

              }
            </style>
          </head>
          <body>
           .
              <br><br>
              <br><br>
              <br><br>
            ${receiptContent}
            <hr>
            <center>    <p style="font-size: 5px ;"  >© 2024,made by Cryptech Solutions for a better web.<br>
                +94704973144 | +94775450990 | admin@mdlukavishka.online
                </p></center>
          </body>
        </html>
      `);
      iframeDoc.close();

      // Print the content of the iframe
      iframe.contentWindow.print();

      // Remove the iframe after printing
      setTimeout(() => {
        document.body.removeChild(iframe);
      }, 1000); // Delay for 1 second to ensure printing is complete
      save('QUOTATION & PAYMENT')
    }


    document.addEventListener("DOMContentLoaded", function() {
    let data; // Declare data variable outside of the fetch chain

    fetch('./attributes/fetchPatientDeta.php')
        .then(response => response.json())
        .then(fetchedData => {
            data = fetchedData; // Assign fetchedData to the data variable
            // Log the fetched data to the console for verification
           // console.log("Fetched Data:", data);

            // Get today's date in the format YYYY-MM-DD
            const today = new Date();
            const todayStr = today.toISOString().split('T')[0];

            // Filter data for entries created today with jd value = null
            const filteredData = data.filter(item => {
                const createdAtDate = item.created_at.split(' ')[0];
                return createdAtDate === todayStr && item.jd === null;
            });

            // Log the filtered data to the console for verification
            //console.log("Filtered Data:", filteredData);

            // Sort the filtered data array in descending order based on serial numbers
            filteredData.sort((a, b) => b.serial - a.serial);

            // Populate the <select> element with filtered data using Select2
            $('#serial').select2({
                data: filteredData.map(item => ({ id: item.serial, text: item.serial })),
                tags: true,
                placeholder: 'Search for serial...',
                allowClear: true
            });

            $('#serial').on('change', function (e) {
                const selectedSerial = $(this).val();
                displayNameAge(selectedSerial);
                fetchMedicinesData();
            });
        })
        .catch(error => {
            alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER', error);
        });

    const reloadButton = document.getElementById('clear');

    // Add a click event listener to the reload button
    reloadButton.addEventListener('click', function() {
        // Reload the page
        location.reload();
    });

    function displayNameAge(selectedSerial) {
        //console.log('Selected Serial:', selectedSerial);
        const selectedData = data.find(item => item.serial === selectedSerial);

        if (selectedData) {
            document.getElementById('name').value = selectedData.name;

            // Calculate age based on date of birth
            const dob = new Date(selectedData.dob);
            const today = new Date();
            let ageYears = today.getFullYear() - dob.getFullYear();
            let ageMonths = today.getMonth() - dob.getMonth();

            // If the birth month has not occurred yet in the current year, subtract one year from age
            if (ageMonths < 0 || (ageMonths === 0 && today.getDate() < dob.getDate())) {
                ageYears--;
                ageMonths += 12;
            }

            // Display age in "Y M" format
            document.getElementById('age').value = ageYears + 'Y ' + ageMonths + 'M';
        } else {
            document.getElementById('name').value = ''; // Clear the name input field if no match found
            document.getElementById('age').value = ''; // Clear the age input field if no match found
        }
    }
});



    let rowCounter = 0; // Counter for generating unique row IDs

    function addNewRow() {
        // Increment row counter to generate unique IDs
        rowCounter++;

        // Get the pharmacy table
        const pharmacyTable = document.getElementById('pharmacyTable').getElementsByTagName('tbody')[0];

        // Create a new row element
        const newRow = document.createElement('tr');

        // Set unique ID for the new row
        newRow.id = 'row_' + rowCounter;

        // Construct the HTML content for the new row
        newRow.innerHTML = `
            <td>
                <select class="form-select" name="mediName_${rowCounter}" id="mediName_${rowCounter}">
                <option>SELECT</option>

                </select>
            </td>
            <td><input type="number" name="morning_${rowCounter}" id="morning_${rowCounter}" class="morning-meds-input "  min = '0'></td>
            <td><input type="number" name="noon_${rowCounter}" id="noon_${rowCounter}" class="noon-meds-input l"  min = '0'></td>
            <td><input type="number" name="evening_${rowCounter}" id="evening_${rowCounter}" class="night-meds-input "  min = '0'></td>
            <td><input type="number" name="night_${rowCounter}" id="night_${rowCounter}" class="remark-input "  min = '0'></td>
            <td><input type="number" name="days_${rowCounter}" id="days_${rowCounter}" class="days-input "  min = '0'></td>
            <td>
              <input type="number" name="qty_${rowCounter}" id="qty_${rowCounter}" class="days-input "  min = '0'>
              <input type="number" name="staticQty_${rowCounter}" id="staticQty_${rowCounter}" value="" hidden>
              <input type="number" name="rowQty_${rowCounter}" id="rowQty_${rowCounter}" value="" hidden>
              <input name="up_${rowCounter}" id="up_${rowCounter}" type="number" hidden >
            </td>
            <td><input name="add_${rowCounter}" id="add_${rowCounter}" type="number"  min = '0'></td>
            <td><input class="text-end" name="dis_${rowCounter}" id="dis_${rowCounter}" type="number"  min = '0'></td>
            <td><input class="text-end cost-input" name="cost_${rowCounter}" id="cost_${rowCounter}" type="number" readonly  min = '0'></td>
            <td><input class="text-end  cost-input" name="dp_${rowCounter}" id="dp_${rowCounter}" type="number"  readonly min = '0'></td>


        `;

        // Append the new row to the pharmacy table
        pharmacyTable.appendChild(newRow);

        // Populate the select element in the new row with medicines data
        populateSelectWithMedicines(`mediName_${rowCounter}`);

        // Recalculate sum and cost for the new row
        captureInputValuesAndCalculateSum(rowCounter,null);
        //console.log('rowCounter',rowCounter);

    }


    let medicinesData = null; // Variable to store fetched data

    function fetchMedicinesData() {
      return fetch('./attributes/fetchMedicines.php') // Replace 'path_to_php_file.php' with the actual path to your PHP file
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER');

          }
          return response.json();
        })
        .then(data => {
          medicinesData = data; // Store the fetched data in the variable
          //console.log('medicinesData',medicinesData);
          // Ensure medicinesData is fetched before accessing it
            if (medicinesData) {
            // Loop through each item in medicinesData
            medicinesData.forEach(item => {
                // Log the combination of "mediName" and "name"
                //console.log( item.name+ " - " +item.mediName );
                //console.log( item.name+ " - " +item.mediName , 'for' ,rowCounter );

            });
            } else {
            console.log("Medicines data not fetched yet."); // Handle case where data is not fetched yet
            }

          // Call the function to populate the select element
          populateSelectWithMedicines(`mediName_${rowCounter}`);
        })
        .catch(error => {
          console.error('There was a problem with the fetch operation:', error);
          alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER');
        });
    }

    // Call the function to fetch the data
    


    // Define costInput outside of captureInputValuesAndCalculateSum
    let costInput;

    function captureInputValuesAndCalculateSum(row, fetchCost) {
      if (!row || !row.querySelectorAll) {
        console.error('Invalid row provided');
        //alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER');
        return;
      }

      //console.log('row',row)

      const rowIndex = row.id.split('_')[1];

      // Function to calculate the sum of all input fields
      function calculateSum() {
        // Calculate sum for each row
        const morningValue = parseFloat(document.getElementById(`morning_${rowIndex}`).value) || 0;
        const noonValue = parseFloat(document.getElementById(`noon_${rowIndex}`).value) || 0;
        const eveningValue = parseFloat(document.getElementById(`evening_${rowIndex}`).value) || 0;
        const nightValue = parseFloat(document.getElementById(`night_${rowIndex}`).value) || 0;
        const daysValue = parseFloat(document.getElementById(`days_${rowIndex}`).value) || 0;
        const addValues = parseFloat(document.getElementById(`add_${rowIndex}`).value) || 0;
        const discount = parseFloat(document.getElementById(`dis_${rowIndex}`).value) || 0;

        


        //console.log('morningValue',morningValue);
        //console.log('discount',discount);

        let sum = morningValue + noonValue + eveningValue + nightValue;
        
        // Check if daysInput has a value
        if (daysValue > 0) {
          sum *= daysValue; // Multiply sum by daysValue
        }

        sum += addValues;

        const cost = sum * fetchCost;
        let dis = (cost/100)*discount;

        const dp = cost - dis;
        //console.log('dp', dp);
        document.getElementById(`cost_${rowIndex}`).value = cost;
        document.getElementById(`qty_${rowIndex}`).value = sum;
        document.getElementById(`dp_${rowIndex}`).value = dp;


        //reduce qt from stock
        staticQty = document.getElementById(`staticQty_${rowIndex}`).value;//get value of stock for selected medicine
        rowQty = document.getElementById(`rowQty_${rowIndex}`);
        updatedStock= staticQty-sum; // calculate updated qt(updatedQt = availableQt - issuedQt)
        rowQty.value= updatedStock; //set value of row qt for send it to data base
        if (updatedStock <= 0)
        {
          alert('Out of Stock');
          
        }
       // console.log('updatedStock',updatedStock)

         
        updateTotalCost();// Update total cost when individual rows change

      }

      // Function to update the cost value
      function updateCost() {
        const qtyValue = parseFloat(document.getElementById(`qty_${rowIndex}`).value) || 0;
        const addValues = parseFloat(document.getElementById(`add_${rowIndex}`).value) || 0;

        const cost = qtyValue * fetchCost;
        document.getElementById(`cost_${rowIndex}`).value = cost;
        

        // Update total cost when individual rows change
        updateTotalCost();
      }
      
      // Attach event listeners to input fields
      const inputs = row.querySelectorAll('input[id^=morning_], input[id^=noon_], input[id^=evening_], input[id^=night_], input[id^=days_], input[id^=qty_],input[id^=add_],input[id^=dis_]');
      inputs.forEach(input => input.addEventListener('input', calculateSum));
      
      // Store the costInput
      costInput = document.querySelectorAll('input[id^=cost_]');
      dpinput = document.querySelectorAll('input[id^=dp_]');
    
    }


   


    // Function to update total cost
    function updateTotalCost() {
      if (!costInput) {
        console.error('costInput is not defined');
        alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER');
        return;
      }

      let totalCost = 0;
      costInput.forEach(input => {
        const costValue = parseFloat(input.value) || 0;
        totalCost += costValue;
      });
      const totalCostInput = document.getElementById('total');
      if (totalCostInput) {
        totalCostInput.value = totalCost;
       // console.log('totalCost',totalCost)
      } else {
        console.error('Total cost input field not found');
        alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER');

      }

      if (!dpinput) {
        console.error('costInput is not defined');
        alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER');

        return;
      }

      let totaldp = 0;
      dpinput.forEach(input => {
        const dpValue = parseFloat(input.value) || 0;
        totaldp += dpValue;
      });
      const totaldpInput = document.getElementById('dpTotal');
      if (totaldpInput) {
        totaldpInput.value = totaldp;
       // console.log('totaldp',totaldp)
      } else {
        console.error('Total cost input field not found');
        alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER');

      }
     
    }


    // Function to populate the select element with fetched data and make it searchable
    function populateSelectWithMedicines(selectId) {
      // Get the select element by its ID
      const selectElement = document.getElementById(selectId);
      const number = selectId.match(/\d+/);

      // Check if number is found
      if (number) {
        // Log the extracted number to the console
        //console.log('Number:', number[0]);
      } else {
        console.log('No number found in selectId');
      }

     // console.log('selectId', selectId);

      // Ensure medicinesData is fetched before populating the select
      if (medicinesData) {
        // Clear existing options

        // Loop through each item in medicinesData and add it as an option
        medicinesData.forEach(item => {
          const option = document.createElement('option');
          option.value = item.mediName + " - " + item.name; // Set the value of the option
          option.text = item.name + " - " + item.mediName; // Set the text of the option
          selectElement.appendChild(option); // Append the option to the select element
        });

        // Initialize Choices.js for the select element to make it searchable
        new Choices(selectElement, {
          searchEnabled: true,
          placeholder: true,
          classNames: {
              containerOuter: 'choices',
              listDropdown: 'choices__list',
              itemChoice: 'choices__item',
          }
        });

        // Add event listener to update cost input field when selection changes
        selectElement.addEventListener('change', function(event) {
        const selectedOptionValue = event.target.value;
        //console.log('selectedOptionValue', selectedOptionValue);
        let selectedMedicine;
        let selectedOptionTrimmed;

        if (selectedOptionValue) {
          selectedOptionTrimmed = selectedOptionValue.trim();

          medicinesData.forEach(item => {
            const valueBeingChecked = (item.mediName + " - " + item.name).trim();
            
            //console.log('Checking:', valueBeingChecked, 'against:', selectedOptionTrimmed);
            //console.log('Lengths:', valueBeingChecked.length, 'vs', selectedOptionTrimmed.length);
            
            if (valueBeingChecked === selectedOptionTrimmed) {
              //console.log('Match found:', item);
              selectedMedicine = item; // Assign the found item to selectedMedicine
            }
          });

          // Now selectedMedicine is available here
          if (selectedMedicine) {
            //console.log('Selected Medicine:', selectedMedicine);
      // Set the cost value in the input field    staticQty_0
            document.getElementById(`cost_${number[0]}`).value = selectedMedicine.cost;
                          document.getElementById(`up_${number[0]}`).value = selectedMedicine.cost;

                          document.getElementById(`staticQty_${number[0]}`).value = selectedMedicine.qt;
                          //console.log("testing Number:", number[0]);

                          // Fetch the corresponding row element
                          const row = document.getElementById(`row_${number[0]}`);
                          if (row) {
                            // Call the function with the row element and fetchCost
                            const fetchCost = selectedMedicine.cost;
                            captureInputValuesAndCalculateSum(row, fetchCost);
                              //console.log("testing Fetch Cost:", fetchCost);
                          } else {
                            //console.log("Row element not found.");
                          }
          } else {
            console.log('No matching medicine found for the selected option value.');
          }
        } else {
          // Clear cost value if no option is selected
          document.getElementById('cost_0').value = '';
        }

        });
      } else {
        //console.log("Medicines data not fetched yet."); // Handle case where data is not fetched yet
      }
    }

    // Call the function to populate the select element
    populateSelectWithMedicines('mediName_0');
    captureInputValuesAndCalculateSum(document.getElementById('row_0'), null);


// Initialize an empty array to hold the data globally
let storedData = [];

function processQt(rowElement, comName, genericName, quantity) {
   
    // Check if row element exists
    if (rowElement) {
        // Push new data as a new object to the global array
        storedData.push({ comName, genericName, quantity });

        // Log stored data
        //console.log("Stored Data:", storedData);

        // Update stored data attribute if needed
        // rowElement.dataset.qtData = JSON.stringify(storedData);
    } else {
       // console.log("Row element does not exist.");
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var inputField = document.getElementById('qty_0');
    inputField.addEventListener('input', function() {
       // console.log('User input:', inputField.value);
    });
});




    function logout() {
        // Perform AJAX request to logout.php
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "./attributes/logout.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Redirect to index.php after successful logout
                window.location.href = "./index.php";
            }
        };
        xhr.send();
    }
    $(document).ready(function() {
  $('#dropdownMenuButton').click(function() {
    $(this).parent().toggleClass('show');
  });
});

        </script>

</body>
</html>
