


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
    LOGS
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
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/style.css">
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

.search-bar {
      margin-bottom: 15px;
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
              <span class="nav-link-text ms-2 ps-1">LOGS</span>
              </a>
              <div class="collapse" id="ProfileNav" style="">
                <ul class="nav ">
                <li class="nav-item">
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
              <a class="nav-link" href="./medicalRep.php" target="_blank"> 
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
                  <span class="sidenav-mini-icon"> C </span>
                  <span class="sidenav-normal  ms-3  ps-1"> ORDER FORCAST </span>
                </a>
              </li>
            </ul>
          </div>
        </li>
            <li class="nav-item">
              <a class="nav-link active" href="./logs.php" target="_blank">
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
            <a href="../../../../index.php" class="nav-link text-body p-0" data-toggle="tooltip" data-placement="top" title="Log Out" >
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
            <div class="search-bar row">
                <div class="col-9"></div>
                <div class="col-1 mt-2"> <label></label> </div>
                <div class="col-2"><input  class="form-control border-1  " type="text" id="search-input" placeholder="Search..."></div>
            </div>
            <div class="card-body px-0 pb-0">
              <div class="table-responsive">
              <table class="table table-responsive" id="products-list">
                  <thead class="thead-light">
                    <tr>
                      <th>ID</th>
                      <th>TASK</th>
                      <th>OTHER</th>
                      <th>DATE&TIME</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot> 
                  </tfoot>
                </table>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                <script>

                document.getElementById('search-input').addEventListener('keyup', function() {
                    const query = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#products-list tbody tr');
                    
                    rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let match = false;
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(query)) {
                        match = true;
                        }
                    });
                    row.style.display = match ? '' : 'none';
                    });
                });

                // Function to fetch data from fetchLogs.php
                async function fetchLogs() {
            try {
                const response = await fetch('../../../../attributes/fetchLogs.php');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.text();
                displayLogs(data);
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        function convertToSLST(dateTimeStr) {
            const utcDate = new Date(dateTimeStr + ' UTC');
            const offset = 5.5 * 60; // SLST is UTC+5:30, convert to minutes
            const slstDate = new Date(utcDate.getTime() + offset * 60000);
            return slstDate.toISOString().replace('T', ' ').split('.')[0];
        }

        function displayLogs(data) {
            const rows = data.split('<br>').filter(row => row.trim() !== '');
            const tableBody = document.querySelector('#products-list tbody');
            tableBody.innerHTML = ''; // Clear any existing rows
            
            const logEntries = rows.map(row => {
                const columns = row.split(' - ');
                const id = columns[0].split(': ')[1];
                const task = columns[1].split(': ')[1];
                const other = columns[2].split(': ')[1];
                const dateTime = columns[3].split(': ')[1];
                const slstDateTime = convertToSLST(dateTime);

                return {
                    id,
                    task,
                    other,
                    dateTime: slstDateTime,
                    originalDateTime: new Date(dateTime + ' UTC')
                };
            });

            // Sort log entries by the original UTC date-time in descending order
            logEntries.sort((a, b) => b.originalDateTime - a.originalDateTime);

            logEntries.forEach(entry => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${entry.id}</td>
                    <td>${entry.task}</td>
                    <td>${entry.other}</td>
                    <td>${entry.dateTime}</td>
                `;
                tableBody.appendChild(tr);
            });
        }

        fetchLogs();


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

  <!-- Kanban scripts -->
  <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../../assets/js/material-dashboard.min.js?v=3.0.6"></script>
</body>

</html>