
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
    MEDICINES REPORT
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
              <a class="nav-link active" href="./companies.php" target="_blank"> 
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
          <div class="card  ">
            <!-- Card header -->
            <div class="card-header pb-0">
              <div class="d-lg-flex">
                <div>
                  <h5 class="mb-0">STOCK</h5>
                </div>
                <div class="ms-auto  my-auto mt-lg-0 mt-4">
                  <div class="ms-auto my-auto ">
                   <!-- <a class="btn bg-gradient-info btn-sm mb-0" href="./newGrn.php"   >+&nbsp; NEW GRN</a>-->
                   <input type="text" id="search-input" class=" form-control " placeholder="Search for Items..">
                </div>
              </div>
              <button type="button" id="export" class="btn btn-dark">EXPORT</button>
            </div>
           <!-- <button class="btn btn-outline-info btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button>-->

        </div>
        
    
           
            <div class="card-body px-0 pb-0">

              <div class="table-responsive">
              <table class="table table-bordered " id="products-list">
                  <thead class="thead-light">
                    <tr>
                      <th>ID</th>
                      <th>NAME</th>
                      <th>GENERIC</th>
                      <th>EXPIRE DATE</th>
                      <th>MEDI REP</th>
                      <th>RETAIL P</th>
                      <th>SALE%</th>
                      <th>PROFIT%</th>
                      <th >QTY</th> 
                    </tr>
                  </thead>
                  <tbody>
                  
                    
                  </tbody>
                  <tfoot>
                    
                  </tfoot>
                </table>
                <div id="spinner-overlay" class=" hidden ">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

                
