
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
    //echo $fullName;
    
    
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

  <title>
    ITEM DETAILS
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
  <script defer data-site="https://jeewakamedicalcenter.com" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



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

    * {
	box-sizing: border-box;
}

#search {
  margin-right: 25%;
	display: grid;
	grid-area: search;
	grid-template:
		"search" 60px
		/ 280px;
	justify-content: center;
	align-content: center;
	justify-items: stretch;
	align-items: stretch;
}

#search input {
	display: block;
	grid-area: search;
	-webkit-appearance: none;
	appearance: none;
	width: 100%;
	height: 100%;
	background: none;
	padding: 0 30px 0 60px;
	border: none;
	border-radius: 100px;
	font: 24px/1 system-ui, sans-serif;
	outline-offset: -8px;
}


#search svg {
	grid-area: search;
	overflow: visible;
	color: hsl(215, 100%, 50%);
	fill: none;
	stroke: currentColor;
}

.spark {
	fill: currentColor;
	stroke: none;
	r: 15;
}

.spark:nth-child(1) {
	animation:
		spark-radius 2.03s 1s both,
		spark-one-motion 2s 1s both;
}

@keyframes spark-radius {
	0% { r: 0; animation-timing-function: cubic-bezier(0, 0.3, 0, 1.57) }
	30% { r: 15; animation-timing-function: cubic-bezier(1, -0.39, 0.68, 1.04) }
	95% { r: 8 }
	99% { r: 10 }
	99.99% { r: 7 }
	100% { r: 0 }
}

@keyframes spark-one-motion {
	0% { transform: translate(-20%, 50%); animation-timing-function: cubic-bezier(0.63, 0.88, 0, 1.25) }
	20% { transform: rotate(-0deg) translate(0%, -50%); animation-timing-function: ease-in }
	80% { transform: rotate(-230deg) translateX(-20%) rotate(-100deg) translateX(15%); animation-timing-function: linear }
	100% { transform: rotate(-360deg) translate(30px, 100%); animation-timing-function: cubic-bezier(.64,.66,0,.51) }
}

.spark:nth-child(2) {
	animation:
		spark-radius 2.03s 1s both,
		spark-two-motion 2.03s 1s both;
}

@keyframes spark-two-motion {
	0% { transform: translate(120%, 50%) rotate(-70deg) translateY(0%); animation-timing-function: cubic-bezier(0.36, 0.18, 0.94, 0.55) }
	20% { transform: translate(90%, -80%) rotate(60deg) translateY(-80%); animation-timing-function: cubic-bezier(0.16, 0.77, 1, 0.4) }
	40% { transform: translate(110%, -50%) rotate(-30deg) translateY(-120%); animation-timing-function: linear }
	70% { transform: translate(100%, -50%) rotate(120deg) translateY(-100%); animation-timing-function: linear }
	80% { transform: translate(95%, 50%) rotate(80deg) translateY(-150%); animation-timing-function: cubic-bezier(.64,.66,0,.51) }
	100% { transform: translate(100%, 50%) rotate(120deg) translateY(0%) }
}

.spark:nth-child(3) {
	animation:
		spark-radius 2.05s 1s both,
		spark-three-motion 2.03s 1s both;
}

@keyframes spark-three-motion {
	0% { transform: translate(50%, 100%) rotate(-40deg) translateX(0%); animation-timing-function: cubic-bezier(0.62, 0.56, 1, 0.54) }
	30% { transform: translate(40%, 70%) rotate(20deg) translateX(20%); animation-timing-function: cubic-bezier(0, 0.21, 0.88, 0.46) }
	40% { transform: translate(65%, 20%) rotate(-50deg) translateX(15%); animation-timing-function: cubic-bezier(0, 0.24, 1, 0.62) }
	60% { transform: translate(60%, -40%) rotate(-50deg) translateX(20%); animation-timing-function: cubic-bezier(0, 0.24, 1, 0.62) }
	70% { transform: translate(70%, -0%) rotate(-180deg) translateX(20%); animation-timing-function: cubic-bezier(0.15, 0.48, 0.76, 0.26) }
	100% { transform: translate(70%, -0%) rotate(-360deg) translateX(0%) rotate(180deg) translateX(20%); }
}




.burst {
	stroke-width: 3;
}

