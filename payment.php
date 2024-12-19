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
    $userCode = $row["userCode"];

    
  } else {
    // User not found, display error message
    echo "Error: User information not found.";
  }

 
} else {
  // User not logged in, redirect to login page
  echo '<script>window.location.href = "./index.php";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CASHIER</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./attributes/background.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Include Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


    <style>
    label {
        font-size: larger;
    }

    input {
        font-size: larger;

    }

    .input {
        border: 1px solid black;

    }

    a {
        font-weight: bold;
    }

    #serialList {
        list-style: none;
        padding: 0;
        margin: 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-height: 250px;
        overflow-y: auto;
        position: absolute;
        width: 100%;
        z-index: 1;
        display: none;
        top: 100%;
        left: 0;
        background-color: #fff;
    }

    #serialList li {
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
        border-bottom: 1px solid #eee;
    }

    #serialList li:last-child {
        border-bottom: none;
    }

    #serialList li:hover {
        background-color: #f0f0f0;
    }

    .input[type="text"] {
        width: 200px;
        padding: 10px;
        font-size: 16px;
    }

    .hidden {
        display: none;
    }

    .toast {
        width: 700px !important;
        /* Adjust the width to fit around 85 characters */
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info ">
        <div class="container-fluid">
            <a style="font-family: cursive ; color:purple;" class="navbar-brand" href="#">Jeewaka Medical Centre</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">


                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" data-toggle="modal" data-target="#docReport">DOC
                            REPORT</a>
                    </li>
                    <div style="color: black;" class="modal" id="docReport">
                        <div class="modal-dialog modal-fullscreen  ">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">DOCTOR REPORT</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <div class="row mt-3">
                                        <div class="col-1">
                                            <label class=" form-label ">FROM:</label>
                                        </div>
                                        <div class="col-2 text-start">
                                            <input class="form-control text-start" type="date" id="docFromDate">
                                        </div>
                                        <div class="col-1 text-end">
                                            <label>TO:</label>
                                        </div>
                                        <div class="col-2">
                                            <input class="form-control text-start" type="date" id="docToDate">
                                        </div>
                                        <div id="docToast"
                                            style="display:none; position:fixed; bottom:10px; left:50%; transform:translateX(-50%); background-color:red; color:white; padding:10px; border-radius:5px;">
                                            Date range cannot exceed 3 days.
                                        </div>
                                        <div class="col-1 text-end">
                                            <label>DOC:</label>
                                        </div>
                                        <div class="col-1">
                                            <select class=" form-select-sm " id="docSelect"></select>
                                        </div>
                                        <div class="col-3 ms-1 text-end">
                                            <button class="btn btn-outline-dark "
                                                onclick="docFilterTable()">FILTER</button>
                                                <button type="button" id="docReportPDF"
                                            class="btn btn-primary">Download</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        </div>
                                        <div class="text-end">
                                       
                                    </div>
                                    </div>
                                    <div class="row mt-3">
                                        <table id="docCashTable" class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">SERIAL</th>
                                                    <th>PATIENT</th>
                                                    <th class="text-center">AGE</th>
                                                    <th class="text-center">ARRIVED</th>
                                                    <th class="text-center">REMARKS</th>
                                                    <th class="text-center">PMETHOD</th>
                                                    <th class="text-center">NPAID</th>
                                                    <th class="text-center">JMC</th>
                                                    <th class="text-center">JD</th>
                                                    <th class="text-center">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody id='docTableBody'>
                                                <!-- Table rows will be added dynamically -->
                                            </tbody>
                                            <tfoot id="docTFoot">
                                                <tr>
                                                    <th colspan="6">TOTAL</th>
                                                    <th class="text-end" id="docNP"></th>
                                                    <th class="text-end" id="docJMC"></th>
                                                    <th class="text-end" id="docJD"></th>
                                                    <th class="text-end" id="docTotal"></th>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                    
                                    <div class="text-start">
                                        <label class="form-label " id="docReportGenTime"></label>
                                    </div>
                                </div>
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <li class="nav-item">
                    </li>

                </ul>
                <div class="d-flex align-items-center">
                    <img src="./src/img/nurse1.png" class="rounded-circle" width="30" height="30" alt="User image"
                        data-toggle="modal" data-target="#myModal">
                    <input style="background:transparent; border: none; " class="" type="text" id="nurseName1"
                        value="<?php echo $fullName;?>" readonly>
                    <input style="background:transparent; border: none;" class="" type="text" id="handCash"
                        name="handCash" value="0" readonly>
                    <label class="mt-2" id="date&time"></label>
                    <script>
                    // Function to update date and time
                    function updateDateTime() {
                        // Get the current date and time
                        var currentDate = new Date();

                        // Format the date and time as desired (e.g., YYYY/MM/DD HH:MM:SS)
                        var formattedDateTime = currentDate.getFullYear() + '/' +
                            ('0' + (currentDate.getMonth() + 1)).slice(-2) + '/' +
                            ('0' + currentDate.getDate()).slice(-2) + ' ' +
                            ('0' + currentDate.getHours()).slice(-2) + ':' +
                            ('0' + currentDate.getMinutes()).slice(-2) + ':' +
                            ('0' + currentDate.getSeconds()).slice(-2);

                        // Update the label's text content with the formatted date and time
                        document.getElementById('date&time').textContent = formattedDateTime;
                        document.getElementById('docReportGenTime').textContent = formattedDateTime;

                    }

                    // Call the function to update date and time initially
                    updateDateTime();

                    // Call the function every second to keep the date and time updated
                    setInterval(updateDateTime, 1000);
                    </script>
                </div>
            </div>

            <!-- Bootstrap Modal -->
            <div style="color: black;" class="modal mt-5" id="myModal">
                <div class="modal-dialog modal-xl ">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">CASH REPORT</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="row  mt-3">
                                <div class="col-1">
                                    <label class=" form-label ">From:</label>
                                </div>
                                <div class="col-3 text-start">
                                    <input class="form-control text-start" type="date" id="fromDate">
                                </div>
                                <div class="col-1 text-end">
                                    <label>To:</label>
                                </div>
                                <div class="col-3">
                                    <input class="form-control text-start" type="date" id="toDate">
                                </div>
                                <div class="col-2 text-end ">
                                    <button class="btn btn-sm btn-outline-dark " onclick="filterTable()">Filter</button>
                                    <button type="button" id="cashReportPDF" class="btn btn-secondary">Download</button>

                                </div>
                                <div id="toast"
                                    style="display:none; position:fixed; bottom:10px; left:50%; transform:translateX(-50%); background-color:red; color:white; padding:10px; border-radius:5px;">
                                    Date range cannot exceed 3 days.
                                </div>
                                
                            </div>
                            <div class="row mt-3">
                                <table id="cashTable" class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>NURSE</th>
                                            <th>CASH</th>
                                            <th>CARD</th>
                                            <th>BANK</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id='tableBody'>
                                        <!-- Table rows will be added dynamically -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Sum of Totals</td>
                                            <td id="sumOfCash">0.00</td>
                                            <td id="sumOfCard">0.00</td>
                                            <td id="sumOfBank">0.00</td>
                                            <td id="sumOfTotals">0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="text-end">
                                <a><button type="button" onclick="logout()" class="btn btn-secondary">Log
                                        Out</button></a>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </nav>


    <div id="pageContent">
        <div id="page0" class="tab-pane fade show active">

            <div class="card mt-1"
                style="width: 100%; height:100% ; color: black; background:#ADD8E6; font-size: small; ">
                <div class="container-fluid">
                    <div class="row mt-2">
                        <div class=" col-9">
                            <div class=" card container-fluid "
                                style="width: 100%; height:100% ; color: black; border:none;">
                                <div>
                                    <div class="row head">
                                        <div class="col-1">
                                            <img class="icon" src="./src/img/medical.png" alt="medical">
                                        </div>
                                        <div class="col-11">
                                            <h2 for=""> PATIENT DETAILS</h2>
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3">
                                            <div class="form-floating mb-1">
                                                <input id="serialNumber" name="serialNumber" type="text" class="form-control input-lg " >
                                                <label for="serialNumber">SERIAL NUMBER</label>
                                                <ul id="serialList"></ul>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating mb-1">
                                                <input name="patientName" type="text" class="form-control input-lg"
                                                    id="patientName" placeholder="M.D.L.U.Kavishka">
                                                <label for="patientName">PATIENT NAME</label>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-floating mb-1">
                                                <input name="remark" type="text" class="form-control input-lg"
                                                    id="remark" placeholder="remark">
                                                <label for="remark">REMARK</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card mt-2  "
                                                style="width: 100%; height:100% ; color: black; border: none; ">
                                                <div>
                                                    <div class="row mt-2 head">
                                                        <div class="col-1">
                                                            <img class="icon" src="./src/img/session.png" alt="">
                                                        </div>
                                                        <div class="col-11">
                                                            <h5 for="">SESSION DETAILS</h5>
                                                        </div>

                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-1 mt-1">
                                                            <label>DOCTOR: </label>
                                                        </div>
                                                        <div class="col-2">
                                                            <select class="form-select form-select-sm" id="doctor"
                                                                aria-label=".form-select-sm example">
                                                                <!-- Placeholder option, you can remove or modify this as needed -->
                                                                <option>SELECT</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6 mt-1">
                                                            <input  style="color : red; font-size:xx-large"
                                                                class=" form-control border-0 font-weight-bold text-xxl-center h-50 "
                                                                name="docName" id="docName" type="text" value="">
                                                        </div>
                                                        <div hidden class="col-3">

                                                        </div>

                                                        <div hidden class="col-1 mt-1">
                                                            <label>PATIENTS:</label>
                                                        </div>
                                                        <div hidden class="col-1 mt-1">
                                                            <input class=" border-0 font-weight-bold text-xxl-center "
                                                                style="width:29px" name="patientCount" id="patientCount"
                                                                type="text" value="" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">

                                                        <div style="border: 1px solid lightblue;" class="col-7">
                                                            <div class="row mt-1 head">
                                                                <div class="col-1">
                                                                    <img class="icon" src="./src/img/visit.png" alt="">
                                                                </div>
                                                                <div class="col-11">
                                                                    <h5 for="">VISIT DETAILS</h5>
                                                                </div>

                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-2">
                                                                    <label>JD: </label>
                                                                </div>
                                                                <div class="col-4">
                                                                    <input type="number" id="jd" name="jd"
                                                                        class=" form-control h-75 " min="1"
                                                                        placeholder="MEDICINES CHARGE" readonly >
                                                                </div>
                                                                <div class="col-2">
                                                                    <label>JMC: </label>
                                                                </div>
                                                                <div class="col-4">
                                                                    <input type="number" id="jmc" name="jmc"
                                                                        class="form-control h-75" min="1"
                                                                        placeholder="SERVICE CHARGE">
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-2">
                                                                    <label>NP: </label>
                                                                </div>
                                                                <div class="col-4">
                                                                    <input type="number" id="np" name="np"
                                                                        class="form-control h-75" min="1"
                                                                        placeholder="NOT PAID" disabled>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label>TOTAL: </label>
                                                                </div>
                                                                <div class="col-4">
                                                                    <input type="number" id="total" name="total"
                                                                        class="form-control h-75" min="1"
                                                                        placeholder="JD+JMC+NP" disabled>
                                                                </div>

                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-3">
                                                                    <label>PAYMENT METHOD:</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="cash"
                                                                            name="paymentMethod"
                                                                            class="custom-control-input" value="cash"
                                                                            checked>
                                                                        <label class="custom-control-label mt-1"
                                                                            for="cash">CASH</label>
                                                                    </div>
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="card"
                                                                            name="paymentMethod"
                                                                            class="custom-control-input" value="card">
                                                                        <label class="custom-control-label mt-1"
                                                                            for="card">CARD</label>
                                                                    </div>
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="cash&card"
                                                                            name="paymentMethod"
                                                                            class="custom-control-input"
                                                                            value="cash&card">
                                                                        <label class="custom-control-label mt-1"
                                                                            for="cash&card">CARD&CASH</label>
                                                                    </div>
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="bank"
                                                                            name="paymentMethod"
                                                                            class="custom-control-input" value="bank">
                                                                        <label class="custom-control-label mt-1"
                                                                            for="bank">BANK</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="number" id="cardInput"
                                                                            name="cardInput"
                                                                            class="form-control h-75 w-75 hidden"
                                                                            min="1" placeholder="CARD  VALUE">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-3">
                                                                    <label>RECIEVED: </label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="number" id="recieved" name="recieved"
                                                                        class="form-control h-75" min="1"
                                                                        placeholder="TOTAL RECIEVED">
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-3">
                                                                    <label>REMAIN: </label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="number" id="remain" name="remain"
                                                                        class="form-control h-75" min="1"
                                                                        placeholder="NEXT TIME PAYMENT" disabled>
                                                                </div>

                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-3">
                                                                    <label>NEXT VISIT DATE: </label>
                                                                </div>
                                                                <div hidden class="col-6">
                                                                <input type="text" name="nvd" id="nvd" class="form-control h-75 input" placeholder="YYYY/MM/DD" maxlength="10">
                                                            </div>
                                                            <div class="col-6 mt-2">
                                                                <input type="date" id="datePicker" class="form-control h-75">
                                                            </div>

                                                            <script>
                                                            const dateInput = document.getElementById('nvd');
                                                            const datePicker = document.getElementById('datePicker');

                                                            // Function to format date as YYYY/MM/DD
                                                            function formatDate(date) {
                                                                const year = date.getFullYear();
                                                                const month = String(date.getMonth() + 1).padStart(2, '0');
                                                                const day = String(date.getDate()).padStart(2, '0');
                                                                return `${year}/${month}/${day}`;
                                                            }

                                                            // Event listener for date picker
                                                            datePicker.addEventListener('change', function(event) {
                                                                const selectedDate = new Date(event.target.value);
                                                                dateInput.value = formatDate(selectedDate);
                                                            });

                                                            // Event listener for manual input
                                                            dateInput.addEventListener('input', function(event) {
                                                                const input = event.target;
                                                                const value = input.value;
                                                                const numbersOnly = value.replace(/\D/g, ''); // Remove non-numeric characters

                                                                if (numbersOnly.length <= 4) {
                                                                    // If user is still entering the year
                                                                    input.value = numbersOnly;
                                                                } else if (numbersOnly.length <= 6) {
                                                                    // If user is entering the month
                                                                    input.value = `${numbersOnly.slice(0, 4)}/${numbersOnly.slice(4)}`;
                                                                } else {
                                                                    // If user is entering the day
                                                                    input.value = `${numbersOnly.slice(0, 4)}/${numbersOnly.slice(4, 6)}/${numbersOnly.slice(6, 8)}`;
                                                                }
                                                            });

                                                            // Prevent non-numeric characters
                                                            dateInput.addEventListener('keypress', function(event) {
                                                                const key = event.key;
                                                                if (isNaN(key) && key !== '/') {
                                                                    event.preventDefault();
                                                                }
                                                            });

                                                            // Prevent pasting invalid characters
                                                            dateInput.addEventListener('paste', function(event) {
                                                                const clipboardData = event.clipboardData || window.clipboardData;
                                                                const pastedData = clipboardData.getData('text');
                                                                if (!/^\d{4}\/\d{2}\/\d{2}$/.test(pastedData)) {
                                                                    event.preventDefault();
                                                                }
                                                            });
                                                            </script>


                                                            </div>
                                                            <div class="row mt-2 mb-2">
                                                                <div class="col-3">
                                                                    <label>MEDICAL PROBLEM :</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <textarea type="text" id="medicalProblem"
                                                                        class="form-control " value=""></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3"></div>
                                                        </div>

                                                        <div style="border: 1px solid lightblue;" class="col-5">
                                                            <div class="row mt-1 head">
                                                                <div class="col-2">
                                                                    <img class="icon" src="./src/img/notPaid.png"
                                                                        alt="medical">
                                                                </div>
                                                                <div class="col-9">
                                                                    <h5 for="">NOT PAID DETAILS</h5>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <table class="table table-bordered ">
                                                                    <thead>
                                                                        <tr>
                                                                            <td>SERIAL</td>
                                                                            <td>DATE </td>
                                                                            <td>NOT PAID</td>


                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tbody">

                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="2">TOTAL</td>

                                                                            <td></td>

                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                </div>
                            </div>
                        </div>
                        <div class="col-3" style="background: white; ">
                            <div class="mt-2 ml-3" style="height:100% ; color: black;  ">
                                <div class="row">
                                    <div class="row head">
                                        <div class="col-2 mt-1">
                                            <img class="icon" src="./src/img/summary.png" alt="">
                                        </div>
                                        <div class="col-8 mt-1">
                                            <h5 for="">SUMMARY</h5>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12">
                                            <label for="patientname2">NAME :</label>
                                            <input class=" form-control " style="font-size: 30px ;" type="text"
                                                name="patientname2" id="patientname2" value="">

                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12">
                                            <label for="amount">AMOUNT :</label>
                                            <input class=" form-control "
                                                style="font-size: 50px ; background: #d3cbd3 ;" type="text"
                                                name="amount" id="amount" value="" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="medicalHistory">PAST HISTORY :</label>
                                            <input class=" form-control text-xs  " type="text" name="medicalHistory"
                                                id="medicalHistory" value="" multiple>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="allergies">ALLERGIES:</label>
                                            <input class=" form-control text-xs " type="text" name="allergies"
                                                id="allergies" value="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <button data-toggle="tooltip" data-placement="top" title="Download"
                                                id="submitBtn" onclick="submitForm()"
                                                class="btn btn-outline-info text-start  form-control">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    class="bi bi-download  h-auto w-25 " viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                                </svg> SAVE
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button data-toggle="tooltip" data-placement="top" title="Clear"
                                                class="btn btn-outline-danger text-start form-control"
                                                onclick="clearFields()"><svg xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor" class="bi bi-x text-start h-auto w-25 "
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg> CLEAR
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Choices.js library -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

    <!-- Your custom JavaScript -->
    <script>
    function showAlert(message) {
        // Configure Toastr options
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Show the Toastr alert
        toastr.warning(message);
    }





    function calculateAge(dob) {
        const birthDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age;
    }

    function docFilterTable() {
    fetch("./attributes/fetchPatientDeta.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(patientData => {
            const fromDate = document.getElementById('docFromDate').value;
            const toDate = document.getElementById('docToDate').value;
            const docSelect = document.getElementById('docSelect').value;

            if (!fromDate || !toDate || !docSelect) {
                alert('Please provide both from, to dates and doctor.');
                return;
            }

            const startDate = new Date(fromDate);
            const endDate = new Date(toDate);

            if (isNaN(startDate) || isNaN(endDate)) {
                console.error('Invalid date format.');
                return;
            }

            // Ensure endDate includes the entire day
            endDate.setHours(23, 59, 59, 999);

            const filteredData = patientData.filter(entry => {
                const entryDate = new Date(entry.created_at);
                return entryDate >= startDate && entryDate <= endDate && entry.doctor === docSelect;
            });

            const formattedData = filteredData.map(entry => {
                const serial = entry.serial;
                const name = entry.name;
                const remark = entry.remark;
                const age = calculateAge(entry.dob);
                const paymentMethod = entry.paymentMethod;
                const remain = parseFloat(entry.remain) || 0;
                const jmc = parseFloat(entry.jmc) || 0;
                const jd = parseFloat(entry.jd) || 0;
                const total = jmc + jd;

                // Convert entry.created_at from UTC to SLST
                const createdAtUTC = new Date(entry.created_at);

                // Manually adjust the time zone offset
                const SLST_OFFSET = 5.5 * 60 * 60 * 1000; // 5.5 hours in milliseconds
                const createdAtSLST = new Date(createdAtUTC.getTime() + SLST_OFFSET);

                // Get individual date components
                const year = createdAtSLST.getFullYear();
                const month = String(createdAtSLST.getMonth() + 1).padStart(2,'0'); // Months are zero-based
                const day = String(createdAtSLST.getDate()).padStart(2, '0');
                const hours = String(createdAtSLST.getHours()).padStart(2, '0');
                const minutes = String(createdAtSLST.getMinutes()).padStart(2, '0');

                // Format the date as yyyy/mm/dd hh:mm
                const createdAtFormatted = `${year}/${month}/${day} ${hours}:${minutes}`;

                return {
                    SERIAL: serial,
                    NAME: name,
                    AGE: age,
                    CREATED_AT: createdAtFormatted,
                    REMARK: remark,
                    PMETHOD: paymentMethod,
                    NPAID: remain,
                    JMC: jmc,
                    JD: jd,
                    TOTAL: total
                };
            });

            const tableBody = document.getElementById('docTableBody');
            tableBody.innerHTML = '';

            // Initialize totals as numbers
            let totalNP = 0;
            let totalJMC = 0;
            let totalJD = 0;
            let grandTotal = 0;

            formattedData.forEach(data => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="text-center">${data.SERIAL}</td>
                    <td>${data.NAME}</td>
                    <td class="text-center">${data.AGE}</td>
                    <td class="text-center">${data.CREATED_AT}</td>
                    <td class="text-center">${data.REMARK}</td>
                    <td class="text-center">${data.PMETHOD}</td>
                    <td class="text-center">${data.NPAID.toFixed(2)}</td>
                    <td class="text-end">${data.JMC.toFixed(2)}</td>
                    <td class="text-end">${data.JD.toFixed(2)}</td>
                    <td class="text-end">${data.TOTAL.toFixed(2)}</td>
                `;
                tableBody.appendChild(row);

                // Update the totals, ensuring values are numbers
                totalNP += Number(data.NPAID);
                totalJMC += Number(data.JMC);
                totalJD += Number(data.JD);
                grandTotal += Number(data.TOTAL);
            });

            // Add totals row at the bottom
            const totalsRow = document.createElement('tr');
            totalsRow.innerHTML = `
                <td  class="text-end"><strong>Totals</strong></td>
                <td class="text-end"></td>
                <td class="text-end"></td>
                <td class="text-end"></td>
                <td class="text-end"></td>
                <td class="text-end"></td>
                <td class="text-end"><strong>${totalNP.toFixed(2)}</strong></td>
                <td class="text-end"><strong>${totalJMC.toFixed(2)}</strong></td>
                <td class="text-end"><strong>${totalJD.toFixed(2)}</strong></td>
                <td class="text-end"><strong>${grandTotal.toFixed(2)}</strong></td>
            `;
            tableBody.appendChild(totalsRow);

          

        })
        .catch(error => {
            console.error('Error fetching patient data:', error);
        });
}







    document.getElementById('docReportPDF').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
            const { autoTable } = window.jspdf.jsPDF;
            const doc = new jsPDF();

            // Get table data
            const table = document.getElementById('docCashTable');
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent);
            const rows = Array.from(table.querySelectorAll('tbody tr')).map(row =>
                Array.from(row.querySelectorAll('td')).map(td => td.textContent)
            );

            // Add table to PDF using autoTable
            doc.autoTable({
                head: [headers],
                body: rows,
                startY: 20, // Starting Y position
                theme: 'grid',
                headStyles: { fillColor: [0, 0, 255] }, // Blue header background
                styles: { overflow: 'linebreak' }, // Handle long text
                margin: { top: 30 },
                didDrawPage: (data) => {
                    doc.text(`Generated on: ${new Date().toLocaleString()}`, 10, doc.internal.pageSize.height - 10);
                }
            });

            // Save the PDF
            doc.save(`Doc Cash Report ${new Date().toISOString().split('T')[0]}.pdf`);
        
    });










    document.addEventListener('DOMContentLoaded', (event) => {
        const fromDateInput = document.getElementById('fromDate');
        const toDateInput = document.getElementById('toDate');
        const toast = document.getElementById('toast');

        function showToast(message) {
            toast.textContent = message;
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        function validateDateRange() {
            const fromDate = new Date(fromDateInput.value);
            const toDate = new Date(toDateInput.value);

            if (toDate - fromDate > 3 * 24 * 60 * 60 * 1000) { // 3 days in milliseconds
                showToast('Date range cannot exceed 3 days.');
                toDateInput.value = '';
            }
        }

        fromDateInput.addEventListener('change', () => {
            nurse = document.getElementById('nurseName1').value;
            console.log('nurse',nurse);
            if (nurse != 'RAVI  NANAYAKKARA'){
                if (toDateInput.value) {
                validateDateRange();
            }
            }
          
        });

        toDateInput.addEventListener('change', () => {
            nurse = document.getElementById('nurseName1').value;
            console.log('nurse',nurse);
            if (nurse != 'RAVI  NANAYAKKARA'){
                if (fromDateInput.value) {
                validateDateRange();
            }
            }
           
        });
    });




    function filterTable() {
    fetch("./attributes/fetchPatientDeta.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(patientData => {
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            if (!fromDate || !toDate) {
                console.error('Please provide both from and to dates.');
                return;
            }

            const startDate = new Date(fromDate);
            const endDate = new Date(toDate);

            if (isNaN(startDate) || isNaN(endDate)) {
                console.error('Invalid date format.');
                return;
            }

            endDate.setHours(23, 59, 59, 999);

            const filteredData = patientData.filter(entry => {
                const entryDate = new Date(entry.updated_at);
                return entryDate >= startDate && entryDate <= endDate;
            });

            const groupedData = {};
            filteredData.forEach(entry => {
                const entryDate = new Date(entry.updated_at);
                const nurse = entry.cashNurse;
                const paymentMethod = entry.paymentMethod;
                const year = entryDate.getFullYear();
                const month = ('0' + (entryDate.getMonth() + 1)).slice(-2);
                const day = ('0' + entryDate.getDate()).slice(-2);
                const dateString = `${year}/${month}/${day}`;

                if (!groupedData[dateString]) {
                    groupedData[dateString] = {};
                }

                if (!groupedData[dateString][nurse]) {
                    groupedData[dateString][nurse] = {
                        cash: 0,
                        card: 0,
                        bank: 0
                    };
                }

                let received = parseFloat(entry.received);
                let cardValue = parseFloat(entry.card || 0);

                if (paymentMethod === 'cash&card') {
                    groupedData[dateString][nurse].cash += received - cardValue;
                    groupedData[dateString][nurse].card += cardValue;
                } else if (paymentMethod === 'cash') {
                    groupedData[dateString][nurse].cash += received;
                } else if (paymentMethod === 'card') {
                    groupedData[dateString][nurse].card += received;
                } else if (paymentMethod === 'bank') {
                    groupedData[dateString][nurse].bank += received;
                }
            });

            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            let sumOfTotals = 0;
            let sumOfCard = 0;
            let sumOfCash = 0;
            let sumOfBank = 0;

            for (const date in groupedData) {
                if (groupedData.hasOwnProperty(date)) {
                    for (const nurse in groupedData[date]) {
                        if (groupedData[date].hasOwnProperty(nurse)) {
                            const data = groupedData[date][nurse];
                            const total = data.cash + data.card + data.bank;
                            sumOfCash += data.cash;
                            sumOfCard += data.card;
                            sumOfBank += data.bank;
                            sumOfTotals += total;
                            addRow(tableBody, date, nurse, data.cash, data.card, data.bank, total);
                        }
                    }
                }
            }

            // Display the sum of totals in the footer
            document.getElementById('sumOfTotals').textContent = sumOfTotals.toFixed(2);
            document.getElementById('sumOfCash').textContent = sumOfCash.toFixed(2);
            document.getElementById('sumOfCard').textContent = sumOfCard.toFixed(2);
            document.getElementById('sumOfBank').textContent = sumOfBank.toFixed(2);
        })
        .catch(error => {
            console.error('Error fetching patient data:', error);
        });
}

function addRow(tableBody, date, nurse, cash, card, bank, total) {
    const row = document.createElement('tr');

    const dateCell = document.createElement('td');
    dateCell.textContent = date;
    row.appendChild(dateCell);

    const nurseCell = document.createElement('td');
    nurseCell.textContent = nurse;
    row.appendChild(nurseCell);

    const cashCell = document.createElement('td');
    cashCell.textContent = cash.toFixed(2);
    row.appendChild(cashCell);

    const cardCell = document.createElement('td');
    cardCell.textContent = card.toFixed(2);
    row.appendChild(cardCell);

    const bankCell = document.createElement('td');
    bankCell.textContent = bank.toFixed(2);
    row.appendChild(bankCell);

    const totalCell = document.createElement('td');
    totalCell.textContent = total.toFixed(2);
    row.appendChild(totalCell);

    tableBody.appendChild(row);
}
    // Function to download the table as PDF
    document.getElementById('cashReportPDF').addEventListener('click', function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'pt',
            format: 'a4'
        });

        // Get the table element
        const table = document.getElementById('cashTable');

        // Use html2canvas to take a snapshot of the table and convert it to an image
        html2canvas(table, {
            scale: 5, // Increase the scale for better quality
            useCORS: true // Enable cross-origin resource sharing if necessary
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');

            // Calculate image dimensions to fit into PDF
            const imgWidth = 595.28; // A4 width in points
            const pageHeight = 841.89; // A4 height in points
            const imgHeight = canvas.height * imgWidth / canvas.width;
            let heightLeft = imgHeight;
            let position = 0;

            // Add the image to the PDF
            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            // If content spans multiple pages
            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                doc.addPage();
                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
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
            doc.text(dateTimeString, 40, doc.internal.pageSize.height - 30);

           
            today = new Date();
            const currentDate = new Date().toISOString().split('T')[0];
                    const fileName = `Nurse Cash Report ${currentDate}.pdf`;
                    doc.save(fileName);
        });
    });


    //console.log('data',data);


    //populateTable();








    var searchInput = document.getElementById('serialNumber');
    var serialList = document.getElementById('serialList');
    var patientNameInput = document.getElementById('patientName');
    var jdInput = document.getElementById('jd'); // Add a class 'jd-input' to JD input
    var npInput = document.getElementById('np'); // Add a class 'np-input' to NP input
    var totalInput = document.getElementById('total'); // Add a class 'total-input' to Total input
    var receivedInput = document.getElementById('recieved'); // Add a class 'received-input' to Received input
    var remainInput = document.getElementById('remain'); // Add a class 'remain-input' to Remain input
    var nextVisitDateInput = document.getElementById('nvd'); // Add a class 'next-visit-date-input' to Next Visit Date input
    var medicalProblemTextarea = document.getElementById('medicalHistory');
    var allergies = document.getElementById('allergies');
    var patientname2 = document.getElementById('patientname2');
    var remark = document.getElementById('remark');
    var handCash = document.getElementById('handCash');




    const cashInput = document.getElementById('cardInput');

    // Function to toggle visibility of cashInput based on radio button selection
    function toggleCashInputVisibility() {
        if (this.value === 'cash&card') {
            cashInput.classList.remove('hidden');
        } else {
            cashInput.classList.add('hidden');
        }
    }

    // Add event listener to radio buttons
    const radioButtons = document.querySelectorAll('input[name="paymentMethod"]');
    radioButtons.forEach(button => {
        button.addEventListener('change', toggleCashInputVisibility);
    });






    // Declare selectedPatient outside the event listener
    let selectedPatient;

    function updateSuggestions() {
        var inputValue = searchInput.value.trim().toLowerCase();
        serialList.innerHTML = '';

        fetch("./attributes/fetchPatientDeta.php")
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                patientData = data;
                // console.log(patientData);
                const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

                const filteredData = patientData.filter(patient => {
                    if (!patient || !patient.serial || !patient.created_at || patient.jmcStatus == 'QUOTATION') {
                        console.error('Invalid patient data:', patient); 
                        return false; // Skip this patient
                    }




                    // Log patient data for debugging
                    //console.log('Patient data:', patient);

                    const serialMatches = patient.serial.toLowerCase().startsWith(inputValue);
                    //const createdAtMatches = patient.created_at.split(' ')[0] === today;
                    const lvMatches = patient.lv === '0'; // Compare with '0' as a string

                    //console.log('Serial matches:', serialMatches);
                    //console.log('Created at matches:', createdAtMatches);
                    //console.log('LV matches:', lvMatches);

                    return serialMatches && lvMatches;
                });
                const serialNumbers = filteredData.map(patient => patient.serial);

                serialNumbers.forEach(serialNumber => {
                    var li = document.createElement('li');
                    li.textContent = serialNumber;
                    li.addEventListener('click', function() {
                        // Set the selected serial number in the input field
                        searchInput.value = serialNumber;

                        // Set the corresponding name in the patientName input field
                        selectedPatient = filteredData.find(patient => patient.serial === serialNumber);
                        if (selectedPatient) {
                            patientNameInput.value = selectedPatient.name;
                            patientname2.value = selectedPatient.name;
                            jdInput.value = selectedPatient.jd || '';
                            npInput.value = selectedPatient.remain || '';
                            dateOfBirth = selectedPatient.dob || '';
                            filterName = selectedPatient.name;
                            filterDataByDOB(dateOfBirth, filterName);
                            totalInput.value = calculateTotal(selectedPatient) + selectedPatient.remain;
                            inputTotal = calculateSum(calculateTotal(selectedPatient)); // Pass the total to calculateSum
                            receivedInput.value = calculateTotal(selectedPatient);
                            remainInput.value = totalInput.value - receivedInput.value;
                            nextVisitDateInput.value = '';
                            allergies.value = selectedPatient.allergies;
                            medicalProblemTextarea.value = selectedPatient.medicalHistory || '';

                            remark.value = selectedPatient.remark || '';
                        }


                        // Clear the suggestions
                        serialList.innerHTML = '';
                    });
                    serialList.appendChild(li);
                });

                serialList.style.display = serialNumbers.length > 0 ? 'block' : 'none';
            })
            .catch(error => console.error('Fetch error:', error));
    }

    searchInput.addEventListener('input', function() {
        updateSuggestions()
        /* .then(selectedPatient => {
             if (selectedPatient) {
                 filterDataByDOB(selectedPatient.dob,selectedPatient.name );
             }
         })
         .catch(error => console.error('Error processing selected patient:', error)); */
    });



    var filteredPatient; // Define filteredPatient in a broader scope

    // Function to perform logout
    function logout() {
        fetch("./attributes/fetchPatientDeta.php")
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(patientData => {
                // Filter patientData where lv is equal to '0'
                const filteredData = patientData.filter(patient => {
                    return patient.lv === '0' && patient.jmcStatus != 'QUOTATION';
                });

                // Check if there are any filtered data
                if (filteredData.length > 0) {
                    let popUpContent =
                        '<label>YOU CANNOT LOG OUT! FOLLOWING PATIENTS ARE STILL INSIDE</label> <br>'; // Start the table

                    // Table header
                    popUpContent += '<table class="table table-sm ">';
                    popUpContent += '<thead><tr>';
                    popUpContent += '<th>SERIAL</th><th>NAME</th><th>NURSE</th><th>LAST VISIT</th>';
                    popUpContent += '</tr></thead>';

                    // Table body
                    popUpContent += '<tbody>';
                    filteredData.forEach(patient => {
                        // Convert patient.created_at from UTC to SLST
                        const createdAtUTC = new Date(patient.created_at);

                        // Manually adjust the time zone offset
                        const SLST_OFFSET = 5.5 * 60 * 60 * 1000; // 5.5 hours in milliseconds
                        const createdAtSLST = new Date(createdAtUTC.getTime() + SLST_OFFSET);

                        // Get individual date components
                        const year = createdAtSLST.getFullYear();
                        const month = String(createdAtSLST.getMonth() + 1).padStart(2,
                            '0'); // Months are zero-based
                        const day = String(createdAtSLST.getDate()).padStart(2, '0');
                        const hours = String(createdAtSLST.getHours()).padStart(2, '0');
                        const minutes = String(createdAtSLST.getMinutes()).padStart(2, '0');
                        const seconds = String(createdAtSLST.getSeconds()).padStart(2, '0');

                        // Format the date as yyyy/mm/dd hh:mm:ss
                        const createdAtFormatted = `${year}/${month}/${day} ${hours}:${minutes}`;

                        //console.log('createdAtUTC', createdAtUTC);
                        //console.log('createdAtSLST', createdAtSLST);
                        //console.log('createdAtFormatted', createdAtFormatted);

                        popUpContent +=
                            `<tr><td>${patient.serial}</td><td>${patient.name}</td><td>${patient.cashNurse}</td><td>${createdAtFormatted}</td></tr>`;
                    });
                    popUpContent += '</tbody>';

                    popUpContent += '</table>'; // End the table

                    showAlert(popUpContent); // Show alert with the constructed content
                } else {
                    // Display confirmation message for logout
                    if (confirm('Are you sure you want to log out?')) {
                        // If user confirms logout, redirect to index.php
                        var xhr = new XMLHttpRequest();
                        xhr.open("GET", "./attributes/logout.php", true);
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                // Redirect to index.php after successful logout
                                window.location.href = "./index.php";
                            }
                        };
                        xhr.send();
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching patient data:', error);
            });
    }


    var inputElement = document.getElementById('nurseName1');
    var fullName = inputElement.value;

    // Display the value in the console
    //console.log("Input Value:", fullName);

    fetch("./attributes/fetchPatientDeta.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            patientData = data;

            const filterCash = patientData.filter(patient => {
                // Convert patient's created_at to timestamp
                const patientTimestamp = Math.floor(new Date(patient.updated_at).getTime() / 1000);
                const createdAtDate = new Date(patient.updated_at); // Create a Date object
                const pmonth = createdAtDate.getMonth() + 1; // Extract the month and add 1
                const pday = createdAtDate.getDate(); // Extract the day of the month
                const pyear = createdAtDate.getFullYear(); // Extract the year
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth() + 1; // Extract the month and add 1
                const day = currentDate.getDate(); // Extract the day of the month

                const toDay = year + '-' + month + '-' + day;
                const patientDate = pyear + '-' + pmonth + '-' + pday;
                //console.log('toDay', toDay);
                //console.log('patientDate', patientDate);
                return (toDay === patientDate) && (patient.paymentMethod === 'cash' || patient
                    .paymentMethod === 'cash&card') ;
            });

            var totals = filterCash.map(patient => parseFloat(patient.received || 0));
            var cards = filterCash.map(patient => parseFloat(patient.card || 0));

            // Calculate the sum of all totals
            var sumOfTotals = totals.reduce((acc, curr) => {
                // Add the current value to the accumulator
                return acc + curr;
            }, 0);
            var sumOfCard = cards.reduce((acc, curr) => {
                // Add the current value to the accumulator
                return acc + curr;
            }, 0);
            // Log the sum of totals
            //console.log("Sum of Totals:", sumOfTotals);
            //console.log("sumOfCard", sumOfCard);
            var totalCash;
            if (sumOfTotals > sumOfCard) {
                totalCash = parseFloat(sumOfTotals) - parseFloat(sumOfCard);
            } else {
                totalCash = parseFloat(sumOfCard) - parseFloat(sumOfTotals);
            }

            //console.log('totalCash',totalCash)
            handCash.value = totalCash;

            //console.log('filterCash',filterCash)
        })
        .catch(error => {
            console.error("Error fetching patient data:", error);
        });




    function filterDataByDOB(dob, name) {
        const dobFilteredData = patientData.filter(patient => patient.dob === dob && patient.name === name);

        // Display the filtered data in the console
        //console.log("Filtered Data by DOB:", dobFilteredData);
        populateTableByDOB(dobFilteredData)
        // You can further process or display the data as needed
    }

    // Example usage: Call this function with a specific DOB
    // Replace 'desiredDOB' with the actual DOB you want to filter

    var notPaid = 0;

    function populateTableByDOB(filteredData) {
        // Clear existing table content
        tbody.innerHTML = '';

        // Filter data with non-null and non-zero np values
        const validData = filteredData.filter(patient => patient.np !== null && patient.np !== 0);

        // Iterate over the filtered data and populate the table
        validData.forEach(patient => {
            const tr = document.createElement('tr');
            const serialNoCell = document.createElement('td');
            const dateCell = document.createElement('td');
            const notPaidAmountCell = document.createElement('td');

            // Set cell values based on the patient data
            serialNoCell.textContent = patient.serial;
            dateCell.textContent = patient.updated_at; // Add the date property from the patient data
            notPaidAmountCell.textContent = parseFloat(patient.remain) *2; // Add the notPaidAmount property from the patient data
            npInput.value = parseFloat(patient.remain) * 2;
            notPaid = parseFloat(patient.remain) * 2;

            // Append cells to the table row
            tr.appendChild(serialNoCell);
            tr.appendChild(dateCell);
            tr.appendChild(notPaidAmountCell);

            // Append the row to the tbody
            tbody.appendChild(tr);
        });
    }



    // Function to calculate the sum
    function calculateSum(inputTotal, jmcInputValue) {
        // Get the jmc value from the parameter
        jdValue = document.getElementById('jd').value;

        var jmcValue = parseFloat(jmcInputValue) || 0;
        var jdNValue = parseFloat(jdValue) || 0;


        // Calculate the sum
        bsum = inputTotal+ jmcValue;
        var sum = 'Rs' + bsum + '/=';

        // Display the result or use it as needed
        document.getElementById('total').value = bsum;
        document.getElementById('amount').value = sum;
        document.getElementById('recieved').value = bsum;
        //console.log('Sum:', sum);
        //console.log('Not paid:', selectedPatient.remain);


        return sum; // Return the calculated sum if needed
    }

    // Attach event listener to 'jmc' input field
    document.getElementById('jmc').addEventListener('input', function() {
        // Check if selectedPatient is defined before using it
        if (selectedPatient) {
            // Recalculate the sum when 'jmc' input changes
            var totalValue = calculateTotal(selectedPatient); // Make sure 'calculateTotal' function is defined
            var jmcInputValue = this.value; // Get the 'jmc' input value

            inputTotal = calculateSum(totalValue, jmcInputValue);
            // Pass the total and 'jmc' input value to calculateSum
        }
    });

    document.getElementById('jd').addEventListener('input', function() {

        var jdValue = this.value; // Get the 'jmc' input value
        // console.log('jdValue',jdValue)

    });
    document.getElementById('recieved').addEventListener('input', function() {
        var recievedValue = parseFloat(this.value) || 0;
        //console.log('recievedValue:', recievedValue);
        //console.log('inputTotal:', inputTotal);

        // Remove unnecessary characters from inputTotal
        var totalValue = parseFloat(inputTotal.replace(/[^\d.]/g, '')) || 0;
        //console.log('totalValue:', totalValue);


        // Check if totalValue is a valid number
        if (isNaN(totalValue)) {
            console.error('Error: inputTotal is not a valid number');
            return;
        }

        // Calculate the remaining value
        var remainingValue = totalValue - recievedValue;

        // Display the remaining value inside the console
        // console.log('Remaining:', remainingValue);
        document.getElementById('remain').value = remainingValue;
    });



    // Your existing code ...


    // Function to calculate the total based on JD, JMC, and NP values
    function calculateTotal(patient) {

        const jd = parseFloat(patient.jd) || 0;


        return jd + parseFloat(notPaid);
    }




    function fetchData() {
        // Make an AJAX request to the PHP file
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "./attributes/fetchDoctors.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Parse the JSON response
                var data = JSON.parse(xhr.responseText);
                //console.log(data);
                // Log the data in the console

                // Call a function to populate the select options
                populateSelectOptions(data);
            }
        };
        xhr.send();
    }

    // Function to populate select options
    function populateSelectOptions(data) {
        var selectElement = document.getElementById("doctor");
        var docSelect = document.getElementById("docSelect");
        var docNameInput = document.getElementById("docName");

        // Retrieve the selected index from localStorage
        var savedIndex = localStorage.getItem("selectedDoctorIndex");

        // Clear existing options and set a default option
        selectElement.innerHTML = '<option value="" selected>Select Doctor</option>';
        docSelect.innerHTML = '<option value="" selected>Select Doctor</option>';

        // Loop through the data and add options to the select element
        for (var i = 0; i < data.length; i++) {
            var option = document.createElement("option");
            option.value = data[i].userCode; // You can modify this as needed
            option.text = data[i].userCode;
            selectElement.add(option);
            //docSelect.add(option);
        }
        for (var i = 0; i < data.length; i++) {
            var option = document.createElement("option");
            option.value = data[i].userCode; // You can modify this as needed
            option.text = data[i].userCode;
            //selectElement.add(option);
            docSelect.add(option);
        }

        // Set the selected index based on localStorage or default to 0
        selectElement.selectedIndex = savedIndex ? parseInt(savedIndex, 10) : 0;
        docSelect.selectedIndex = savedIndex ? parseInt(savedIndex, 10) : 0;

        // Update the input field with the selected doctor's full name
        updateDocNameInput();

        // Add an event listener for the 'change' event on the select element
        selectElement.addEventListener("change", function() {
            // Save the selected index to localStorage
            localStorage.setItem("selectedDoctorIndex", selectElement.selectedIndex);

            // Update the input field with the selected doctor's full name
            updateDocNameInput();
        });

        function updateDocNameInput() {
            // Get the selected index
            var selectedIndex = selectElement.selectedIndex;

            // Update the input field with the selected doctor's full name
            if (selectedIndex > 0) {
                var selectedDoctor = data[selectedIndex - 1].fullName;
                docNameInput.value = selectedDoctor;



                //console.log(selectedDoctor )
                fetchPatientCount(selectedDoctor);
            } else {
                // Clear the input field if no doctor is selected
                docNameInput.value = "";
            }
        }

        function fetchPatientCount(doctorName) {
            // Fetch patient count from the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            //console.log('Patient Count:', response.patientCount);
                            document.getElementById('patientCount').value = response.patientCount;


                        } else {
                            console.error('Error fetching patient count:', response.error);
                        }
                    } else {
                        console.error('Failed to fetch patient count. HTTP status:', xhr.status);
                    }
                }
            };

            // Send a GET request to the PHP script
            xhr.open('GET', './attributes/fetchPatientCount.php?doctor=' + encodeURIComponent(doctorName), true);
            xhr.send();
        }
    }
    // Call the fetchData function
    fetchData();

    function clearFields() {
        location.reload();
    }

    function submitForm() {
        const userCode = '<?php echo $userCode?>';
        var card = document.getElementById('cardInput').value / 2;
        var serialNumber = document.getElementById('serialNumber').value;
        var patientNameInput = document.getElementById('patientName').value;
        var jdInput = document.getElementById('jd').value /
            2; // Assuming jd is an input element with a 'value' property
        var jmcInput = document.getElementById('jmc').value /
            2; // Assuming jmc is an input element with a 'value' property
        var npInput = document.getElementById('np').value /
            2; // Assuming np is an input element with a 'value' property
        var totalInput = document.getElementById('total').value /
            2; // Assuming total is an input element with a 'value' property
        var receivedInput = document.getElementById('recieved').value /
            2; // Add a class 'received-input' to Received input
        var remainInput = document.getElementById('remain').value /
            2; // Assuming remain is an input element with a 'value' property
        var nextVisitDateInput = document.getElementById('nvd')
            .value; // Assuming nvd is an input element with a 'value' property
        var medicalHistory = document.getElementById('medicalHistory').value;
        var medicalProblem = document.getElementById('medicalProblem').value;
        var allergies = document.getElementById('allergies').value;
        var remark = document.getElementById('remark').value;
        var doctor = document.getElementById('doctor').value;

        // Get selected payment method
        var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;



        // Create a data object to send to the server
        var data = {
            doctor: doctor,
            card: card,
            userCode: userCode,
            serialNumber: serialNumber,
            patientNameInput: patientNameInput,
            jdInput: jdInput,
            jmcInput: jmcInput,
            npInput: npInput,
            totalInput: totalInput,
            receivedInput: receivedInput,
            remainInput: remainInput,
            nextVisitDateInput: nextVisitDateInput,
            medicalHistory: medicalHistory,
            medicalProblem: medicalProblem,
            allergies: allergies,
            remark: remark,
            paymentMethod: paymentMethod // Add payment method to data object*/
        };

        //console.log('updating data' , data);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', './attributes/updatePatient.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Handle successful response from PHP script
                    console.log(xhr.responseText);
                    // You can process the response here if needed
                    location.reload();
                } else {
                    // Handle errors
                    console.error('Error:', xhr.status);
                }
            }
        };

        if(doctor=='' || doctor == 'SELECT'){
            alert('PLEASE SELECT DOCTOR BEFORE SUBMIT THE DATA')
        }
        if(jmcInput == 0 || jmcInput < 0 || jmcInput == ''){
            alert('PLEASE FILL JMC BEFORE SUBMIT THE DATA')
        }
        else{
            xhr.send(JSON.stringify(data));
        }


        // Now 'data' object contains the values of your form inputs
        /*
           fetch('./attributes/updatePatient.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                console.log(result);
                if (result.status === 'success') {
                    // Show a success toast message
                    Toastify({
                        text: "Success! Your action was completed.",
                        duration: 9000, // Duration in milliseconds
                        close: true, // Whether to show a close button
                        gravity: "bottom", // Display position
                        position: 'right', // Toast position (top, bottom, left, right)
                        backgroundColor: "green", // Background color
                    }).showToast();

                    // Reload the page after successful update
                    location.reload();
                } else {
                    // Show an error toast message
                    Toastify({
                        text: `Error: ${result.message}`,
                        duration: 9000, // Duration in milliseconds
                        close: true, // Whether to show a close button
                        gravity: "bottom", // Display position
                        position: 'right', // Toast position (top, bottom, left, right)
                        backgroundColor: "red", // Background color
                    }).showToast();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show an error toast message for network errors
                Toastify({
                    text: "Network error! Please try again later.",
                    duration: 9000, // Duration in milliseconds
                    close: true, // Whether to show a close button
                    gravity: "bottom", // Display position
                    position: 'right', // Toast position (top, bottom, left, right)
                    backgroundColor: "red", // Background color
                }).showToast();
            });*/
    }
    </script>
</body>

</html>