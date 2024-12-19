

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
  <link rel="icon" type="image/png" href="../../../assets/img/favicon.png">
  <title>
    Reports
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

  </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
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
              <div class="d-lg-flex row">
                <div class="col-2 text-start" >
                    REPORTS
                </div>
                <div class="col-1 text-end form-label mt-2 " >
                    From :
                </div>
                <div class="col-2 text-start" >
                   <input type="date" id="from" name = "from" class="form-control" >
                </div>
                <div class="col-2 text-end form-label mt-2" >
                    To : 
                </div>
                <div class="col-2 text-start" >
                    <input type="date" id="to" name = "to" class="form-control" >
                </div>
                <div class="col-2 text-end ">
                <button class="btn btn-outline-info btn-sm export mt-sm-0 mt-1" id="buttonPDF" type="button" name="button">Export</button>
                </div>
            </div>
            </div>
            
              <div class="table-responsive" >
                <div id = "html2pdf" >
                    <table class="table table-flush" id="products-list">
                        <thead class="thead-light">
                            <tr>
                            <th>ID</th>
                            <th>Doctor Name</th>
                            <th>Nurse Name</th>
                            <th>JD</th>
                            <th>JMC</th>
                            <th>Total</th>
                            <th>Remain</th>
                            <th>Payment Method</th>
                            <th>Next Vist Date</th>
                            <th>Patient Name</th>
                            <th>DOB</th>
                            <th>SEX</th>
                            <th>Medical problem</th>
                            <th>Patient In</th>
                            <th>Patient Out</th>
                            </tr>
                        </thead>
                        <tbody id="tbody" >
                        </tbody>
                        <tfoot>
                            
                        </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-2 text-end mt-2  ">
                            <span class="label">Total Jd</span>
                            </div>
                            <div class="col-1 text-start">
                            <input class=" form-control " id ="jd" value="10" >
                            </div>
                        
                            <div class="col-2 text-end mt-2">
                            <span class="label">Total JMC</span>
                            </div>
                            <div class="col-1 text-start">
                            <input class=" form-control " id ="jmc" value="10" >
                            </div>
                    
                            <div class="col-2 text-end mt-2">
                            <span class="label">Total Remain</span>
                            </div>
                            <div class="col-1 text-start">
                            <input class=" form-control" id ="remain" value="10" >
                            </div>
                        
                            <div class="col-2 text-end mt-2">
                            <span class="label">Total </span>
                            </div>
                            <div class="col-1 text-start">
                            <input class=" form-control" id ="total" value="10" >
                            </div>
                        </div>
                </div>
                </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="../../../../attributes/html2pdf.bundle.min.js"></script>


                <script>



 // Function to fetch data from the server and populate the table
function fetchData() {
    fetch('../../../../attributes/docReport.php')
        .then(response => response.json())
        .then(data => {
            renderTable(data);
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Function to render the table with provided data
function renderTable(data) {
    const tableBody = document.getElementById('tbody');
    tableBody.innerHTML = '';

    data.forEach(row => {
        const newRow = document.createElement('tr');
        Object.values(row).forEach(value => {
            const cell = document.createElement('td');
            cell.textContent = value;
            newRow.appendChild(cell);
        });
        tableBody.appendChild(newRow);
    });

    const dataTableSearch = new simpleDatatables.DataTable("#products-list", {
        searchable: true,
        fixedHeight: false,
        perPage: 100
    });

    document.querySelectorAll(".export").forEach(function(el) {
        el.addEventListener("click", function(e) {
            var type = el.dataset.type;
            var data = {
                type: type,
                filename: "material-" + type,
            };
            if (type === "csv") {
                data.columnDelimiter = "|";
            }
            dataTableSearch.export(data);
        });
    });
}

// Function to calculate and display the sum of 'total' array key
// Function to calculate and display the sum of 'total', 'jd', 'jmc', and 'remain' array keys
function calculateAndDisplaySum(data) {
    const sumTotal = data.reduce((acc, cur) => {
        // Check if the value is a valid number before adding it to the accumulator
        const totalValue = parseInt(cur.total);
        return !isNaN(totalValue) ? acc + totalValue : acc;
    }, 0);
    
    const sumJD = data.reduce((acc, cur) => {
        const jdValue = parseInt(cur.jd);
        return !isNaN(jdValue) ? acc + jdValue : acc;
    }, 0);
    
    const sumJMC = data.reduce((acc, cur) => {
        const jmcValue = parseInt(cur.jmc);
        return !isNaN(jmcValue) ? acc + jmcValue : acc;
    }, 0);
    
    const sumRemain = data.reduce((acc, cur) => {
        const remainValue = parseInt(cur.remain);
        return !isNaN(remainValue) ? acc + remainValue : acc;
    }, 0);

    document.getElementById('jd').value = sumJD;
    document.getElementById('jmc').value =  sumJMC;
    document.getElementById('remain').value = sumRemain;
    document.getElementById('total').value = sumTotal;

    console.log("Sum of total:", sumTotal);
    console.log("Sum of jd:", sumJD);
    console.log("Sum of jmc:", sumJMC);
    console.log("Sum of remain:", sumRemain);
}


function filterDataByDate(fromDate, toDate, data) {
    if (!fromDate && !toDate) {
        return data;
    }
    const filteredData = data.filter(row => {
        const updatedAt = new Date(row.updated_at);
        const fromDateObj = new Date(fromDate);
        const toDateObj = new Date(toDate);
        return (!fromDate || updatedAt >= fromDateObj) && (!toDate || updatedAt <= toDateObj);
    });
    return filteredData;
}

// Function to handle date input change
function handleDateChange() {
    const fromDate = document.getElementById('from').value;
    const toDate = document.getElementById('to').value;
    fetchDataWithDateFilter(fromDate, toDate);
}

// Function to fetch data with date filter
function fetchDataWithDateFilter(fromDate, toDate) {
    fetch('../../../../attributes/docReport.php')
        .then(response => response.json())
        .then(data => {
            const filteredData = filterDataByDate(fromDate, toDate, data);
            renderTable(filteredData);
            calculateAndDisplaySum(filteredData); // Recalculate and display the sum
            console.log("filteredData",filteredData);
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Add event listeners to date input fields
document.getElementById('from').addEventListener('change', handleDateChange);
document.getElementById('to').addEventListener('change', handleDateChange);

// Initial fetch of data
window.onload = fetchData;






    document.getElementById('buttonPDF').onclick = function () {
        var element = document.getElementById('html2pdf');

        var opt = {
            margin: 2,
            filename: 'Jeewaka Medical Center.pdf',
            image: { type: 'png', quality: 1.50 },
            html2canvas: { scale: 2 }, // Adjust scale as needed
            jsPDF: {
                unit: 'mm',
                format: 'a2',
                orientation: 'landscape',
                fontSize: 1,
                lineHeight: 1,
                pageBreak: {
                    auto: true,
                    before: '.page-break',
                    after: '.page-break'
                }
            }
        };

        html2pdf(element, opt);
    }
</script>



              
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