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
    SALE REPORT
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

    .expiring-soon {
      background-color: red !important;
      color: white;
    }

    .outOfStock {
      background-color: orange !important;
      color: white;
    }

    /* Spinner overlay styles */
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
      flex-direction: column;
      z-index: 1000;
    }

    .spinner-border {
      width: 3rem;
      height: 3rem;
      border: 0.4rem solid rgba(0, 0, 0, 0.1);
      border-top: 0.4rem solid #3498db;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .hidden {
      display: none;
    }

    .countdown-text {
      margin-top: 20px;
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
    }

    .table-wrapper {
      display: block;
      max-height: 300px;
      /* Adjust this height as needed */
      overflow-y: auto;
    }

    .table-wrapper thead,
    .table-wrapper tfoot {
      position: sticky;
      top: 0;
      /* Keeps the header at the top */
      z-index: 1;
      /* Ensures the header is above table body */
      background: #f8f9fa;
      /* Use your table header background color */
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
                <a class="nav-link active text-white" href="./saleReport.php">
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
    <nav class="navbar navbar-main navbar-expand-lg position-sticky px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
      <div class="container-fluid px-3">
        <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
          <a href="javascript:;" class="nav-link text-body p-0">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </div>
        <h6 class="m-2">SALE REPORT</h6>
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
          </li>
        </ul>
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
      <div class="row">
        <div class="col-12">
          <div style="height: 480px; max-height: 480px;" class="card text-sm ">
            <div class="card-body px-0 pb-0">
              <div class="row">
                <div class="col-1 ms-3"><label class="form-control">FROM :</label></div>
                <div class="col-2"> <input class="form-control" type="date" id="from"> </div>
                <div class="col-1 ms-3"><label class="form-control">TO :</label></div>
                <div class="col-2"> <input class="form-control" type="date" id="to"> </div>
                <div class="col-2"> <button class="btn btn-outline-dark btn-sm" type="button" onclick="fetchSalesData()" id="filter">
                    <i class="fa fa-filter" aria-hidden="true"></i> Filter
                  </button> </div>
                <div class="col-2">
                  <div class="input-group">
                    <input type="text" id="search-input" class="form-control" placeholder="Search Items" aria-label="Search Items" aria-describedby="basic-addon1">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"> <i class="fa fa-search" aria-hidden="true"></i> </span>
                    </div>
                  </div>
                </div>
                <div class="col-1">
                  <button type="button" id="export" class="btn btn-dark btn-sm">DOWNLOAD</button>
                </div>
              </div>

              <!-- Updated Table Container with Horizontal Scroll -->
              <div class="table-container" style="max-height: 400px; max-width: device-width; overflow-y: auto; overflow-x: auto;">
                <div class="table-wrapper" style="max-height: 400px; overflow-y: auto;">
                  <table class="table table-bordered table-sm text-sm" id="products-list" style="width: auto; min-width: 100%;">
                    <thead class="thead-light">
                      <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>GENERIC</th>
                        <th>MEDI REP</th>
                        <th>WS PRICE</th>
                        <th>RETAIL PRICE</th>
                        <th>BILL PROFIT(%)</th>
                        <th>FINAL PROFIT(%)</th>
                        <th>QTY</th>
                        <th>T SALE</th>
                        <th>D SALE</th>
                        <th>COST PI</th>
                        <th>T COST</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Your table rows go here -->
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="9">TOTAL</td>
                        <td id="stsale"></td>
                        <td id="stdPrice"></td>
                        <td id="sfprofit"></td>
                        <td id="totalCostSum"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>

                <div id="spinner-overlay" class="spinner-overlay hidden">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div id="countdown-text" class="countdown-text">Time remaining: 0s</div>
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
    </div>
  </main>
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
              id: medicine.id,
              name: medicine.name,
              generic: medicine.mediName,
              mediRep: null,
              wsPrice: null,
              cost: null, // Initialize with null
              saleP: null,
              profitP: null,
              qty: null,
              dprice: null,
              costPI: null,
              // fCost : null,
              //fProfit : null,
              // expiryDate: null, // Initialize with null
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
            //console.log('products', product)
            // Match products with tableData
            tableData.forEach(item => {
              if (item.name.trim().toLowerCase() === product.name.trim().toLowerCase() &&
                item.generic.trim().toLowerCase() === product.generic.trim().toLowerCase()) {
                item.mediRep = product.mediRep,
                item.wsPrice = product.pricePI;
                item.cost = product.retailP; 
                item.saleP = product.sp;
                item.profitP = product.profit;
                item.costPI = product.costPI;
                //item.expiryDate = product.expiryDate;
              }
            });
          });

          // Render the table after processing the data
          /// renderTable();
        })
        .catch(error => {
          console.error('Error fetching GRN products:', error);
        });
    }


    async function fetchSalesData() {
      try {
        const [pharmacyResponse, pharmacyGenResponse] = await Promise.all([
          fetch('../../../../attributes/fetchPharmacy.php'),
          fetch('../../../../attributes/fetchPharmacyGener.php')
        ]);

        if (!pharmacyResponse.ok || !pharmacyGenResponse.ok) {
          throw new Error('Network response was not ok');
        }

        const pharmacyData = await pharmacyResponse.json();
        const pharmacyGenData = await pharmacyGenResponse.json();

        const from = new Date(document.getElementById('from').value);
        const to = new Date(document.getElementById('to').value);

        const saleMap = new Map();

        pharmacyData.forEach(sale => {
          const parts = sale.itemCode.split('-').map(part => part.trim());
          if (parts.length === 2) {
            const [name, generic] = parts;
            const key = `${name.toLowerCase()}|${generic.toLowerCase()}`;
            const saleDate = new Date(sale.created_at);

            // Find corresponding genStatus for the current sale
            let matchingGenData = pharmacyGenData.find(genData => genData.serial === sale.serial);
            if (matchingGenData) {
              const genStatus = matchingGenData.status;

              if (saleDate >= from && saleDate <= to &&
                (genStatus === 'PAYMENT' || genStatus === 'QUOTATION & PAYMENT')) {
                if (!saleMap.has(key)) {
                  saleMap.set(key, []);
                }
                saleMap.get(key).push(sale);
              }
            }
          } else {
            console.warn(`Invalid itemCode format: ${sale.itemCode}`);
          }
        });

       // console.log('saleMap',saleMap);

        const pharmacySale = Array.from(saleMap.entries()).map(([key, sales]) => {
          const totalQty = sales.reduce((sum, sale) => sum + parseInt(sale.qty, 10), 0);
          const dprice = sales.reduce((sum, sale) => sum + parseInt(sale.dprice, 10), 0);
          const [name, generic] = key.split('|');
          const retailP = sales.length > 0 ? parseFloat(sales[0].retailP) : 0;
          const fCost = totalQty * retailP;
          //console.log('name', name, 'dprice', dprice, 'totalQty', totalQty);
          return {
            name,
            generic,
            qty: totalQty,
            retailP,
            fCost,
            dprice
          };
        });

       // console.log('pharmacySale',pharmacySale)

        pharmacySale.forEach(finalSale => {
        
          tableData.forEach(item => {
            if (item.name.trim().toLowerCase() === finalSale.generic.trim().toLowerCase() &&
              item.generic.trim().toLowerCase() === finalSale.name.trim().toLowerCase()) {
              item.qty = finalSale.qty;
              item.dprice = finalSale.dprice;
            }
          });
        });

        renderTable();
      } catch (error) {
        console.error('Error fetching GRN products:', error);
      }
    }





    // Function to check if the expiry date is within the next month
    function isExpiringSoon(expiryDate) {
      if (!expiryDate) return false;

      const [month, year] = expiryDate.split('/').map(Number);
     // console.log('month,year', month, year);

      const now = new Date();
      const currentYear = now.getFullYear() % 100; // Get the last two digits of the current year

      // Adjust the year to be in the 21st century (2000s) if necessary
      const fullYear = (year < 50 ? 2000 + year : 1900 + year);

      const expiry = new Date(fullYear, month - 1);
      const nextMonth = new Date(now.getFullYear(), now.getMonth() + 3);

    //  console.log('fullYear', fullYear);
    //  console.log('expiry', expiry);
    //  console.log('nextMonth', nextMonth);

      const expiring = expiry <= nextMonth;
    //  console.log('expiring', expiring);

      return expiring;
    }



    // Function to render table rows
    let totalSalesSum = 0; // Declare totalSalesSum globally
    let totalProfitSum = 0; // Declare totalProfitSum globally
    let totalCostSum = 0;

    function renderTable() {
      const tbody = document.querySelector("#products-list tbody");
      const tfoot = document.querySelector("#products-list tfoot");
      tbody.innerHTML = ""; // Clear previous content

      tableData.sort((a, b) => a.name.localeCompare(b.name));

      totalSalesSum = 0; // Reset totalSalesSum
      totalDiscountSum = 0; // Reset totalSalesSum
      totalProfitSum = 0; // Reset totalProfitSum

      tableData.forEach(item => {

       // console.log('costPI',item.costPI);

        //  console.log('dprice',item.dprice);
        const tr = document.createElement("tr");

        if (item.qty == null) {
          item.qty = ' ';
        }



        let totalSale = item.qty * item.cost;
        totalSalesSum += totalSale; // Add to sum

        if (totalSale == 'NaN' || totalSale == 0) {
          totalSale = ' ';
        }



        let dprice;
        if (item.dprice == 'NaN' || item.dprice == 0) {
          dprice = ' ';
        } else {
          dprice = item.dprice;
        }
        totalDiscountSum += item.dprice;



        let totalProfit = item.dprice * (item.profitP / 100);
        totalProfitSum += totalProfit;

        if (totalProfit == 'NaN' || totalProfit == 0) {
          totalProfit = ' ';
        }

        totalCostSum += item.qty * item.costPI;

        
        tr.innerHTML = `
                <td style="text-align:center;">${item.id}</td>
                <td>${item.name}</td>
                <td>${item.generic}</td>
                <td style="text-align:center;">${item.mediRep || ""}</td>
                <td style="text-align:center;">${item.wsPrice || ""}</td>
                <td style="text-align:center;">${item.cost || ""}</td>
                <td style="text-align:center;">${item.saleP || ""}</td>
                <td style="text-align:center;">${item.profitP || ""}</td>
                <td style="text-align:center;">${item.qty}</td>
                <td style="text-align:center;">${isNaN(parseFloat(totalSale)) ? "" : parseFloat(totalSale).toFixed(2)}</td>
                <td style="text-align:center;">${isNaN(parseFloat(dprice)) ? "" : parseFloat(dprice).toFixed(2)}</td>
                <td style="text-align:center;">${isNaN(parseFloat(item.costPI)) ? "" : parseFloat(item.costPI).toFixed(2)}</td>
                <td style="text-align:center;">${isNaN(parseFloat(item.costPI * item.qty )) ? "" : parseFloat(item.costPI * item.qty).toFixed(2)}</td>
            `;
        tbody.appendChild(tr);
      });

     // console.log('totalCostSum:', totalCostSum); // Display sum in console
      // console.log('Total Profit Sum:', totalProfitSum); // Display sum in console
      // console.log('Total Discounted price Sum:', totalDiscountSum); // Display sum in console

      document.getElementById('totalCostSum').innerText = totalCostSum.toFixed(2);
      document.getElementById('stsale').innerText = totalSalesSum.toFixed(2);
      //document.getElementById('sfprofit').innerText = totalProfitSum.toFixed(2);
      document.getElementById('stdPrice').innerText = totalDiscountSum.toFixed(2);
    }

    // Call the function to render the table
    renderTable();
    fetchMedicines();

    document.getElementById('export').addEventListener('click', function() {
      const {
        jsPDF
      } = window.jspdf;
      const doc = new jsPDF('p', 'pt', 'a4');
      const table = document.getElementById('products-list');
      const spinnerOverlay = document.getElementById('spinner-overlay');
      const countdownText = document.getElementById('countdown-text');

      const rowsPerPage = 45; // Number of rows per page
      const rows = table.querySelectorAll('tbody tr');
      const totalRows = rows.length;
      const totalPages = Math.ceil(totalRows / rowsPerPage);

      let processedPages = 0;
      let remainingTime = totalPages * 2; // Approximate time per page (2 seconds)

      // Function to show the spinner and start the countdown
      function showSpinner() {
        spinnerOverlay.classList.remove("hidden");
        updateCountdown();
      }

      // Function to hide the spinner
      function hideSpinner() {
        spinnerOverlay.classList.add("hidden");
      }

      // Update the countdown text based on the remaining time
      function updateCountdown() {
        const countdownInterval = setInterval(() => {
          if (remainingTime > 0) {
            countdownText.textContent = `Time remaining: ${remainingTime}s`;
            remainingTime--;
          } else {
            clearInterval(countdownInterval);
          }
        }, 1000);
      }

      function addEmptyColumns(row) {
        const emptyColumn1 = document.createElement('td');
        const emptyColumn2 = document.createElement('td');
        emptyColumn1.style.width = '500px';
        emptyColumn2.style.width = '500px';
        row.appendChild(emptyColumn1);
        row.appendChild(emptyColumn2);
      }

      showSpinner(); // Show the spinner when process starts

      function capturePage(pageIndex) {
        const startRow = pageIndex * rowsPerPage;
        const endRow = startRow + rowsPerPage;
        const pageRows = Array.from(rows).slice(startRow, endRow);

        const pageTable = document.createElement('table');
        pageTable.classList.add('table', 'table-bordered');
        pageTable.innerHTML = table.querySelector('thead').outerHTML;
        const pageBody = document.createElement('tbody');

        pageRows.forEach(row => {
          const clonedRow = row.cloneNode(true);
          addEmptyColumns(clonedRow);
          pageBody.appendChild(clonedRow);
        });

        const footer = document.querySelector('tfoot').cloneNode(true);
        pageTable.appendChild(pageBody);
        pageTable.appendChild(footer);

        document.body.appendChild(pageTable);

        setTimeout(() => {
          html2canvas(pageTable, {
              useCORS: true,
              scale: 1
            })
            .then(canvas => {
              const imgData = canvas.toDataURL('image/png');
              const imgWidth = doc.internal.pageSize.getWidth();
              const imgHeight = canvas.height * imgWidth / canvas.width;

              if (pageIndex > 0) {
                doc.addPage();
              }
              doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

              processedPages++;
              if (processedPages === totalPages) {
                const currentDate = new Date().toISOString().split('T')[0];
                const fileName = `SALE REPORT ${currentDate}.pdf`;
                doc.save(fileName);
                hideSpinner(); // Hide the spinner after saving
              } else {
                capturePage(pageIndex + 1); // Capture next page
              }
            })
            .catch(error => {
              console.error('Error capturing page:', error);
              hideSpinner(); // Hide spinner on error
            })
            .finally(() => {
              document.body.removeChild(pageTable);
            });
        }, 500);
      }



      capturePage(0); // Start capturing pages
    });
  </script>
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