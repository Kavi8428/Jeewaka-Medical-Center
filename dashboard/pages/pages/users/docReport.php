
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
  <img href="../../../assets/img/logo-ct.png">
  <title>
    DOC REPORT
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
    <!-- Include Handsontable JS -->
    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>



  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
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
.expiring-soon {
            background-color: red !important;
            color: white;
        }

.outOfStock{
            background-color: orange !important;
            color: white;
}
.hidden{
  display: none;
}
.spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
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
                <li class="nav-item" <?php if($fullName != 'RAVI  NANAYAKKARA'){echo 'hidden';} ?>>
                    <a class="nav-link  text-white" href="./saleReport.php">
                      <span class="sidenav-mini-icon"> S </span>
                      <span class="sidenav-normal  ms-3  ps-1">SALE REPORT</span>
                    </a>
                  </li>
                  <li class="nav-item active" <?php if($fullName != 'RAVI  NANAYAKKARA'){echo 'hidden';} ?>>
                    <a class="nav-link  text-white" href="">
                      <span class="sidenav-mini-icon"> S </span>
                      <span class="sidenav-normal  ms-3  ps-1">DOC REPORT</span>
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
   
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card  ">
            <!-- Card header -->
            <div class="card-header pb-0">
              <div class="d-lg-flex">
              <div>
                  <h5 class="mb-0">DOC REPORT</h5>
                </div>
                <div class=" text-sm mt-1 ms-5">MONTH :</div>
                <div class="mt-1 ms-2"> 
                    <select id="month">
                        <option value="1" >January</option>
                        <option value="2" >February</option>
                        <option value="3" >March</option>
                        <option value="4" >April</option>
                        <option value="5" >May</option>
                        <option value="6" >June</option>
                        <option value="7" >July</option>
                        <option value="8" >August</option>
                        <option value="9" >September</option>
                        <option value="10" >Octomber</option>
                        <option value="11" >November</option>
                        <option value="12" >December</option>
                    </select> 
                </div> 
                <div class="ms-4" > <button class=" btn btn-sm btn-info" type="button"  id="filter" >FILTER</button>  </div>  
                <div class="ms-auto  my-auto mt-lg-0">
                  <div class="ms-auto my-auto ">
                   <!-- <a class="btn bg-gradient-info btn-sm mb-0" href="./newGrn.php"   >+&nbsp; NEW GRN</a>-->
                   <input type="text" id="search-input" class=" form-control " placeholder="Search for Items..">
                </div>
              </div>
              <button type="button" id="export" class="btn btn-dark">DOWNLOAD</button>
            </div>
           <!-- <button class="btn btn-outline-info btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button>-->

        </div>
            <div class="card-body text-sm px-0 pb-0">

            </div>
              <div id="handsontableContainer">

              </div>
              
                <div id="spinner-overlay" class=" hidden ">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

                
<!-- Modal -->


                
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script>

const url = '../../../../attributes/fetchPatientDeta.php'; // Change this to the actual path of your PHP script

