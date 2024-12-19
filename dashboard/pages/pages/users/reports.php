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
} else {
  // User not logged in, redirect to login page
  header("Location: ../../../../index.php");
  exit();
}
?>
<?php
// ... Your existing code ...

try {
  // Prepare the SQL statement to fetch the last ID
  $stmt = $conn->prepare("SELECT id FROM system_user ORDER BY id DESC LIMIT 1");

  // Execute the statement
  $stmt->execute();

  // Bind result variables
  $stmt->bind_result($lastId);
  //$lastId = $lastId + 1;

  // Fetch the result
  if ($stmt->fetch()) {
    //echo "The last ID value is: " . $lastId;
  } else {
    echo "No records found.";
  }

  // Close statement
  $stmt->close();
} catch (Exception $e) {
  // Handle any errors
  echo "Error: " . $e->getMessage();
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
    User Details
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
          <a class="nav-link active " href="./reports.php" target="_blank">
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

          <h5 class="m-2">USERS</h5>

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
          <a href="" class="btn bg-gradient-info btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addUserModal">+&nbsp; New User</a>

          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item px-3">
              <a href="../../../../index.php" class="nav-link text-body p-0" data-toggle="tooltip" data-placement="top" title="Log Out">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="container-fluid">
        <div class="card  ">
          <!-- Card header -->
          <div class="d-lg-flex">
            <div class="ms-auto  my-auto">
              <div class="ms-auto my-auto">
                <form methq="post" id="addUserForm">
                  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row mt-1">
                            <div class="col-3">
                              <label for="userCode" class="form-label">User ID</label>
                            </div>
                            <div class="col-9">
                              <input type="text" style=" border: 1px solid(blue); border-radius: 5px; width: 80%; " id="userId" name="userId" value="<?php echo $lastId + 1 ?>" disabled>
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label for="userCode" class="form-label">User Code</label>
                            </div>
                            <div class="col-9">
                              <input type="text" style=" border: 1px solid(blue); border-radius: 5px; width: 80%; " id="userCode" name="userCode">
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label for="fullName" class="form-label">Full Name</label>
                            </div>
                            <div class="col-9">
                              <input type="text" style=" border: 1px solid(blue); border-radius: 5px;  width: 80%; " id="fullName" name="fullName">
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label for="userName" class="form-label">User Name</label>
                            </div>
                            <div class="col-9">
                              <input type="text" style=" border: 1px solid(blue); border-radius: 5px;  width: 80%;" id="userName" name="userName">
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label for="password" class="form-label">Password</label>
                            </div>
                            <div class="col-9">
                              <input type="text" style=" border: 1px solid(blue); border-radius: 5px;  width: 80%;" id="password" name="password">
                            </div>
                          </div>
                          <div class="row mt-1">
                            <div class="col-3">
                              <label for="userLavel" class="form-label">User Level</label>
                            </div>
                            <div class="col-9">
                              <select class=" form-select " style=" border: 1px solid(blue); border-radius: 5px;  width: 80%;" id="userLevel">
                                <option value="admin">Admin</option>
                                <option value="doctor">Doctor</option>
                                <option value="nurse">Nurse</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" id="saveUser">Save User</button>
                        </div>
                      </div>
                      <!-- Add more input fields for other user information as needed -->
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="card-body px-0 pb-0">
            <div class="table-responsive">
              <table class="table table-flush" id="products-list">
                <thead class="thead-light">
                  <tr>
                    <th>ID</th>
                    <th>User Code</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Pass Word</th>
                    <th>User level</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <script>
              // JavaScript code to collect form data and send it to PHP script
              document.getElementById("addUserForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Collect form data
                var userId = document.getElementById("userId").value;
                var userCode = document.getElementById("userCode").value;
                var fullName = document.getElementById("fullName").value;
                var userName = document.getElementById("userName").value;
                var password = document.getElementById("password").value;
                var userLevel = document.getElementById("userLevel").value;

                // Create an object to hold the data
                var formData = {
                  userId: userId,
                  userCode: userCode,
                  fullName: fullName,
                  userName: userName,
                  password: password,
                  userLevel: userLevel
                };
                console.log("formData", formData);
                // Send the data to PHP script using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../../../../attributes/sendUserData.php", true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function() {
                  if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response from the server if needed
                    console.log(xhr.responseText);
                    location.reload();
                  }
                };
                xhr.send(JSON.stringify(formData));
              });

              var loggedInUserFullName = '<?php echo $fullName; ?>';
              // Define a function to fetch data from the PHP script and populate the HTML table
              function fetchDataAndPopulateTable() {
    // Make an AJAX request to the PHP script
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../../attributes/fetchUser.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Parse the JSON response
                var responseData = JSON.parse(xhr.responseText);

                // Get the table body element
                var tbody = document.querySelector('#products-list tbody');

                // Clear existing table rows
                tbody.innerHTML = '';

                // Iterate over the response data and populate the table rows
                responseData.forEach(function(rowData) {
                    // Create a new table row
                    var row = document.createElement('tr');

                    // Iterate over each property in the row data
                    Object.keys(rowData).forEach(function(key, index) {

                    //  console.log(rowData); // Log the full row data object
                    //  console.log( rowData['fullName'], '===', loggedInUserFullName.trim()); // Log to check full_name
                        // Create a new table data cell
                        var cell = document.createElement('td');

                        // Check if the field is 'password' and hide it if the logged-in user is not 'RAVI NANAYAKKARA'
                        if (key === 'password' && loggedInUserFullName.trim() !== 'RAVI  NANAYAKKARA') {
                            cell.textContent = '*****'; // Mask the password
                        } else {
                            cell.textContent = rowData[key]; // Display the value for other fields
                        }

                        // Append the cell to the row
                        row.appendChild(cell);

                        // Append additional td element to the last column for actions
                        if (index === Object.keys(rowData).length - 1) {
                            var actionCell = document.createElement('td');
                            actionCell.classList.add('text-sm', 'text-start');
                          //  console.log( rowData['full_name'], '===' ,loggedInUserFullName.trim())
                            
                            // Check if the logged-in user is 'RAVI NANAYAKKARA' or the row's full name matches the session user's full name
                            if (loggedInUserFullName.trim() === 'RAVI  NANAYAKKARA' || rowData['fullName'] === loggedInUserFullName.trim()) {
                                actionCell.innerHTML = `
                                    <a href="javascript:;" class="edit-button mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit User">
                                        <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                    </a>
                                    <a href="javascript:;" class="delete-button" data-bs-toggle="tooltip" data-bs-original-title="Delete product">
                                        <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                    </a>
                                `;
                            } else {
                               
                            }

                            row.appendChild(actionCell);
                        }
                    });

                    // Append the row to the table body
                    tbody.appendChild(row);
                });

                // Event delegation for edit and delete buttons
                tbody.addEventListener('click', function(event) {
                    // Check if the clicked element has the class 'edit-button'
                    if (event.target.closest('.edit-button')) {
                        // Find the row corresponding to the clicked edit button
                        var row = event.target.closest('tr');
                        var rowIndex = Array.from(tbody.children).indexOf(row);
                        var rowData = responseData[rowIndex];

                        console.log('Edit button clicked for row:', rowData);
                        openModalIfAllowed(rowData);
                    }

                    // Check if the clicked element has the class 'delete-button'
                    if (event.target.closest('.delete-button')) {
                        var row = event.target.closest('tr');
                        var rowIndex = Array.from(tbody.children).indexOf(row);
                        var rowData = responseData[rowIndex];

                        console.log('Delete button clicked for row:', rowData);
                        deleteRow(rowData);
                    }
                });
            } else {
                console.error('Error fetching data. Status code: ' + xhr.status);
            }
        }
    };
    xhr.send();
}




              // Call the function to fetch data and populate the table
              fetchDataAndPopulateTable();

              function deleteRow(rowData) {
                // Confirm deletion with the user
                if (confirm('Are you sure you want to delete this?')) {
                  const id = rowData.id;
                  const table = 'system_user';
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
              }



              // Get a reference to the modal element
              var myModal = new bootstrap.Modal(document.getElementById('addUserModal'));

              // Function to open the modal if 'a' is greater than or equal to 0
              function openModalIfAllowed(rowData) {
                document.getElementById('userId').value = rowData.id;
                document.getElementById('fullName').value = rowData.fullName;
                document.getElementById("userCode").value = rowData.userCode;
                document.getElementById("userName").value = rowData.userName;
                document.getElementById("password").value = rowData.password;
                document.getElementById("userLevel").select = rowData.userLevel;
                myModal.show();
              }

              // Call the openModalIfAllowed function when needed, for example:
              //openModalIfAllowed(); // This will open the modal if 'a' is greater than or equal to 0
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
    <script>
      if (document.getElementById('products-list')) {
        const dataTableSearch = new simpleDatatables.DataTable("#products-list", {
          searchable: true,
          fixedHeight: false,
          perPage: 7
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
      };
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