.burst :nth-child(2n) { color: #ff783e }
.burst :nth-child(3n) { color: #ffab00 }
.burst :nth-child(4n) { color: #55e214 }
.burst :nth-child(5n) { color: #82d9f5 }

.circle {
	r: 6;
}

.rect {
	width: 10px;
	height: 10px;
}

.triangle {
	d: path("M0,-6 L7,6 L-7,6 Z");
	stroke-linejoin: round;
}

.plus {
	d: path("M0,-5 L0,5 M-5,0L 5,0");
	stroke-linecap: round;
}




.burst:nth-child(4) {
	transform: translate(30px, 100%) rotate(150deg);
}

.burst:nth-child(5) {
	transform: translate(50%, 0%) rotate(-20deg);
}

.burst:nth-child(6) {
	transform: translate(100%, 50%) rotate(75deg);
}

.burst * {}

@keyframes particle-fade {
	0%, 100% { opacity: 0 }
	5%, 80% { opacity: 1 }
}

.burst :nth-child(1) { animation: particle-fade 600ms 2.95s both, particle-one-move 600ms 2.95s both; }
.burst :nth-child(2) { animation: particle-fade 600ms 2.95s both, particle-two-move 600ms 2.95s both; }
.burst :nth-child(3) { animation: particle-fade 600ms 2.95s both, particle-three-move 600ms 2.95s both; }
.burst :nth-child(4) { animation: particle-fade 600ms 2.95s both, particle-four-move 600ms 2.95s both; }
.burst :nth-child(5) { animation: particle-fade 600ms 2.95s both, particle-five-move 600ms 2.95s both; }
.burst :nth-child(6) { animation: particle-fade 600ms 2.95s both, particle-six-move 600ms 2.95s both; }

@keyframes particle-one-move { 0% { transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001) } 100% { transform: rotate(-20deg) translateX(8%) scale(0.5, 0.5) } }
@keyframes particle-two-move { 0% { transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001) } 100% { transform: rotate(0deg) translateX(8%) scale(0.5, 0.5) } }
@keyframes particle-three-move { 0% { transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001) } 100% { transform: rotate(20deg) translateX(8%) scale(0.5, 0.5) } }
@keyframes particle-four-move { 0% { transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001) } 100% { transform: rotate(-35deg) translateX(12%) } }
@keyframes particle-five-move { 0% { transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001) } 100% { transform: rotate(0deg) translateX(12%) } }
@keyframes particle-six-move { 0% { transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001) } 100% { transform: rotate(35deg) translateX(12%) } }



.bar {
	width: 100%;
	height: 100%;
	ry: 50%;
	stroke-width: 10;
	animation: bar-in 900ms 3s both;
}

@keyframes bar-in {
	0% { stroke-dasharray: 0 180 0 226 0 405 0 0 }
	100% { stroke-dasharray: 0 0 181 0 227 0 405 0 }
}

.magnifier {
	animation: magnifier-in 600ms 3.6s both;
	transform-box: fill-box;
}

@keyframes magnifier-in {
	0% { transform: translate(20px, 8px) rotate(-45deg) scale(0.01, 0.01); }
	50% { transform: translate(-4px, 8px) rotate(-45deg); }
	100% { transform: translate(0px, 0px) rotate(0deg); }
}

.magnifier .glass {
	cx: 27;
	cy: 27;
	r: 8;
	stroke-width: 3;
}
.magnifier .handle {
	x1: 32;
	y1: 32;
	x2: 44;
	y2: 44;
	stroke-width: 3;
}



