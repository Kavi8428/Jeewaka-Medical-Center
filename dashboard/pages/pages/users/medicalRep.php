<?php
session_start();

// Include connection file
include '../../../../connection.php';
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
  <title>
    MEDICAL REP
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
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../../assets/css/mediRep.css">

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

    input {
      border: 1px;
      border-color: black;
      background-color: LightGray;
      border-radius: 5px;
      font-size: smaller;
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="../../../dashboard.php" target="_blank">
        <span class="ms-1 font-weight-bold text-white">JEEWAKA MEDICAL CENTER</span>
      </a>
    </div>


    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <hr class="horizontal light mt-0 mb-2">


        <li class="nav-item mb-2 mt-0">
          <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
            <i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">receipt_long</i>
            <span class="nav-link-text ms-2 ps-1">REPORTS</span>
          </a>
          <div class="collapse" id="ProfileNav" style="">
            <ul class="nav ">
              <li class="nav-item" <?php if ($fullName != 'RAVI  NANAYAKKARA') {
                                      echo 'hidden';
                                    } ?>>
                <a class="nav-link text-white" href="./saleReport.php">
                  <span class="sidenav-mini-icon"> S </span>
                  <span class="sidenav-normal  ms-3  ps-1">SALE REPORT</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white " href="./grnView.php">
                  <span class="sidenav-mini-icon"> GRN </span>
                  <span class="sidenav-normal  ms-3  ps-1">GRN REPORT</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="./reports.php" target="_blank">
            <i class=" fa fa-user "></i>
            <span class="nav-link-text ms-2 ps-1">USERS</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./patients.php" target="_blank">
            <i class=" fa fa-user "></i>
            <span class="nav-link-text ms-2 ps-1">PATIENTS</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./items.php" target="_blank">
            <i class="bi bi-capsule"></i>
            <span class="nav-link-text ms-2 ps-1">ITEMS</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./medicalRep.php" target="_blank">
            <i class="bi bi-building"></i>
            <span class="nav-link-text ms-2 ps-1">MEDICAL REP</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./companies.php" target="_blank">
            <i class="bi bi-building"></i>
            <span class="nav-link-text ms-2 ps-1">COMPANIES</span>
          </a>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link text-white " aria-controls="dashboardsExamples" role="button" aria-expanded="false">
            <i class="material-icons-round opacity-10">inventory</i>
            <span class="nav-link-text ms-2 ps-1">INVENTORY</span>
          </a>
          <div class="collapse" id="dashboardsExamples">
            <ul class="nav ">
              <li class="nav-item ">
                <a class="nav-link text-white " href="./grn.php">
                  <span class="sidenav-mini-icon"> G</span>
                  <span class="sidenav-normal  ms-2  ps-1"> GRN </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link text-white " href="./stock.php">
                  <span class="sidenav-mini-icon"> S</span>
                  <span class="sidenav-normal  ms-2  ps-1"> STOCK </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white " href="./orderForcast.php">
                  <span class="sidenav-mini-icon">C</span>
                  <span class="sidenav-normal  ms-3  ps-1">ORDER FORCAST</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./logs.php" target="_blank">
            <i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">receipt_long</i>
            <span class="nav-link-text ms-2 ps-1">logs</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">

        <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
          <a href="javascript:;" class="nav-link text-body p-0">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </div>



        <ul class="navbar-nav  justify-content-start">
          <li class="nav-item px-3">
            <h5 class="mb-0">MEDICAL REP</h5>
          </li>

          <li class="nav-item px-3">

          </li>
        </ul>
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
        <ul class="navbar-nav  justify-content-end">
          <li class="nav-item px-3">
            <button class="btn bg-gradient-info btn-sm mb-0" id="download"> <i class="fa fa-arrow-down" aria-hidden="true"></i> REP DETAILS</button>
          </li>
          <li class="nav-item px-3">
            <button class="btn bg-gradient-info btn-sm mb-0" id="downloadRepItems"><i class="fa fa-arrow-down" aria-hidden="true"></i> REP ITEM DETAILS</button>
          </li>
          <li class="nav-item px-3">
            <a class="btn bg-gradient-info btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addUserModal">+&nbsp; NEW REP</a>
          </li>
          <li class="nav-item px-3">
            <a href="../../../../index.php" class="nav-link text-body p-0" data-toggle="tooltip" data-placement="top" title="Log Out">
              <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <table id="repItemTable" hidden>
      <thead>
        <tr>
          <td>ITEM</td>
          <td>BILL B</td>
          <td>MR B</td>
          <td>CASH B</td>
          <td>DATE</td>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>

    <div class="card  ">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
          </div>
          <div class="ms-auto  my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto ">
              <form methq="post" id="addUserForm">
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                  <div class="modal-dialog  modal-xl ">

                    <div class="modal-content w-100">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">ADD REP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="container">
                          <div class="row mt-1">

                            <div class="col-9">
                              <input class="form-control" type='text' id="id" hidden>
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label>CODE :</label>
                            </div>
                            <div class="col-9">
                              <input type='text' id="code">
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label>NAME :</label>
                            </div>
                            <div class="col-9">
                              <input type='text' id="repName" required>
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label>COMPANY :</label>
                            </div>
                            <div class="col-6">
                              <select id="company">
                                <option>SELECT</option>
                              </select>
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label>TEL :</label>
                            </div>
                            <div class="col-9">
                              <input type='number' id="tel" required>
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label>SPONSE DATE:</label>
                            </div>
                            <div class="col-9">
                              <input type='date' id="sponsor_Due_Date">
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label>SPONSE VALUE:</label>
                            </div>
                            <div class="col-9">
                              <input type='text' id="sponsor_Value">
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label>REMARKS:</label>
                            </div>
                            <div class="col-9">
                              <input type='text' id="remarks">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                        <button type="button" onclick="updateMedicalRep()" class="btn btn-info" id="saveUser">DONE</button>
                      </div>
                    </div>
                    <!-- Add more input fields for other user information as needed -->
                  </div>

              </form>
            </div>
          </div>



          <div class="ms-auto  my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto ">
              <!-- <a class="btn bg-gradient-info btn-sm mb-0"  data-bs-toggle="modal" data-bs-target="#repItemModal" >+&nbsp; NEW REP</a> -->
              <form methq="post" id="addUserForm">
                <div class="modal fade" id="repItemModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable  modal-xl ">

                    <div class="modal-content w-100">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">ADD REP ITEMS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="container">
                          <div class="row mt-3">
                            <div class="col-12">
                              <input class="form-control" type='number' id='repMediID' hidden>
                              <table class="table table-responsive-sm ">
                                <thead>
                                  <tr>
                                    <th>ITEM</th>
                                    <th>B BONUS</th>
                                    <th>MR BONUS</th>
                                    <th>C BONUS</th>
                                    <th>ACTION</th>
                                  </tr>
                                </thead>
                                <tbody id="repItemModelBody">
                                  <!-- User rows will be dynamically added here -->
                                </tbody>
                              </table>
                              <div class="text-end">
                                <button type="button" class="btn btn-transparent" id="addRepItemRow"> <i class="bi bi-plus-lg"></i> ADD ITEMS </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                        <button type="button" class="btn btn-info" id="saveMedicines">DONE</button>
                      </div>
                    </div>
                    <!-- Add more input fields for other user information as needed -->
                  </div>

              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table id="dataTable" class="table table-sm text-sm ">
          <thead>
            <tr>
              <th>ID</th>
              <th>Code</th>
              <th>Name</th>
              <th>company</th>
              <th>Tel</th>
              <th>Sponsor_Due_Date</th>
              <th>Sponsor_Value</th>
              <th>Remarks</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Table rows will be dynamically populated -->
          </tbody>
        </table>

      </div>

      <div class="modal fade" id="repSponseModel" tabindex="-1" aria-labelledby="repSponseModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="repSponseModelLabel">SPONSE DETAILS</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="repSponseMediID" />
              <table id="repSponseModelTable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>GIVEN DATE</th>
                    <th>SPONSE VALUE</th>
                  </tr>
                </thead>
                <tbody id="repSponseModelTbody">
                  <!-- Rows will be added here dynamically -->
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3" class="text-end"><button class="btn" type="button" onclick="addSponseRow()" id="addSponseRow"> <i class="fa fa-plus" aria-hidden="true"></i> </button></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" id="sponseClose" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
              <button type="button" id="sponseDone" onclick="saveSponse()" class="btn btn-secondary" data-bs-dismiss="modal">DONE</button>
            </div>
          </div>
        </div>
      </div>


    </div>





    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.7/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>




    <script>
      fetch('../../../../attributes/fetchMediRepItem.php')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          const tbody = document.querySelector("#repItemTable tbody");

          data.sort((a, b) => a.mediItem.localeCompare(b.mediItem));

          data.forEach(item => {
            const row = document.createElement("tr");

            const itemCell = document.createElement("td");
            itemCell.textContent = item.mediItem;
            row.appendChild(itemCell);

            const billBCell = document.createElement("td");
            billBCell.textContent = item.bb;
            row.appendChild(billBCell);

            const mrBCell = document.createElement("td");
            mrBCell.textContent = item.mrBonus;
            row.appendChild(mrBCell);

            const cashBCell = document.createElement("td");
            cashBCell.textContent = item.cashBonus;
            row.appendChild(cashBCell);

            const dateCell = document.createElement("td");
            dateCell.textContent = item.created_at;
            row.appendChild(dateCell);

            tbody.appendChild(row);
          });
        })
        .catch(error => {
          console.error('There was a problem with the fetch operation:', error);
        });


      document.getElementById('downloadRepItems').addEventListener('click', () => {
        const {
          jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({
          html: '#repItemTable',
          headStyles: {
            fillColor: [0, 0, 0]
          },
          styles: {
            cellPadding: 0.5,
            fontSize: 8
          },
          theme: 'striped'
        });


        const currentDate = new Date().toISOString().split('T')[0];
        const fileName = `REP ITEM ${currentDate}.pdf`;
        doc.save(fileName);

      });

      document.getElementById('download').addEventListener('click', function() {
        const {
          jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        // Fetch the table element
        const dataTable = document.getElementById('dataTable');

        // Extract the headers
        const headers = [];
        dataTable.querySelectorAll('thead th').forEach((th, index) => {
          if (index === 8) { // Skip the "Actions" column
            headers.push(''); // Add an empty header
          } else {
            headers.push(th.textContent.trim());
          }
        });

        // Extract the data rows
        const data = [];
        dataTable.querySelectorAll('tbody tr').forEach(row => {
          const rowData = [];
          row.querySelectorAll('td').forEach((td, index) => {
            if (index === 8) { // Skip the "Actions" column
              rowData.push(''); // Add an empty cell
              rowData.push(''); // Add an empty cell
            } else {
              rowData.push(td.textContent.trim());
            }
          });
          data.push(rowData);
        });

        // Use autoTable to generate the table in the PDF
        doc.autoTable({
          head: [headers],
          body: data,
          startY: 20, // Start position for the table
          theme: 'striped', // Styling theme for the table
          headStyles: {
            fillColor: [22, 160, 133]
          }, // Header styling
          styles: {
            cellPadding: 2,
            fontSize: 8
          }, // General styling
          margin: {
            top: 20
          }
        });

        const currentDate = new Date().toISOString().split('T')[0];
        const fileName = `MR Report ${currentDate}.pdf`;
        doc.save(fileName);
      });



      function sponseDetails(rowIdx) {
        var table = $('#dataTable').DataTable();
        var rowData = table.row(rowIdx).data();
        var repSponseMediID = rowData[0];
        document.getElementById('repSponseMediID').value = repSponseMediID;
        let myModal = new bootstrap.Modal(document.getElementById('repSponseModel'), {
          keyboard: false
        });
        myModal.show();
        //console.log("View row: " + rowIdx + " and id is " + repSponseMediID);

        fetch('../../../../attributes/fetchRepSponse.php')
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            const matchingData = data.filter(item => item.repID == repSponseMediID);
            console.log("Matching data: ", matchingData);

            const tableBody = document.getElementById("repSponseModelTbody");
            tableBody.innerHTML = '';

            matchingData.forEach(item => {
              addSponseRow(item);
            });
          })
          .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Something went wrong. Please contact the developer.');

          });
      }

      function addSponseRow(item = {}) {
        const tableBody = document.getElementById("repSponseModelTbody");
        const row = document.createElement("tr");

        const idCell = document.createElement("td");
        const idInput = document.createElement("input");
        idInput.type = "text";
        idInput.className = "form-control";
        idInput.value = item.id || ''; // Set value if item is provided, else empty
        if (item.id) idInput.readOnly = true; // Make input readonly if item is provided
        idCell.appendChild(idInput);
        row.appendChild(idCell);

        const dateCell = document.createElement("td");
        const dateInput = document.createElement("input");
        dateInput.type = "date";
        dateInput.className = "form-control text-center";
        dateInput.value = item.sponseDate || ''; // Set value if item is provided, else empty
        if (item.sponseDate) dateInput.readOnly = true; // Make input readonly if item is provided
        dateCell.appendChild(dateInput);
        row.appendChild(dateCell);

        const valueCell = document.createElement("td");
        const valueInput = document.createElement("input");
        valueInput.type = "text";
        valueInput.className = "form-control text-end";
        valueInput.value = item.sponseValue || ''; // Set value if item is provided, else empty
        if (item.sponseValue) valueInput.readOnly = true; // Make input readonly if item is provided
        valueCell.appendChild(valueInput);
        row.appendChild(valueCell);

        tableBody.appendChild(row);
      }

      function saveSponse() {
        const tableBody = document.getElementById("repSponseModelTbody");
        const rows = tableBody.getElementsByTagName("tr");
        const newData = [];

        for (let i = 0; i < rows.length; i++) {
          const idInput = rows[i].querySelector("td:nth-child(1) input");
          const dateInput = rows[i].querySelector("td:nth-child(2) input");
          const valueInput = rows[i].querySelector("td:nth-child(3) input");

          if (!idInput.readOnly && dateInput.value && valueInput.value) {
            newData.push({
              repID: document.getElementById('repSponseMediID').value,
              sponseDate: dateInput.value,
              sponseValue: valueInput.value
            });
          }
        }

        if (newData.length > 0) {
          fetch('../../../../attributes/updateRepSponse.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(newData)
            })
            .then(response => response.json())
            .then(data => {
              alert('Success:', data);
              location.reload();
              // Optionally, you can reload the table data here or give user feedback
            })
            .catch((error) => {
              console.error('Error:', error);
              alert('DATA NOT SAVED. PLEASE CONTACT DEVELOPER');

            });
        }
      }









      document.getElementById('saveMedicines').addEventListener('click', submitRepMedicines);


      function submitRepMedicines() {
        // Get the table body
        const repMediID = document.getElementById('repMediID').value;
        const tableBody = document.getElementById('repItemModelBody');

        // Initialize an array to hold the user input data
        let userData = [];

        // Loop through each row in the table body
        for (let i = 0; i < tableBody.rows.length; i++) {
          const row = tableBody.rows[i];

          // Get the values from the input fields and dropdown in the current row
          const mediItem = row.querySelector(`select[name="mediitems"]`).value;
          const bBonus = row.querySelector(`input[id^='bBonus_']`).value;
          const mrBonus = row.querySelector(`input[id^='mrBonus_']`).value;
          const cBonus = row.querySelector(`input[id^='cBonus_']`).value;

          // Add the row data to the userData array
          userData.push({
            repMediID: repMediID,
            mediItem: mediItem,
            bBonus: bBonus,
            mrBonus: mrBonus,
            cBonus: cBonus
          });
        }
        //body: JSON.stringify(userData)

        // console.log('Sending Data :',JSON.stringify(userData));

        // Send the collected data to updateRepItems.php
        fetch('../../../../attributes/updateRepItems.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(userData)
          })
          .then(response => response.text())
          .then(data => {
            console.log('Response from server:', data);
            const [repMediID, mediItem] = data.split('\n').map(line => line.split(': ')[1]);
            alert(`success`);
            window.location.href = '';

          })
          .catch(error => {
            console.error('Error:', error);
          });
      }








      let rowCounter = 0; // Initialize the row counter

      function addMediRow(item = {}) {
        var tableBody = document.getElementById("repItemModelBody");

        // Increment the row counter
        rowCounter++;

        // Create a new row element
        var newRow = document.createElement("tr");
        newRow.setAttribute('id', `row_${rowCounter}`); // Set an ID for the new row

        // Define the HTML content for the new row
        newRow.innerHTML = `
        <td hidden ><input class="form-control" type='text' id='id_${rowCounter}' value='${item.id || ''}'></td>
        <td>
            <select class="form-select" name="mediitems" id="mediItems_${rowCounter}">
            <option>SELECT</option>
            </select>
        </td>
        <td><input class="form-control" type='text' id='bBonus_${rowCounter}' value='${item.bb || ''}'></td>
        <td><input class="form-control" type='text' id='mrBonus_${rowCounter}' value='${item.mrBonus || ''}'></td>
        <td><input class="form-control" type='number' id='cBonus_${rowCounter}' value='${item.cashBonus || ''}'></td>
        <td> <i class="bi bi-trash" onclick="deleteRepItem(${rowCounter})" aria-hidden="false"></i>  </td>
    `;

        // Append the new row to the table body
        tableBody.appendChild(newRow);

        // Get the select element
        const select = document.getElementById(`mediItems_${rowCounter}`);

        // Fetch data from the server for the new dropdown
        fetch('../../../../attributes/fetchMedi4Grn.php')
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }

            return response.json();
          })
          .then(data => {
            // Format data for Choices.js
            const formattedData = data.map(mediItem => ({
              value: mediItem.name.trim(), // Ensure no white spaces in the value
              label: mediItem.name.trim() // Ensure no white spaces in the label
            }));

            // Initialize Choices.js with the fetched data for the new dropdown
            const choices = new Choices(select, {
              placeholder: true,
              searchEnabled: true,
              searchChoices: true,
              removeItemButton: true,
              choices: formattedData // Pass the formatted data to Choices.js
            });

            // If there's a matching item, set it as the selected value
            console.log('item.mediItem:', item.mediItem);

            if (item.mediItem) {
              const trimmedItem = item.mediItem.trim(); // Trim white spaces from item.mediItem
              console.log('trimmedItem:', trimmedItem);
              setTimeout(() => {
                // Check if the item exists in the choices
                const exists = formattedData.some(choice => choice.value === trimmedItem);
                if (exists) {
                  select.value = trimmedItem;
                  choices.setChoiceByValue(trimmedItem);
                  console.log('Item set:', trimmedItem);
                } else {
                  console.warn('Item not found in choices:', trimmedItem);
                }
              }, 100); // Delay to ensure Choices.js is fully initialized
            }
          })
          .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('PLEASE CHECK YOUR INTERENET CONNECTION OR CONTACT DEVELOPER.');
          });
      }


      function deleteRepItem(rowId) {
        const repMediID = document.getElementById('repMediID').value;

        const row = document.getElementById(`row_${rowId}`);
        if (row) {
          const bounsId = document.getElementById(`id_${rowId}`).value;
          console.log(`Deleting row ${rowId} with mediItem: ${bounsId}`);

          // Confirm before deleting
          if (confirm('Are you sure you want to delete this?')) {
            row.remove();

            const id = 'repCode';
            const idValue = repMediID;
            const table = 'rep_items';
            const primaryKey = 'id';
            const primaryKeyValue = bounsId;

            // Create a FormData object to send data via POST request
            const formData = new FormData();

            // Append individual fields to the FormData object
            formData.append('id', id);
            formData.append('idValue', idValue);
            formData.append('table', table);
            formData.append('primaryKey', primaryKey);
            formData.append('primaryKeyValue', primaryKeyValue);


            console.log('formData', id, idValue, table, primaryKey, primaryKeyValue);

            // Make an AJAX POST request to the PHP script
            fetch('../../../../attributes/deleteRepItems.php', {
                method: 'POST',
                body: formData
              })
              .then(response => {
                if (response.ok) {
                  console.log('response', response);

                  // Handle success response if needed
                  alert(id + ' is deleted successfully!');
                  // Optionally, you can redirect to another page after successful deletion
                 // window.location.href = '';
                } else {
                  // Handle error response if needed
                  alert('Something went wrong. Please contact the developer.');
                  console.error('Error deleting row:', response.statusText);
                }
              })
              .catch(error => {
                alert('Something went wrong. Please contact the developer.');
                console.error('Error deleting row:', error);
              });
          }
        } else {
          console.error(`Row with ID row_${rowId} not found.`);
        }
      }

      function viewRow(rowIdx) {
        var table = $('#dataTable').DataTable();
        // Get the data for the selected row
        var rowData = table.row(rowIdx).data();
        var repMediID = rowData[0];
        document.getElementById('repMediID').value = repMediID;
        let myModal = new bootstrap.Modal(document.getElementById('repItemModal'), {
          keyboard: false
        });
        myModal.show();
        // console.log("View row: " + rowIdx);

        // Fetch data from the server
        fetch('../../../../attributes/fetchMediRepItem.php') // Update the path to your actual PHP script
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {

            //  console.log('Fetch Medi rep items',data)
            // Find data where repCode matches repMediID
            const matchingData = data.filter(item => item.repCode == repMediID);
            //  console.log("Matching data: ", matchingData);

            // Clear the existing rows in the modal table body
            const tableBody = document.getElementById("repItemModelBody");
            tableBody.innerHTML = '';

            // Populate the table with matching data
            matchingData.forEach(item => {
              // console.log('item.id',item.id)
              addMediRow(item);
            });
          })
          .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
          });
      }

      var id = document.getElementById('id');
      var code = document.getElementById('code');
      var company = document.getElementById('company');
      var tel = document.getElementById('tel');
      var repName = document.getElementById('repName');
      var sponseDate = document.getElementById('sponsor_Due_Date');
      var sponseValue = document.getElementById('sponsor_Value');
      var remarks = document.getElementById('remarks');


      function updateMedicalRep() {

        //console.log('repName',repName.value)

        var formData = new FormData();
        formData.append('id', id.value);
        formData.append('code', code.value);
        formData.append('company', company.value);
        formData.append('tel', tel.value);
        formData.append('name', repName.value);
        formData.append('sponseDate', sponseDate.value);
        formData.append('sponseValue', sponseValue.value);
        formData.append('remarks', remarks.value);

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('POST', '../../../../attributes/updateMedicalRep.php', true);

        // Define what happens on successful data submission
        xhr.onload = function() {
          // Handle response here
          alert(this.responseText);
          location.reload();
        };

        // Send the form data
        xhr.send(formData);


      };

      document.addEventListener("DOMContentLoaded", function() {
        // Find the button element
        var addMediRowButton = document.getElementById("addRepItemRow");

        addMediRowButton.addEventListener("click", function() {
          // Get the table body element
          addMediRow();

        });


        var addButton = document.getElementById("addRepRow");

        // Add click event listener to the button
        addButton.addEventListener("click", function() {
          // Get the table body element
          var tableBody = document.getElementById("repModelBody");

          // Create a new row element
          var newRow = document.createElement("tr");

          // Define the HTML content for the new row
          newRow.innerHTML = `
            <td><input class="form-control" type = 'text' id='code_0' ></td>
            <td><input class="form-control" type = 'text' id='name_0'></td>
            <td><input class="form-control" type = 'text' id='company_0'></td>
            <td><input class="form-control" type = 'number' id='tell_0'></td>
    
        `;

          // Append the new row to the table body
          tableBody.appendChild(newRow);
        });
      });


      $(document).ready(function() {
        $.ajax({
          url: '../../../../attributes/fetchMedicalRep.php',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            // Log the fetched data
            // console.log(response);

            // Pass fetched data to data array
            var data = response.map(function(row) {
              var sponseDate = row.sponserDueDate; // Initialize sponseDate with the value of row.sponserDueDate
              var sponseValue = row.sponserValue; // Initialize sponseDate with the value of row.sponserDueDate

              if (sponseDate == '0000-00-00') {
                sponseDate = '';
              }
              if (sponseValue == '0') {
                sponseValue = '';
              }
              return [
                row.id,
                row.code,
                row.name,
                row.company,
                row.tel,
                sponseDate,
                sponseValue,
                row.remarks
              ];
            });

            //console.log('data',data)

            // Initialize DataTable with fetched data
            var table = $('#dataTable').DataTable({
              data: data,
              columns: [{
                  title: "ID"
                },
                {
                  title: "Code"
                },
                {
                  title: "Name"
                },
                {
                  title: "Company"
                },
                {
                  title: "Tel"
                },
                {
                  title: "Sponsor_Due_Date"
                },
                {
                  title: "Sponsor_Value"
                },
                {
                  title: "Remarks"
                },
                {
                  title: "Actions",
                  className: "text-center",
                  render: function(data, type, row, meta) {
                    return '<td class="text-end" ><button class="btn" data-bs-toggle="modal" data-bs-target="#addUserModal" onclick="editRow(' + meta.row + ')">EDIT<i class="fa fa-pencil" aria-hidden="true"></i> </button>' +
                      '<button class="btn ms-1 " onclick="viewRow(' + meta.row + ')">View Items <i class="fa fa-eye" aria-hidden="true"></i> </button>' +
                      '<button class="btn ms-1"  onclick="sponseDetails(' + meta.row + ')"> Sponsor Details <i class="fa fa-eye" aria-hidden="true"></i> </button>' +
                      '<button class="btn ms-1"  onclick="deleteRow(' + meta.row + ')">Delete <i class="fa fa-trash" aria-hidden="true"></i>  </button></td>';
                  }
                }
              ],
              lengthMenu: [
                [100, 500, 1000],
                [100, 500, 1000]
              ] // Set the row display options
            });
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER')
          }
        });
      });





      let choicesInstance;

      document.addEventListener('DOMContentLoaded', function() {
        const companySelect = document.getElementById('company');
        choicesInstance = new Choices(companySelect, {
          searchEnabled: true,
          placeholderValue: 'SELECT'
        });

        fetchCompanies(choicesInstance);
      });

      function fetchCompanies(choices) {
        fetch('../../../../attributes/fetchCompanies.php')
          .then(response => response.json())
          .then(data => {
            if (data.error) {
              console.error('Error:', data.error);
            } else if (data.message) {
              //console.log(data.message);
            } else {
              const companyOptions = data.map(company => ({
                value: company.code, // Assuming 'id' is a unique identifier for the company
                label: company.name // Assuming 'name' is the name of the company
              }));

              choices.setChoices(companyOptions, 'value', 'label', true);
            }
          })
          .catch(error => console.error('Error fetching companies:', error));
      }

      function editRow(rowIdx) {
        // Get the DataTable instance
        var table = $('#dataTable').DataTable();
        // Get the data for the selected row
        var rowData = table.row(rowIdx).data();

        document.getElementById('id').value = rowData[0];
        document.getElementById('code').value = rowData[1];
        document.getElementById('tel').value = rowData[4];
        document.getElementById('repName').value = rowData[2];
        document.getElementById('sponsor_Due_Date').value = rowData[5];
        document.getElementById('sponsor_Value').value = rowData[6];
        document.getElementById('remarks').value = rowData[7];

        // Set the selected value
        choicesInstance.setChoiceByValue(rowData[3]);

        //console.log('rowData', rowData);
      }

      function deleteRow(rowIdx) {
        // Implement delete functionality here

        //confirm('ARE YOU GOING TO DELETE THIS?');



        // Get the DataTable instance
        var table = $('#dataTable').DataTable();
        // Get the data for the selected row
        var rowData = table.row(rowIdx).data();
        id = rowData[0];
        primaryKey = 'id';
        table = 'medical_rep';

        var formData = new FormData();
        formData.append('id', id);
        formData.append('primaryKey', primaryKey);
        formData.append('table', table);


        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('POST', '../../../../attributes/delete.php', true);

        // Define what happens on successful data submission
        xhr.onload = function() {
          // Handle response here

          id = rowData[0];
          primaryKey = 'repCode';
          table = 'rep_items';

          var ItemsFormData = new FormData();
          ItemsFormData.append('id', id);
          ItemsFormData.append('primaryKey', primaryKey);
          ItemsFormData.append('table', table);


          // Create a new XMLHttpRequest object
          var xhr = new XMLHttpRequest();

          // Set up the request
          xhr.open('POST', '../../../../attributes/delete.php', true);

          // Define what happens on successful data submission
          xhr.onload = function() {
            // Handle response here
            alert(this.responseText);
            location.reload();
          };

          // Send the form data
          //xhr.send(ItemsFormData);



        };

        if (confirm('ARE YOU GOING TO DELETE THIS REP..?')) {

          xhr.send(formData);
          location.reload();
        } else {
          //alert('OK');

        }
        // Send the form data


        // console.log("Delete row: " + rowIdx);
      }
    </script>



    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <footer class="footer py-4  ">
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
  <!--   Core JS Files   -->
  <script src="../../../assets/js/core/popper.min.js"></script>
  <script src="../../../assets/js/core/bootstrap.min.js"></script>
  <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../../../assets/js/plugins/datatables.js"></script>

  <!-- Kanban scripts -->
  <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>

  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
</body>

</html>