// Function to fetch data from the PHP script
async function fetchData() {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching data:', error);
            return null;
        }
    }

    // Function to filter data by selected month
    function filterDataByMonth(data, month) {
        if (!data) {
            console.error('No data to filter');
            return [];
        }

        return data.filter(item => {
            const createdDate = new Date(item.created_at);
            return createdDate.getMonth() + 1 === parseInt(month);
        });
    }

    // Function to group data by day and doctor, and calculate totals
    function groupDataByDayAndDoctor(data) {
        const groupedData = data.reduce((acc, item) => {
            const date = item.created_at.split(' ')[0]; // Extract the date part
            const doctor = item.doctor;
            const key = `${date}_${doctor}`; // Create a unique key for each date and doctor

            if (!acc[key]) {
                acc[key] = {
                    DATE_created_at: date,
                    doctor: doctor,
                    JD: 0,
                    JMC: 0,
                    REMAIN: 0
                };
            }
            acc[key].JD += parseFloat(item.jd) || 0;
            acc[key].JMC += parseFloat(item.jmc) || 0;
            acc[key].REMAIN += parseFloat(item.remain) || 0;

            return acc;
        }, {});

        // Convert grouped data to array for Handsontable
        const handsontableData = Object.values(groupedData).map(values => ({
            DATE_created_at: values.DATE_created_at,
            doctor: values.doctor,
            JD: values.JD,
            JMC: values.JMC,
            REMAIN: values.REMAIN,
            TOTAL: values.JD + values.JMC // Calculate total dynamically
        }));

        return handsontableData;
    }

    let hot;
        
    function initializeHandsontable(data) {
            const container = document.getElementById('handsontableContainer');
            if (hot) {
                hot.destroy(); // Destroy previous instance if exists
            }

            const totalJD = data.reduce((acc, item) => acc + parseFloat(item.JD || 0), 0);
            const totalJMC = data.reduce((acc, item) => acc + parseFloat(item.JMC || 0), 0);
            const totalRemain = data.reduce((acc, item) => acc + parseFloat(item.REMAIN || 0), 0);
            const totalSum = data.reduce((acc, item) => acc + parseFloat(item.TOTAL || 0), 0); // Calculate total sum

            data.push({
                DATE_created_at: '',
                doctor: '',
                JD: totalJD,
                JMC: totalJMC,
                REMAIN: totalRemain,
                TOTAL: totalSum
            }); // Add summary row

            hot = new Handsontable(container, {
                licenseKey: 'non-commercial-and-evaluation',  // Non-commercial use key
                data: data,
                columns: [
                    { data: 'DATE_created_at', title: 'DATE(A)' },
                    { data: 'doctor', title: 'DOCTOR(B)' },
                    { data: 'JD', title: 'JD(C)' },
                    { data: 'JMC', title: 'JMC(D)' },
                    { data: 'REMAIN', title: 'REMAIN(E)' },
                    { data: 'TOTAL', title: 'TOTAL(F)' }
                ],
                width: '100%',
                height: 'auto',
                rowHeaders: true,
                colHeaders: true,
                stretchH: 'all',
                height: 400,
                contextMenu: true,
                columnSorting: true,
                dropdownMenu: true,
                filters: true,
                search: true,
                manualColumnMove: true,
                manualColumnResize: true,
                comments: true,
                mergeCells: true,
                formulas: {
                    engine: HyperFormula
                },
                cells: function (row, col) {
                    const cellProperties = {};
                    if (row === data.length - 1) {
                        cellProperties.readOnly = true; // Make the summary row read-only
                        cellProperties.className = 'htBottom htRight'; // Style the summary row
                    }
                    if (col === 0) {
                        cellProperties.readOnly = true; // Make the date column read-only
                    }
                    return cellProperties;
                }
            });
        }


    // Event listener for the filter button
    document.getElementById('filter').addEventListener('click', async () => {
        const month = document.getElementById('month').value;
        const data = await fetchData();
        if (data) {
            const filteredData = filterDataByMonth(data, month);
            const groupedData = groupDataByDayAndDoctor(filteredData);
            initializeHandsontable(groupedData);
        } else {
            console.log('No data available to filter');
        }
    });

    // Function to export the data to PDF
    async function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const tableData = hot.getData();
        const columns = [
            { header: 'DATE', dataKey: 'DATE_created_at' },
            { header: 'doctor', dataKey: 'doctor' },
            { header: 'JD', dataKey: 'JD' },
            { header: 'JMC', dataKey: 'JMC' },
            { header: 'REMAIN', dataKey: 'REMAIN' },
            { header: 'TOTAL', dataKey: 'TOTAL' }
        ];

        doc.autoTable({
            head: [columns.map(col => col.header)],
            body: tableData.map(row => columns.map(col => row[columns.indexOf(col)])),
        });

        const currentDate = new Date().toISOString().split('T')[0];
        const fileName = `DR REPORT ${currentDate}.pdf`;
        doc.save(fileName);
    }

    // Event listener for the export button
    document.getElementById('export').addEventListener('click', exportToPDF);


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
  <script>
    
  </script>
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