#results {
	grid-area: results;
	background: hsl(0, 0%, 95%);
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
              <a class="nav-link active" href="./items.php" target="_blank"> 
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
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg position-sticky top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
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
        <div class=" m-2 d-xl-block d-none ">
        <h5 class="mb-0 ">ITEMS</h5>
          
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
          <div id="search">
                  <svg viewBox="0 0 420 60" xmlns="http://www.w3.org/2000/svg">
                    <rect class="bar"/>
                    
                    <g class="magnifier">
                      <circle class="glass"/>
                      <line class="handle" x1="32" y1="32" x2="44" y2="44"></line>
                    </g>

                    <g class="sparks">
                      <circle class="spark"/>
                      <circle class="spark"/>
                      <circle class="spark"/>
                    </g>

                    <g class="burst pattern-one">
                      <circle class="particle circle"/>
                      <path class="particle triangle"/>
                      <circle class="particle circle"/>
                      <path class="particle plus"/>
                      <rect class="particle rect"/>
                      <path class="particle triangle"/>
                    </g>
                    <g class="burst pattern-two">
                      <path class="particle plus"/>
                      <circle class="particle circle"/>
                      <path class="particle triangle"/>
                      <rect class="particle rect"/>
                      <circle class="particle circle"/>
                      <path class="particle plus"/>
                    </g>
                    <g class="burst pattern-three">
                      <circle class="particle circle"/>
                      <rect class="particle rect"/>
                      <path class="particle plus"/>
                      <path class="particle triangle"/>
                      <rect class="particle rect"/>
                      <path class="particle plus"/>
                    </g>
                  </svg>
                  <input id="search-input" type=search name=q aria-label="Search for inspiration"/>
                </div>          
              </li>
        </ul>
        <ul class="navbar-nav  justify-content-end">
          <li class="nav-item px-3">
          <a class="btn bg-gradient-info btn-sm mb-0"  data-bs-toggle="modal" data-bs-target="#addUserModal" >+&nbsp; New Item</a>
          </li>
        </ul>
        <ul class="navbar-nav  justify-content-end">
          <li class="nav-item px-3">
            <a href="../../../../index.php" class="nav-link text-body p-0" data-toggle="tooltip" data-placement="top" title="Log Out" >
            <i class="fa fa-sign-out" aria-hidden="true"></i> log
            </a>
          </li>
        </ul>

                <div id="results">
                  
                </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card ">
            <!-- Card header -->
            <div class="card-header pb-0">
              <div class="d-lg-flex">
                <div class="ms-auto  my-auto mt-lg-0">
                  <div class="ms-auto my-auto ">
                    <form methq="post" id="addUserForm">
                    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-xl ">
                      
                      <div class="modal-content w-100">
                        <div class="modal-header">
                          <h5 class="modal-title" id="addUserModalLabel">Add Items</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    
                                </div>
                                <div class="row ">
                                    <div class="col-12">
                                        <table class="">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Item Name</th>
                                                    <th>Generic</th>
                                                    <th>Remarks</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="userRows">
                                                <!-- User rows will be dynamically added here -->
                                                
                                            </tbody>
                                        </table>
                                        <div class="text-end" >
                                        <button type="button" class="btn btn-transparent" id="addModelRow"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info" id="saveUser">Save Item</button>

                        </div>
                      </div>
                      <!-- Add more input fields for other user information as needed -->
                  </div>
                
                  </form>
                </div>
              </div>

            </div>
           <!-- <button class="btn btn-outline-info btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button> -->

        </div>
        
    </div>
            <div class="card-body px-0 pb-0">
              <div >
              <table class="table table-bordered text-sm ms-1 " id="products-list">
                  <thead class="thead-light">
                    <tr>
                      <th>ID</th>
                      <th>INAME</th>
                      <th>MREP</th>
                      <th>GEN</th>
                      <th>RP(Rs)</th>
                      <th>QT</th>
                      <th>REMARKS</th>
                      <th class="text-center" >ACTION</th>
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

 // Define a function to fetch data from the PHP script and populate the HTML table
 function fetchDataAndPopulateTable() {
  // Make an AJAX request to fetch the main data
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '../../../../attributes/fetchMedi4Grn.php', true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var responseData = JSON.parse(xhr.responseText);

        // Create a map for item names to rep codes and names
        var itemRepMap = {};

        // Fetch all necessary data in parallel
        Promise.all([
          fetch('../../../../attributes/fetchMediRepItem.php').then(response => response.json()),
          fetch('../../../../attributes/fetchMedicalRep.php').then(response => response.json())
        ]).then(([repItemData, medicalRepData]) => {
          // Map item names to rep codes
          repItemData.forEach(item => {
            if (!itemRepMap[item.mediItem.trim()]) {
              itemRepMap[item.mediItem.trim()] = [];
            }
            itemRepMap[item.mediItem.trim()].push(item.repCode);
          });

          // Map rep codes to rep names
          var repNameMap = {};
          medicalRepData.forEach(rep => {
            repNameMap[rep.id] = rep.name;
          });

          // Get the table body element
          var tbody = document.querySelector('#products-list tbody');
          tbody.innerHTML = '';

          // Build the table rows
          var rowsHtml = responseData.map(rowData => {
            var id = rowData.id;
            var iname = rowData.name;
            var gen = rowData.mediName;
            var remarks = rowData.remark;
            var rp = rowData.cost;
            var qt = rowData.qt;
            var mrep = '';

            // Get the representative names if available
            if (itemRepMap[iname.trim()]) {
              mrep = itemRepMap[iname.trim()]
                .map(repCode => repNameMap[repCode])
                .filter(Boolean)
                .join(', ');
            }

            // Build the row HTML
            return `
              <tr>
                <td>${id}</td>
                <td>${iname}</td>
                <td>${mrep || ''}</td>
                <td>${gen}</td>
                <td>${rp}</td>
                <td>${qt}</td>
                <td>${remarks}</td>
                <td class="text-sm text-start">
                  <a href="javascript:;" class="edit mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit product">
                    <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                  </a>
                  <a href="javascript:;" class="delete" data-bs-toggle="tooltip" data-bs-original-title="Delete product">
                    <i class="material-icons text-secondary position-relative text-lg">delete</i>
                  </a>
                </td>
              </tr>`;
          }).join('');

          // Update the table body in one go
          tbody.innerHTML = rowsHtml;

          // Attach event listeners for edit and delete buttons
          tbody.querySelectorAll('.edit').forEach((editBtn, index) => {
            editBtn.addEventListener('click', function() {
              openModalIfAllowed(responseData[index]);
            });
          });
          tbody.querySelectorAll('.delete').forEach((deleteBtn, index) => {
            deleteBtn.addEventListener('click', function() {
              deleteRow(responseData[index]);
            });
          });

        }).catch(error => {
          console.error('Error fetching additional data:', error);
          alert('SOMETHING NOT CORRECT. PLEASE CONTACT DEVELOPER');
        });

      } else {
        console.error('Error fetching data. Status code: ' + xhr.status);
        alert('SOMETHING NOT CORRECT. PLEASE CONTACT DEVELOPER');
      }
    }
  };
  xhr.send();
}


