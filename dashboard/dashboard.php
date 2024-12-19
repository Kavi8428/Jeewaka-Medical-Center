
<?php
session_start();

// Include connection file
require_once '../connection.php';

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
  header("Location: ../index.php ");
  exit();
}
?>





<!DOCTYPE html>
<html lang="en">
  <head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>
    ADMIN PANAL
</title>



<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

<!-- Nucleo Icons -->
<link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
<link href="./assets/css/nucleo-svg.css" rel="stylesheet" />

<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

<!-- CSS Files -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.0.6" rel="stylesheet" />

  </head>


  <body class="g-sidenav-show  bg-gray-100">
    

    

    
      <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
          <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
          <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard-pro/pages/dashboards/analytics.html " target="_blank">
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
                    <a class="nav-link text-white" href="./pages/pages/users/saleReport.php">
                      <span class="sidenav-mini-icon"> S </span>
                      <span class="sidenav-normal  ms-3  ps-1">SALE REPORT</span>
                    </a>
                  </li>
                  <li class="nav-item" <?php if($fullName != 'RAVI  NANAYAKKARA'){echo 'hidden';} ?>>
                    <a class="nav-link text-white" href="./pages/pages/users/docReport.php">
                      <span class="sidenav-mini-icon"> S </span>
                      <span class="sidenav-normal  ms-3  ps-1">DOC REPORT</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white " href="./pages/pages/users/grnView.php">
                      <span class="sidenav-mini-icon"> GRN </span>
                      <span class="sidenav-normal  ms-3  ps-1">GRN REPORT</span>
                    </a>
                  </li>
                 
                 
                  <!--<li class="nav-item">
                    <a class="nav-link text-white " href="./pages/pages/users/doctorReport.php">
                      <span class="sidenav-mini-icon"> D </span>
                      <span class="sidenav-normal  ms-3  ps-1">DOCTOR</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white " href="./pages/pages/users/patientReport.php">
                      <span class="sidenav-mini-icon"> P </span>
                      <span class="sidenav-normal  ms-3  ps-1">PATIENT</span>
                    </a>
                  </li>-->
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./pages/pages/users/reports.php" target="_blank">
                <i class=" fa fa-user "></i>
                <span class="nav-link-text ms-2 ps-1">USERS</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./pages/pages/users/patients.php" target="_blank">
                <i class=" fa fa-user "></i>
                <span class="nav-link-text ms-2 ps-1">PATIENTS</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./pages/pages/users/items.php" target="_blank"> 
              <i class="bi bi-capsule"></i>
                <span class="nav-link-text ms-2 ps-1">ITEMS</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./pages/pages/users/medicalRep.php" target="_blank"> 
              <i class="bi bi-building"></i>    
                <span class="nav-link-text ms-2 ps-1">MEDICAL REP</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./pages/pages/users/companies.php" target="_blank"> 
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
                <a class="nav-link text-white " href="./pages/pages/users/grn.php">
                  <span class="sidenav-mini-icon"> G </span>
                  <span class="sidenav-normal  ms-2  ps-1"> GRN </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link text-white " href="./pages/pages/users/stock.php">
                  <span class="sidenav-mini-icon"> S</span>
                  <span class="sidenav-normal  ms-2  ps-1"> STOCK </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="./pages/pages/users/orderForcast.php">
                  <span class="sidenav-mini-icon"> O</span>
                  <span class="sidenav-normal  ms-2  ps-1">ORDER FORCAST </span>
                </a>
              </li>
            </ul>
          </div>
        </li>
            <li class="nav-item">
              <a class="nav-link" href="./pages/pages/users/logs.php" target="_blank">
                  <i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">receipt_long</i>
                <span class="nav-link-text ms-2 ps-1">LOGS</span>
              </a> 
            </li>  
          </ul>
        </div>
      </aside>

      <main class="main-content border-radius-lg ">
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
            <a href="../index.php" class="nav-link text-body p-0" data-toggle="tooltip" data-placement="top" title="Log Out" >
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>

        