<!-- Modal -->


                
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script>




    document.getElementById('search-input').addEventListener('keyup', function() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById('search-input');
        filter = input.value.toUpperCase();
        table = document.getElementById('products-list');
        tr = table.getElementsByTagName('tr');

        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = 'none';
            td = tr[i].getElementsByTagName('td');
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                        break;
                    }
                }
            }
        }
    });

    // Public array to hold the combined data
    let tableData = [];

    // Function to fetch data from the medicines endpoint
    function fetchMedicines() {
        fetch('../../../../attributes/fetchMedi4Grn.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(medicines => {
                // Log name, mediName, and qt to the console
                medicines.forEach(medicine => {
                    // console.log(`NAME: ${medicine.name}, GENERIC: ${medicine.mediName}, QTY: ${medicine.qt}`);
                    tableData.push({
                        id  : medicine.id,
                        name: medicine.name,
                        generic: medicine.mediName,
                        qty: medicine.qt,
                        mediRep: null,
                        saleP: null,
                        profitP: null,
                        expiryDate: null, // Initialize with null
                        cost: null // Initialize with null
                    });
                });
                // Fetch GRN products after medicines data is processed
                fetchGrnProducts();
            })
            .catch(error => {
                console.error('Error fetching medicines:', error);
            });
    }

    // Function to fetch data from the grnproducts endpoint
    function fetchGrnProducts() {
        fetch('../../../../attributes/fetchGrnProducts.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(grnProducts => {
                // Process grnProducts to keep only the newest entries
                const productMap = new Map();
                grnProducts.forEach(product => {
                    const key = `${product.name.trim().toLowerCase()}|${product.generic.trim().toLowerCase()}`;
                    if (!productMap.has(key) || new Date(product.created_at) > new Date(productMap.get(key).created_at)) {
                        productMap.set(key, product);
                    }
                });

                // Convert the map back to an array
                const newestGrnProducts = Array.from(productMap.values());

                newestGrnProducts.forEach(product => {
                    // Match products with tableData
                    tableData.forEach(item => {
                        if (item.name.trim().toLowerCase() === product.name.trim().toLowerCase() &&
                            item.generic.trim().toLowerCase() === product.generic.trim().toLowerCase()) {
                            item.mediRep = product.mediRep;
                            item.expiryDate = product.expiryDate;
                            item.saleP = product.sp;
                            item.profitP = product.profit;
                            item.cost = product.retailP; // Assuming 'costPI' is the cost from fetchGrnProducts
                        }
                    });
                });

                // Render the table after processing the data
                renderTable();
            })
            .catch(error => {
                console.error('Error fetching GRN products:', error);
            });
    }

    // Function to check if the expiry date is within the next month
    function isExpiringSoon(expiryDate) {
    if (!expiryDate) return false;

    const [month, year] = expiryDate.split('/').map(Number);
    console.log('month,year', month, year);

    const now = new Date();
    const currentYear = now.getFullYear() % 100; // Get the last two digits of the current year

    // Adjust the year to be in the 21st century (2000s) if necessary
    const fullYear = (year < 50 ? 2000 + year : 1900 + year);

    const expiry = new Date(fullYear, month - 1);
    const nextMonth = new Date(now.getFullYear(), now.getMonth() + 1);

    console.log('fullYear', fullYear);
    console.log('expiry', expiry);
    console.log('nextMonth', nextMonth);

    const expiring = expiry <= nextMonth;
    console.log('expiring', expiring);

    return expiring;
}



    // Function to render table rows
    function renderTable() {
        const tbody = document.querySelector("#products-list tbody");
        tbody.innerHTML = ""; // Clear previous content
        
        tableData.forEach(item => {
            const tr = document.createElement("tr");

            if (isExpiringSoon(item.expiryDate)) {
                tr.classList.add('expiring-soon');
            }
            if (item.qty == null){
              item.qty = 0;
            }
            if (item.qty<=0){
              tr.classList.add('outOfStock');
            }
           
            

            tr.innerHTML = `
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.generic}</td>
                <td style="text-align:center;">${item.expiryDate || ""}</td>
                <td style="text-align:center;">${item.mediRep || ""}</td>
                <td style="text-align:center;">${item.cost || ""}</td>
                <td style="text-align:center;">${item.saleP || ""}</td>
                <td style="text-align:center;">${item.profitP || ""}</td>
                <td style="text-align:center;">${item.qty}</td>
            `;
            tbody.appendChild(tr);
        });

        // Initialize DataTable
        //$('#products-list').DataTable();
    }

    // Call fetchMedicines function to fetch and process the data
    fetchMedicines();
    document.getElementById('export').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');
            const table = document.getElementById('products-list');

            const rowsPerPage = 50; // Number of rows per page
            const rows = table.querySelectorAll('tbody tr');
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            const hiddenDiv = document.createElement('div');
            hiddenDiv.classList.add('spinner-overlay');
            document.body.appendChild(hiddenDiv);

            let processedPages = 0;

            function capturePage(pageIndex) {
                const startRow = pageIndex * rowsPerPage;
                const endRow = startRow + rowsPerPage;
                const pageRows = Array.from(rows).slice(startRow, endRow);

                const pageTable = document.createElement('table');
                pageTable.classList.add('table', 'table-bordered');
                pageTable.innerHTML = table.querySelector('thead').outerHTML;
                const pageBody = document.createElement('tbody');

                pageRows.forEach(row => {
                    pageBody.appendChild(row.cloneNode(true));
                });
                pageTable.appendChild(pageBody);

                hiddenDiv.innerHTML = '';
                hiddenDiv.appendChild(pageTable);

                setTimeout(() => {
                    html2canvas(pageTable, {
                        useCORS: true,
                        scale: 2
                    }).then(canvas => {
                        const imgData = canvas.toDataURL('image/png');
                        const imgWidth = doc.internal.pageSize.getWidth();
                        const imgHeight = canvas.height * imgWidth / canvas.width;

                        if (pageIndex > 0) {
                            doc.addPage();
                        }
                        doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

                        processedPages++;
                        if (processedPages === totalPages) {
                            doc.save('stock.pdf');
                            document.body.removeChild(hiddenDiv);
                        } else {
                            capturePage(pageIndex + 1);
                        }
                    }).catch(error => {
                        console.error('Error capturing page:', error);
                    });
                }, 500); // Delay to allow rendering
            }

            capturePage(0);
        });
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