// Helper function to create a table cell with the given content
function createCell(content) {
  var cell = document.createElement('td');
  cell.textContent = content;
  return cell;
}




// Call the function to fetch data and populate the table
fetchDataAndPopulateTable();

 myModal = new bootstrap.Modal(document.getElementById('addUserModal'));

// Function to open the modal if 'a' is greater than or equal to 0
function openModalIfAllowed(rowData) {
  console.log("rowData",rowData)
      document.getElementById('id').value = rowData.id;
      document.getElementById('itemName').value = rowData.name;
      document.getElementById('generic').value = rowData.mediName;
      document.getElementById("remarks").value = rowData.remark;
      document.getElementById("quantity").value = rowData.qt;
      myModal.show();
}



function deleteRow(rowData) {
  // Confirm deletion with the user
  
    confirm('Are you sure you want to delete this?')
    const id = rowData.id;
    const table = 'medicines';
    const primaryKey = 'id';

    // Create a FormData object to send data via POST request
    const formData = new FormData();

    // Append individual fields to the FormData object
    formData.append('id', id);
    formData.append('table', table);
    formData.append('primaryKey', primaryKey);

    // Make an AJAX POST request to the PHP script
    fetch('../../../../attributes/publicDelete.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (response.ok) {
          console.log('response', response);

          // Handle success response if needed
          alert(id + ' is deleted successfully!');
          // Optionally, you can redirect to another page after successful deletion
         window.location.href = '';
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




// Function to add a new row
function addModelRow() {
   // console.log("Adding a new row...");
    var newRow = `
        <tr>
            <td><input type="text" name="id" id="id" class="form-control" hidden ></td>
            <td><input type="text" name="itemName" id="itemName" class="form-control" placeholder="Item Name"></td>
            <td><input type="text" name="generic" id="generic" class="form-control" placeholder="Generic"></td>
            <td><input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks"></td>
            <td>
              <input type="text" name="quantity" id="quantity" class="form-control"  
                      <?php if ($fullName !== 'RAVI  NANAYAKKARA') {
                          echo 'disabled';
                      } ?> 
              >
            </td>
        </tr>
    `;
    $('#userRows').append(newRow);}

// Function to remove a row
$(document).on('click', '.removeRow', function () {
   // console.log("Removing a row...");
    $(this).closest('.row').remove();
});

// Add row button click event
$('#addModelRow').click(function () {
   // console.log("Add Row button clicked.");
    addModelRow();
});

// Initially add one row
$(document).ready(function () {
   // console.log("Document ready.");
});
addModelRow();


$(document).ready(function () {
    $('#addUserForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        
        // Initialize an array to store form data for each row
        var formDataArray = [];

        document.getElementById("quantity").value

        // Iterate over each table row
        $('#userRows tr').each(function () {
            // Find input fields within the current row
            var id = $(this).find('input[name="id"]').val();
            var itemName = $(this).find('input[name="itemName"]').val();
            var generic = $(this).find('input[name="generic"]').val();
            var remarks = $(this).find('input[name="remarks"]').val();
            var quantity = $(this).find('input[name="quantity"]').val();


            // Create an object with the retrieved data
            var rowData = {
                'id': id,
                'itemName': itemName,
                'generic': generic,
                'quantity': quantity,
                'remarks': remarks
            };

            // Only add row data to formDataArray if all fields are not empty
            if (itemName.trim() !== '' && generic.trim() !== '' && remarks.trim() !== '') {
                formDataArray.push(rowData);
                //console.log('formDataArray',formDataArray)
            }
        });
        
        // Send AJAX request with formDataArray
        $.ajax({
            type: 'POST',
            url: '../../../../attributes/sendMedicines.php',
            data: { rows: formDataArray }, // Pass formDataArray as rows parameter
            dataType: 'json',
            encode: true
        })
        .done(function (data) {
            console.log(data);
            alert('Data saved successfully!');
            location.reload()
        })
        .fail(function (data) {
            console.log(data);
            alert('Error occurred while saving data.');
            location.reload()

        });
    });
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