<div class="container py-4">          
<div class="row">
  <div class="col-lg-12 position-relative z-index-2">
    <div class="card card-plain mb-4">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex flex-column h-100">
            <h2 class="font-weight-bolder mb-0">General Statistics</h2>
          </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="row">
        <div class="col-lg-3 col-sm-5">
          <div class="card  mb-2">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10">leaderboard</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Service Income</p>
                <h4 class="mb-0">281</h4>
              </div>
            </div>
              <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="card  mb-2">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">leaderboard</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Drugs income</p>
                <h4 class="mb-0">2,300</h4>
              </div>
            </div>

            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="card  mb-2">
            <div class="card-header p-3 pt-2 bg-transparent">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10">leaderboard</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize ">Total Income</p>
                <h4 class="mb-0 ">34k</h4>
              </div>
            </div>

            <hr class="horizontal my-0 dark">
            <div class="card-footer p-3">
              <p class="mb-0 "><span class="text-success text-sm font-weight-bolder">+1% </span>than yesterday</p>
            </div>
          </div>
      </div>

      <div class="col-3 ">
        <div class="card ">
          <div class="card-header p-3 pt-2 bg-transparent">
            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">leaderboard</i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize ">GP</p>
              <h4 class="mb-0 ">+91</h4>
            </div>
          </div>

          <hr class="horizontal my-0 dark">
          <div class="card-footer p-3">
            <p class="mb-0 ">Just updated</p>
          </div>
        </div>
      </div>
        </div>
      </div>
        
    </div>   


    <div class="row mt-4">
      <div class="col-12">
        <div class="card mb-4 ">
  <div class="d-flex">
    <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
      <i class="material-icons opacity-10" aria-hidden="true">language</i>
    </div>
    <h6 class="mt-3 mb-2 ms-3 ">Income By Months</h6>
  </div>
  <div class="card-body p-3">
    <div class="row">
      <div class="col-lg-12 col-md-7">
        <div class="table-responsive">
          <table class="table align-items-center ">
            <tbody>
              <tr>
                <td class="w-30">
                  <div class="d-flex px-2 py-1 align-items-center">
                    <div>
                    </div>
                    <div class="ms-4">
                      <p class="text-xs font-weight-bold mb-0 ">Month:</p>
                      <h6 class="text-sm font-weight-normal mb-0 ">Octomber</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Sales:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">2500</h6>
                  </div>
                </td>
                <td>
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Value:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">$230,900</h6>
                  </div>
                </td>
                <td class="align-middle text-sm">
                  <div class="col text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Bounce:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">29.9%</h6>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="w-30">
                  <div class="d-flex px-2 py-1 align-items-center">
                    <div>
                    </div>
                    <div class="ms-4">
                      <p class="text-xs font-weight-bold mb-0 ">Month:</p>
                      <h6 class="text-sm font-weight-normal mb-0 ">November</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Sales:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">3.900</h6>
                  </div>
                </td>
                <td>
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Value:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">$440,000</h6>
                  </div>
                </td>
                <td class="align-middle text-sm">
                  <div class="col text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Bounce:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">40.22%</h6>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="w-30">
                  <div class="d-flex px-2 py-1 align-items-center">
                    <div>
                    </div>
                    <div class="ms-4">
                      <p class="text-xs font-weight-bold mb-0 ">Month:</p>
                      <h6 class="text-sm font-weight-normal mb-0 ">December</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Sales:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">1.400</h6>
                  </div>
                </td>
                <td>
                  <div class="text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Value:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">$190,700</h6>
                  </div>
                </td>
                <td class="align-middle text-sm">
                  <div class="col text-center">
                    <p class="text-xs font-weight-bold mb-0 ">Bounce:</p>
                    <h6 class="text-sm font-weight-normal mb-0 ">23.44%</h6>
                  </div>
                </td>
              </tr>

              
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-lg-6 col-md-5">
        <div id="map" class="mt-0 mt-lg-n4"></div>
      </div>
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
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
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
        <hr class="horizontal dark my-sm-4">
        
          
          <a class="btn bg-gradient-primary w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Buy now</a>
          
        
        
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard">Free demo</a>
        
        
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20PRO%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard-pro" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          

          
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard-pro" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
          
        </div>
      </div>
    </div>
</div>

      
      















<!--   Core JS Files   -->
<script src="./assets/js/core/popper.min.js" ></script>
<script src="./assets/js/core/bootstrap.min.js" ></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js" ></script>
<script src="./assets/js/plugins/smooth-scrollbar.min.js" ></script>

























<!-- Kanban scripts -->
<script src="./assets/js/plugins/dragula/dragula.min.js"></script>
<script src="./assets/js/plugins/jkanban/jkanban.js"></script>

















































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


<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc --><script src="./assets/js/material-dashboard.min.js?v=3.0.6"></script>
  </body>

</html>
