<?php
session_start();
// Include connection file
require_once './connection.php';

// Check if user_id is set in session
if (isset($_SESSION["user_id"])) {
    // Get the user ID from the session
    $user_id = $_SESSION["user_id"];

    // Prepare SQL query
    $sql = "SELECT fullName, userCode FROM system_user WHERE id = ?";

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
        $userCode =$row['userCode'];

    } else {
        // User not found, display error message
        echo "Error: User information not found.";
    }

    // Close statement and connection
  
} else {
    // User not logged in, redirect to login page using JavaScript
    echo '<script>window.location.href = "./index.php";</script>';
    exit();
}
?>


<?php

 include './connection.php';

// Query to fetch the last serial number
$sql = "SELECT serial FROM patient ORDER BY serial DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the last serial number
    $row = $result->fetch_assoc();
    $serialNum =  $row["serial"];
    //$serialNum += ;
} else {
    echo "No records found";
}


?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRATION</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./attributes/background.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./attributes/background.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>
   .input-with-star {
    position: relative;
}

.star-mark {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    padding: 0 5px; /* Adjust padding as needed */
    width: 10%;
    height: auto;
    cursor: pointer; /* Add cursor pointer to indicate it's clickable */
}

.special {
    color: gold; /* Change color to gold when clicked */
}


    a{
        font-weight: bold;
    }
    #allergyList {
        list-style: none;
        padding: 0;
        margin: 0;
        border: none;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-height: 250px;
        overflow-y: auto;
        position: absolute;
        width: 100%;
        z-index: 1;
        display: none;
        /* Adjust the positioning */
        bottom: 100%; /* Position the bottom of the list at the top of the input field */
        left: 0;
        background-color: #d3d3d3;
    }

    #allergyList li {
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #allergyList li:hover {
        background-color: #f0f0f0;
    }
    
    #mediList {
        list-style: none;
        padding: 0;
        margin: 0;
        border: none;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-height: 250px;
        overflow-y: auto;
        position: absolute;
        width: 100%;
        z-index: 1;
        display: none;
        /* Adjust the positioning */
        bottom: 100%; /* Position the bottom of the list at the top of the input field */
        left: 0;
        background-color: #d3d3d3;
    }

    #mediList li {
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #mediList li:hover {
        background-color: #f0f0f0;
    }

    .dropup-select .dropdown-toggle {
  -webkit-appearance: none; /* Remove default select arrow */
  -moz-appearance: none;
  appearance: none;
  background-color: transparent ;
  border: 1px solid dark;
  border-radius: 5px;
  padding: 10px 15px;
  width: 100px;
}

.dropup-select .dropdown-toggle:focus {
  outline: none;
  border-color: #66afe9;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.dropdown-menu {
  top: 100%; /* Position above the select element */
}

.table-container {
    max-height: 500px; /* Adjust the maximum height as needed */
    overflow-y: auto; /* Enable vertical scrolling when content exceeds the height */
}
.hidden-column {
    display: none;
}

.dob-hidden-column{
    display: none;
}

#hiddenTable {
            display: none;
        }

        /* CSS media query for printing */
        @media print {
            /* Show the hidden table only for printing */
            #hiddenTable {
                display: block;
            }

            /* Hide everything else on the page for printing */
            body > *:not(#hiddenTable) {
                display: none !important;
            }

            /* Set up the print area to match dot matrix print sheet dimensions */
            @page {
                size: 21.59cm 27.94cm; /* Set page size to match dot matrix print sheet */
                margin-top: 8px; /* Remove default margin */
                
                orientation: landscape; /* Force portrait orientation */
            }

            /* Optionally, you can adjust the font size and other styles for printing */
            body {
                font-size: 15pt;
                background-color: blue;
            }
             /* Increase font size for input fields */
            input[type="text"],
            input[type="password"],
            input[type="email"],
            input[type="number"],
            input[type="tel"],
            input[type="date"],
            input[type="time"],
            textarea {
                font-size: 13pt; /* Change the font size to your desired value */
                background: transparent;
                width: 150%;
            }

            /* Optionally, hide the title during printing */
            head {
                display: none;
            }
            label {
                font-weight:900;
                font-size: large;
                text-transform: uppercase;
                font-family: "Times New Roman", serif;
                margin-bottom: 3px;

            }
        }

        label{
            font-size: larger;
            text-transform: uppercase;
            font-weight: bolder;

        }

        input[type="text"] {
            text-transform: uppercase;}

</style>

</head>

<body>


<div class="conatiner h-25 mt-2 " id="hiddenTable">
    <div class="row ms-1">
        <div style=" font-size: 20px; " class="col-2 text-start mt-1">
            <b><?php echo $serialNum +1 ;?>  <label id="star"> </label></b>
        </div>
        <div class="form-floating mb-1 col-3 text-start text-lg">
            <input type="text" name="hidePastMediHis"  class="form-control border-0 " id="hidePastMediHis" value=" " >
            <label  for="hidePastMediHis">P Medi His:</label>
        </div>
        <div class="form-floating mb-1 col-3 text-start text-sm">
                <input type="text" name="hideAllergies" class="form-control border-0 " id="hideAllergies" value=" " >
                <label for="hideAllergies">Allergies :</label>
        </div>
        <div class="form-floating mb-1 col-3 text-start text-sm">
                <input type="text" name="hideMediProb" class="form-control border-0 "  value=" " >
                <label for="hideMediProb">Med Prob:</label>
        </div>
    </div>
    <div class="row ms-1 mb-5">
    <div class="form-floating mb-1 col-6 text-start text-sm">
            <input type="text" name="outMedi" class="form-control border-0 " id="outMedi" value=" " >
            <label for="outMedi">Out Medicine:</label>
        </div>

         <div class="form-floating mb-1 col-6 text-start text-sm">
            <input type="text" name="inMedi" class="form-control border-0 " id="inMedi" value=" " >
            <label for="inMedi">In Medicine:</label>
        </div>
       
       
    </div>
    <div style="position: absolute; top:17%; " >
        <div class="row"  >
            <div class="form-floating  col-12 text-center text-sm">
                <input name="hideName" type="text" class="form-control  text-sm border-0 " id="hideName" value="" >
            </div>
           <!-- <div class="form-floating col-2 text-start text-sm">
                <input type="text" name="hideSex" class="form-control bg-transparent  text-sm border-0 " id="hideSex" value="" >
            </div> -->
        </div>
        <div class="row " style="position: relative; top:-32px; ">
            <div class="form-floating col-12 text-start text-sm">
                <input type="text" name="hideBday" class="form-control  text-sm border-0 " id="hideBday" value="" >
            </div>
        </div>
        <div class="row " style="position: relative; top:-64px; ">
            <div class="form-floating col-12 text-start text-sm">
                <input type="text" name="hideAge" class="form-control  text-sm border-0" id="hideAge" value="" >
            </div>
        </div>
        
    </div>
    <div style="position:absolute; top:24%;" >
        <div class="row">
            <div class="form-floating  col-2 text-start text-sm">
                <input type="text" name="hideTel" class="form-control border-0 " id="hideTel" value="" >
            </div>
            <div class="form-floating col-3 ms-4 mt-3 text-end text-sm">
                <input type="text" name="hideNv" class="form-control border-0 " id="hideNv" value=" " >
                <label for="hideNv">&nbsp;  NEXT VISIT:</label>
            </div>
            <div class="form-floating col-2 text-end mt-3  text-sm">
                <input type="text" name="hideJmc" class="form-control border-0 " id="hideJmc" value=" " >
                <label for="hideJmc">RS:</label>
            </div>
        </div>
        <table class="table table-borderless " id="hideTable" >
            <thead>
                <tr>
                    <td>S</td>
                    <td>LV</td>
                    <td>Dr</td>
                    <td>MP</td>
                    <td>CN</td>
                    <td>PN</td>
                    <td>NV</td>
                    <td>JMC</td>
                    <td>JD</td>
                    <td>NP</td>
                </tr>
            </thead>
            <tbody>
            
            
                <!-- Repeat your table rows as needed -->
            </tbody>
        </table>
    </div>
 </div>
<nav class="navbar navbar-expand-lg navbar-light bg-info ">
  <div class="container-fluid">
    <a style="font-family: cursive ; color:purple;" class="navbar-brand" href="#">Jeewaka Medical Centre</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-4xl active" aria-current="page" href="home.php">PATIENT'S REGISTRATIONS</a>
        </li>
      </ul>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-sm btn btn-outline-dark " aria-current="page" href="./dashboard/pages/pages/users/patients.php">PATIENT'S LOOCKUP</a>
        </li>
      </ul>

    <div>
        <div class="d-flex align-items-center">
            <img src="./src/img/nurse1.png" class="rounded-circle" width="30" height="30" alt="User image" data-toggle="modal" data-target="#myModal">
            <input style="background:transparent; border: none; " class="form-control" type="text" id="nurseName1" value="<?php echo $fullName;?>" readonly>
            <input type="text" id="nurseCode" value="<?php echo $userCode ;?>" hidden >
            
        </div>
    </div>

<!-- Bootstrap Modal -->
<div style="color: black;" class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">SAMADARA PRIYADARSHANI</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
      <div class="row mt-3">
        <div class="col-6">
            <label>Patient Count : </label>
        </div>
        <div class="col-4">
            <input  class="input" type="number" readonly>
        </div>
    </div>
  
      </div>

      <!-- Modal Footer -->   
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" onclick="logout()">Logout</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

    </div>
  </div>
</nav>

    <!-- Page Content -->
    <div id="pageContent">
        <div id="page0" class="tab-pane fade show active">

        <div class="card mt-2" style="width: 100%; height:100% ; color: black; background:#ADD8E6; font-size: small; " >
            <div class="container-fluid" > 
                
               
                <div class="row mt-2">
                    <div class=" col-7">
                        <div class=" card mt-2 container-fluid " style="width: 100%; height:100% ; color: black; border:none;" >
                            <div>
                                <div  class="row head"  >
                                    <div class="col-1">
                                            <img class="icon" src="./src/img/medical.png" alt="medical">
                                    </div>
                                    <div class="col-11">
                                            <h3 for="">SESSION DETAILS</h3>
                                    </div>
                                    
                                </div>
                               

                                <div class="row mt-2">
                                    <div class="col-2">
                                        <label class="mt-1" ><b>DOCTOR</b></label>
                                    </div>
                                    <div class="col-3">
                                    <select class="form-select form-select-m" id="doctor" aria-label=".form-select-m example">
                                        <!-- Placeholder option, you can remove or modify this as needed -->
                                        <option >select</option>
                                    </select>
                                    </div>
                                    <div class="col-3 mt-1">
                                     <input style="color : red; font-size:xx-large"   class="input font-weight-bold text-xxl-center " name="docName" id="docName" type="text" value="" readonly >
                                    </div>
                                    <div class="col-2 mt-1" hidden>
                                     <label> Patients:</label>
                                    </div>
                                    <div class="col-1 mt-1" hidden>
                                        <input class="input font-weight-bold text-xxl-center " style="width:29px" name="patientCount" id="patientCount" type="text" value="" readonly >
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card mt-2  " style="width: 100%; height:100% ; color: black; border: none; " >
                                            <div>
                                                <div  class="row head">
                                                    <div class="col-1">
                                                            <img class="icon" src="./src/img/past-patient-details.png" alt="">
                                                    </div>
                                                    <div class="col-11">
                                                            <h4 for="">PATIENT'S DETAILS</h4>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <div class="form-floating mb-1">
                                                            <input type="text"  class="form-control " style="font-size: larger;"   placeholder="name@example.com" value="<?php echo $serialNum+1;?>" disabled >
                                                            <label for="floatingInput">SERIAL</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-floating mb-3">
                                                            <input type="time" class="form-control input-sm " id="oppointment" placeholder="name@example.com">
                                                            <label for="oppointment">OPPOINTMENT</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                      <div class=" mb-3">
                                                        <div class="input-group">
                                                          <input type="text" id="dateInput" class="form-control" placeholder="YYYY-MM-DD"  >
                                                          <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="refreshDateInput()">
                                                              <i class="fas fa-sync-alt"></i>
                                                            </button>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="age" placeholder="age" disabled >
                                                                <label for="age">AGE</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                <div class="col-6">
                                                <div class="form-label mb-3">
                                                    <label for="name">NAME</label>
                                                    <div class="input-with-star">
                                                        <input type="text" class="form-control" style="font-size: larger;" id="name" placeholder="Ex : M D L U Kavishka">
                                                        <!--<i class="fa fa-star star-mark"></i>-->
                                                    </div>
                                                </div>

                                                </div>
                                                <div class="col-6">
                                                    <div class="form-label mb-3">
                                                        <label for="tel">TEL</label>
                                                        <input type="text" class="form-control" name="tel" id="tel" placeholder="Ex : 0781234567" >
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row mb-2 ">
                                                <div class="col-2">
                                                        <label >STATUS : </label>
                                                    </div>
                                                    <div class="col-2 text-start ">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="special" value="0">
                                                            <label class="form-check-label" for="special">
                                                                REGULAR
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 ">
                                                        <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="status" value="1" id="n-special" checked >
                                                                <label class="form-check-label" for="n-special">
                                                                IRREGULAR
                                                                </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 text-end">
                                                        <label for="">GENDER : </label>
                                                    </div>
                                                    <div class="col-2 ">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sex" id="male" value="0" checked>
                                                            <label class="form-check-label" for="male">
                                                                MALE
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 ">
                                                        <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="sex" value="1" id="female" >
                                                                <label class="form-check-label" for="female">
                                                                    FEMALE
                                                                </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-label mb-3">
                                                            <label for="allergies">ALLERGIES</label>
                                                            <select class="js-example-basic-multiple form-select" id="allergies" multiple="multiple" >
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-label mb-3">
                                                            <label>MEDI HISTORY</label>
                                                            <select class="js-example-medical-history form-select" id="medicalHistory" multiple="multiple" >
                                                            </select>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-3">
                                    <button id="submit" class="btn btn-outline-dark ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                        </svg> SAVE
                                    </button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-outline-dark " onclick="clearFields()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                        </svg> CLEAR
                                    </button>
                                </div>

                                <div class="col-3">
                                    <div class="dropup-select">
                                        <select class="dropdown-toggle" id="dropdownMenuButton">
                                            <option>PRINT OLD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-danger "  id='print'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                                        </svg>PRINT
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="card mt-2 container-fluid " style="width: 100%; height:100% ; color: black; " >
                            <div class="row" >
                                <div  class="row ms-1 head">
                                    <div class="col-1">
                                        <img class="icon" src="./src/img/patient1.png" alt="">
                                    </div>
                                    <div class="col-11">
                                        <h3 for="">PAST PATIENT'S DETAILS</h3>
                                    </div> 
                                </div>
                                <div class="row mt-4 ms-1 table-container">
                                   <table class="table table-hover col-12" id="regTable">
                                    <thead>
                                        <tr>
                                            <td style="font-size: larger;" >SERIAL</td>
                                            <td style="font-size: larger;" >NAME</td>
                                            <td style="font-size: larger;" >LV</td>
                                            <td style="font-size: larger;" >DOC</td>
                                            <td style="font-size: larger;">NP</td>
                                            <td style="font-size: larger;" >SEX</td>
                                        </tr>
                                    </thead>
                                    <tbody style=" font-size: larger; " id="pastPatient" >
                                    </tbody>
                                   </table>                                 
                                </div>
                            </div>
                            <div class="row mt-5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">

            </div>
            </div>
        </div>
    </div>
    

   
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   <!-- Import jQuery (required for Select2) -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Import Select2 JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  

<script>

function handleInputChange(inputValue) {
            // Replace existing hyphens with an empty string
            let formattedValue = inputValue.replace(/-/g, '');

            // Assuming calculateAge is a function that calculates age based on the date
            const { years, months } = calculateAge(inputValue);
            document.getElementById('age').value = `${years} Y ${months} M`; // Set the age field

            // Format the date value with hyphens
            if (formattedValue.length > 4) {
                formattedValue = formattedValue.slice(0, 4) + '-' + formattedValue.slice(4);
            }
            if (formattedValue.length > 7) {
                formattedValue = formattedValue.slice(0, 7) + '-' + formattedValue.slice(7);
            }

            // Update the input field with the formatted value
            document.getElementById('dateInput').value = formattedValue;

            // Filtering logic
            const tbody = document.getElementById('pastPatient');
            const rows = tbody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const dobCell = rows[i].getElementsByTagName('td')[0];
                if (dobCell) {
                    const rowDate = dobCell.textContent || dobCell.innerText;
                    if (rowDate.startsWith(formattedValue)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }

        // Event listener for the input field
        document.getElementById('dateInput').addEventListener('input', (event) => {
            handleInputChange(event.target.value);
        });
        
        
        function initializeMedicalHistorySelect2(options) {
      // Clear existing options
      $('.js-example-medical-history').empty();

      // Use a Set to store unique medical history options
      var uniqueOptions = new Set();

      // Populate select options excluding empty values and duplicates
      options.forEach(function(item) {
        if (item.medicalHistory !== '' && !uniqueOptions.has(item.medicalHistory)) {
          $('.js-example-medical-history').append($('<option>', {
            value: item.medicalHistory, // Use the value directly
            text: item.medicalHistory // Use the value directly
          }));
          uniqueOptions.add(item.medicalHistory); // Add the option to the Set to track duplicates
        }
      });

      // Initialize Select2
      $('.js-example-medical-history').select2({
        tags: true, // Allow adding new tags
        tokenSeparators: [',', ' '], // Define separators for multiple tags
        width: '100%' // Set width of the dropdown
      });
    }

     // Function to update Select2 dropdown with a specific option
 function selectMediHis(selectedOption) {
      $('.js-example-medical-history').val(selectedOption).trigger('change');
    }
    // Function to fetch medical history from PHP script
    function fetchMedicalHistory() {
      $.ajax({
        url: './attributes/fetchMediHis.php', // Path to your PHP script
        dataType: 'json',
        success: function(data) {
          // Call initializeSelect2 with medical history values
          initializeMedicalHistorySelect2(data);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText); // Log error message
          alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER.'); // Show error message
        }
      });
    }

    // Call the function to fetch medical history when the page is ready
    $(document).ready(function() {
      fetchMedicalHistory();
    });
// Function to initialize Select2
function initializeSelect2(options) {
  // Clear existing options
  $('.js-example-basic-multiple').empty();

  // Populate select options excluding empty values
  options.forEach(function(item) {
    if (item !== '') { // Exclude empty values
      $('.js-example-basic-multiple').append($('<option>', {
        value: item, // Use the value directly
        text: item // Use the value directly
      }));
    }
  });

  // Initialize Select2
  $('.js-example-basic-multiple').select2({
    tags: true, // Allow adding new tags
    tokenSeparators: [',', ' '], // Define separators for multiple tags
    width: '100%' // Set width of the dropdown
  });
}

 // Function to update Select2 dropdown with a specific option
 function selectAllergie(selectedOption) {
      $('.js-example-basic-multiple').val(selectedOption).trigger('change');
    }

// Function to fetch allergies from PHP script
function fetchAllergies() {
  $.ajax({
    url: './attributes/fetchAllergies.php', // Path to your PHP script
    dataType: 'json',
    success: function(data) {
      //console.log('Fetched data:', data); // Log fetched data
      // Filter out duplicate values
      var uniqueAllergies = [...new Set(data.map(item => item.allergies))]; // Use Set to filter out duplicates
      //console.log('Unique allergies:', uniqueAllergies); // Log unique allergies
      
      // Call initializeSelect2 with unique allergy values
      initializeSelect2(uniqueAllergies);
    },
    error: function(xhr, status, error) {
      console.error(xhr.responseText); // Log error message
      alert('SOMTHING NOT OK. PLEASE CONTACT DEVELOPER.'); // Show error message
    }
  });
}



    // Call the function to fetch allergies when the page is ready
    $(document).ready(function() {
      fetchAllergies();

    });
   
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for each select element
    $('.js-example-basic-multiple').select2();
    $('.js-example-medical-history').select2();

    // Adding event listeners for selection boxes to update input in real-time
    $('.js-example-basic-multiple, .js-example-medical-history').on('change', function() {
        updateInput();
    });

    // Adding event listener to update output when any input changes
   /* const inputs = document.getElementById('dateInput');
    inputs.forEach(input => {
        input.addEventListener('input', updateOutput);
    });*/
});

// Function to update input fields with real-time values
function updateInput() {
    const allergiesSelect = document.getElementById('allergies');
    const allergies = getSelectedOptions(allergiesSelect);

    const medicalHistorySelect = document.getElementById('medicalHistory');
    const medicalHistory = getSelectedOptions(medicalHistorySelect);

    document.getElementById('hideAllergies').value = allergies.join(', ');
    document.getElementById('hidePastMediHis').value = medicalHistory.join(', ');
}

function getSelectedOptions(selectElement) {
    const selectedOptions = [];
    for (let i = 0; i < selectElement.options.length; i++) {
        if (selectElement.options[i].selected) {
            selectedOptions.push(selectElement.options[i].value);
        }
    }
    return selectedOptions;
}

 function calculateAge(dob) {
    const birthDate = new Date(dob);
    const currentDate = new Date();

    let years = currentDate.getFullYear() - birthDate.getFullYear();
    let months = currentDate.getMonth() - birthDate.getMonth();

    if (months < 0 || (months === 0 && currentDate.getDate() < birthDate.getDate())) {
        years--;
        months += 12;
    }

    return { years, months };
}

function fetchPatients() {
    fetch('./attributes/fetchPatientDeta.php')
        .then(response => response.json())
        .then(data => {
            // Process the fetched data and populate the table
            populateSearchableTable(data);
        })
        .catch(error => console.error('Error fetching data:', error));
}

fetchPatients();

function populateSearchableTable(data) {
    // Create a Map to track the latest entry for each unique combination of name, dob, and sex
    const latestMap = new Map();

    data.forEach(patient => {
        // Create a unique key based on name, dob, and sex
        const key = `${patient.name}|${patient.dob}|${patient.sex}`;
        
        // Check if the key is already in the map
        if (latestMap.has(key)) {
            // Compare created_at to keep the latest entry
            const existingPatient = latestMap.get(key);
            if (new Date(patient.created_at) > new Date(existingPatient.created_at)) {
                latestMap.set(key, patient);
            }
        } else {
            latestMap.set(key, patient);
        }
    });

    // Convert Map values to an array
    const uniqueData = Array.from(latestMap.values());

    // Sort the uniqueData array in descending order based on the serial field
    uniqueData.sort((a, b) => {
        // Convert serial to numbers for comparison
        return (b.serial || 0) - (a.serial || 0);
    });

    // Get the table body element
    const tableBody = document.getElementById('pastPatient');

    // Clear any existing rows
    tableBody.innerHTML = '';

    // Add new rows
    uniqueData.forEach(patient => {
        const row = document.createElement('tr');

        // Create cells for each field
        const dobCell = document.createElement('td');
        dobCell.textContent = patient.dob;
        dobCell.className = 'dob-hidden-column'; // Add class to hide the column
        row.appendChild(dobCell);

        const serialCell = document.createElement('td');
        serialCell.textContent = patient.serial;
        //serialCell.className = 'hidden-column'; // Add class to hide the column
        row.appendChild(serialCell);

        const nameCell = document.createElement('td');
        nameCell.textContent = patient.name;
        nameCell.className = 'name'; // Add class to hide the column
        row.appendChild(nameCell);


        const lvCell = document.createElement('td');
        lvCell.textContent =formatDate(patient.created_at) || 'N/A'; // Display lv if it exists
        row.appendChild(lvCell);

        const doctorCell = document.createElement('td');
        doctorCell.textContent = patient.doctor || 'N/A'; // Handle possible missing value
        row.appendChild(doctorCell);

        const remainCell = document.createElement('td');
        remainCell.textContent = patient.remain !== null ? patient.remain : 'N/A'; // Handle possible missing value
        row.appendChild(remainCell);

        const sexCell = document.createElement('td');
        sexCell.textContent = patient.sex === '0' ? 'Male' : 'Female'; // Assuming '0' is Male and '1' is Female
        sexCell.className = 'sex'; // Add class to hide the column
        row.appendChild(sexCell);

        // Add click event listener to the row
        row.addEventListener('click', () => {
            // Find the serial cell within the clicked row
            const name = row.querySelector('.name').textContent;
            const bod = row.querySelector('.dob-hidden-column').textContent;
            const sex = row.querySelector('.sex').textContent === 'Male' ? '0' : '1';
            // /console.log('Clicked Serial:', serial);

            populateInputFields(data, name, bod, sex);
        });

        // Append the row to the table body
        tableBody.appendChild(row);
    });
}

function populateInputFields(data, name, dob, sex) {
   // console.log('Selected Criteria:', { name, dob, sex });

    // Find all patients that match the given name, dob, and sex
    const matchingPatients = data.filter(patient => 
        patient.name === name && 
        patient.dob === dob &&
        patient.sex === sex
    );

    // Sort patients by created_at in descending order
    matchingPatients.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    // Limit to the latest 4 rows
    const latestPatients = matchingPatients.slice(0, 4);

    // Find the latest visit (first entry in the sorted list)
    const latestVisit = matchingPatients[0];

    // Check if any patients are found
    if (latestPatients.length > 0) {
        //console.log('Latest Visits (up to 4):', latestPatients);
        populateHiddenTable(latestPatients);
    } else {
        console.log('No patients found with the specified criteria:', { name, dob, sex });
    }

    // Check if there is at least one matching patient to determine the latest visit
    if (latestVisit) {
        // Calculate age
        const { years, months } = calculateAge(latestVisit.dob);
        const currentTime = new Date();
        const formattedDate = `${currentTime.getFullYear()}-${currentTime.getMonth() + 1}-${currentTime.getDate()}`;
        const rt = `${currentTime.getHours()}:${currentTime.getMinutes()}`;



        // Update fields with the latest visit data
        document.getElementById('oppointment').value = latestVisit.oppointment || '';
        selectMediHis(latestVisit.medicalHistory);
        selectAllergie(latestVisit.allergies);
        document.getElementById('tel').value = latestVisit.tel || '';
        document.getElementById('name').value = latestVisit.name || '';
        document.getElementById('dateInput').value = latestVisit.dob || '';
        document.getElementById('age').value = `${years} Y ${months} M`; // Set the age field

        const state = latestVisit.status;

        document.getElementById('special').checked = state === '0';
        document.getElementById('n-special').checked = state === '1';
        document.getElementById('male').checked = latestVisit.sex === '0';
        document.getElementById('female').checked = latestVisit.sex === '1';

        //<-----Populate hidden fields start-------->

        document.getElementById('hideName').value = latestVisit.name || '';
        document.getElementById('tel').value = latestVisit.tel;
        document.getElementById('hideAllergies').value = latestVisit.allergies;
        document.getElementById('hidePastMediHis').value = latestVisit.medicalHistory;
        document.getElementById('hideBday').value = `${latestVisit.dob}   ( ${latestVisit.sex === '1' ? 'F' : 'M'} )  ${formattedDate} ${rt}`;
        document.getElementById('hideAge').value = `${years} Y ${months} M      ${document.getElementById('doctor').value}`;
        document.getElementById('hideTel').value = latestVisit.tel;


        //<-----------Populate hidden fields end-------------->


    } else {
        console.log('No visit found for the specified criteria:', { name, dob, sex });
    }
}

function populateHiddenTable(latestPatients) {
    const filteredPatients = latestPatients.map(patient => ({
        serial: patient.serial,
        created_at: formatDate(patient.created_at),
        doctor: patient.doctor,
        medicalProblem: patient.medicalProblem,
        cashNurse: patient.cashNurse,
        pharmacyNurse: patient.pharmacyNurse,
        nextVisitDate: patient.nextVisitDate,
        jmc: patient.jmc,
        jd: patient.jd,
        remain: patient.remain
    }));

    const tableBody = document.querySelector('#hideTable tbody');
    tableBody.innerHTML = ''; // Clear existing table rows

    filteredPatients.forEach(patient => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${patient.serial}</td>
            <td>${patient.created_at}</td>
            <td>${patient.doctor}</td>
            <td>${patient.medicalProblem}</td>
            <td>${patient.cashNurse}</td>
            <td>${patient.pharmacyNurse}</td>
            <td>${patient.nextVisitDate}</td>
            <td>${patient.jmc}</td>
            <td>${patient.jd}</td>
            <td>${patient.remain}</td>
        `;
        tableBody.appendChild(row);
    });

    console.log('Table populated with filtered data');
}


var dateInput = document.getElementById('dateInput');
var namesInput = document.getElementById('name');

  function refreshDateInput() {
    // Clear the input field
    dateInput.value = ''; 
  }

  function clearFields() {
    location.reload();
}

function logout() {
        // Perform AJAX request to logout.php
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "./attributes/logout.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Redirect to index.php after successful logout
                window.location.href = "./index.php";
            }
        };
        xhr.send();
    }
    $(document).ready(function() {
  $('#dropdownMenuButton').click(function() {
    $(this).parent().toggleClass('show');
  });
});


// Variable to store the fetched data
var data;
// Fetch data from the PHP script
fetch('./attributes/fetchLastTen.php')
    .then(response => response.json())
    .then(initialData => {
        // Log the data to the console
        //console.log("data", initialData);

        // Store the data in the variable
        data = initialData;

        // Extract the last 10 DOB
        var last10DOB = data.slice(0, 11).map(item => item.dob);

        // Get the dropdown menu element
        var dropdownMenu = document.getElementById('dropdownMenuButton');

        // Populate the dropdown menu with the last 10 DOB
        last10DOB.forEach(dob => {
            var option = document.createElement('option');
            option.text = dob;
            dropdownMenu.add(option);
        });

        // Add event listener to the dropdown menu
        dropdownMenu.addEventListener('change', function () {
            // Get the selected DOB
            var selectedDOB = dropdownMenu.value;

            // Call a function to print data based on the selected DOB
            document.getElementById('dateInput').value = selectedDOB;
           // printDataByDOB(selectedDOB);
           handleInputChange(selectedDOB);
        });
    })
    .catch(error => console.error('Error:', error));

// Function to print data based on selected DOB


function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Add 1 to month since it's zero-based
    const day = date.getDate().toString().padStart(2, '0');

    return `${year}/${month}/${day}`;
    console.log(year, month, day);

}

    // Function to fetch data from the PHP file using AJAX
    function fetchDoctors() {
        // Make an AJAX request to the PHP file
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "./attributes/fetchDoctors.php", true);
        xhr.onreadystatechange = function () {
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

    // Call the fetchData function
    fetchDoctors();

    // Function to populate select options
    function populateSelectOptions(data) {
    var selectElement = document.getElementById("doctor");
    var docNameInput = document.getElementById("docName");

    //console.log('test data',data)

    // Retrieve the selected index from localStorage
    var savedIndex = localStorage.getItem("selectedDoctorIndex");

    // Clear existing options and set a default option
    selectElement.innerHTML = '<option value="" selected>Select Doctor</option>';

    // Loop through the data and add options to the select element
    for (var i = 0; i < data.length; i++) {

        console.log('data',data);
        var option = document.createElement("option");
        option.value = data[i].userCode; // You can modify this as needed
        option.text = data[i].userCode;
        selectElement.add(option);
    }

    // Set the selected index based on localStorage or default to 0
    selectElement.selectedIndex = savedIndex ? parseInt(savedIndex, 10) : 0;

    // Update the input field with the selected doctor's full name
    updateDocNameInput();

    // Add an event listener for the 'change' event on the select element
    selectElement.addEventListener("change", function () {
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
        docNameInput.value =  selectedDoctor;

        

       // console.log(selectedDoctor )
        fetchPatientCount(selectedDoctor);
    } else {
        // Clear the input field if no doctor is selected
        docNameInput.value = "";
    }
  }
  function fetchPatientCount(doctorName) {
    // Fetch patient count from the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                //console.log('Patient response:', response);
                //console.log('Doc Name:', doctorName);

                if (response.success) {
                   // console.log('Patient Count:', response.patientCount);
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
}}


//<-----------------Send Data To Data Base Start------------------------->


document.addEventListener('DOMContentLoaded', function() {
    function gatherFormData() {

        const currentTime = new Date();
        const dayOfMonth = currentTime.getDate(); // Get the day of the month (1–31)
        const year = currentTime.getFullYear();
        const month = currentTime.getMonth() + 1; // Add 1 to month since it's zero-based
        const hours = currentTime.getHours();
        const minutes = currentTime.getMinutes();
        const seconds = currentTime.getSeconds();
        const rt = hours + ':' + minutes;
        

        // Assuming you want to display the day, month, and year
        const formattedDate = `${year}-${month}-${dayOfMonth}`;

        var docName = document.getElementById('doctor').value;
        var oppointment = document.getElementById('oppointment').value;

        var age = document.getElementById('age').value;
        document.getElementById('hideAge').value = age.trim() +'                  '+ docName;

        var name = document.getElementById('name').value;
        document.getElementById('hideName').value = name;

        var tel = document.getElementById('tel').value;
        document.getElementById('hideTel').value= tel;

        var nurse = document.getElementById('nurseCode').value;

        var sex = document.querySelector('input[name="sex"]:checked').value;
       // document.getElementById('hideSex').value = sex;
       if (sex == 0){
        sex = 'M'
       }
       else if (sex== 1){
        sex= 'F'
       }
       else{
        sex='!!'
       }

       var dateInput = document.getElementById('dateInput').value;
        document.getElementById('hideBday').value = dateInput + '   ( ' + sex + '  )  ' +formattedDate +'  '+ rt;

        
        var allergiesSelect = document.getElementById('allergies');
        var allergiesValue = document.getElementById('allergies').value;
        var allergies = [];
        for (var i = 0; i < allergiesSelect.options.length; i++) {
            if (allergiesSelect.options[i].selected) {
                allergies.push(allergiesSelect.options[i].value);
            }
        }
        
        var medicalHistorySelect = document.getElementById('medicalHistory');
        var medicalHistory = [];
        for (var j = 0; j < medicalHistorySelect.options.length; j++) {
            if (medicalHistorySelect.options[j].selected) {
                medicalHistory.push(medicalHistorySelect.options[j].value);
            }
        }
        
       var status = document.querySelector('input[name="status"]:checked').value;
        //console.log(status);
        
        if (status == 1){
            //console.log('Irregular');
           document.getElementById('star').textContent = ' ';

        }
        else if (status == 0){
           // console.log('Regular');
           document.getElementById('star').textContent = 'R';
        }

        return {
            docName: docName,
            oppointment: oppointment,
            dateInput: dateInput,
            age: age,
            name: name,
            tel: tel,
            sex: sex,
            nurse: nurse,
            allergies: allergies,
            medicalHistory: medicalHistory,
            status: status
        };
    }

    function sendData(data, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './attributes/sendPatientData.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                alert("Patient Saved successfully");
                location.reload();
            } else {
                console.error(xhr.statusText);
                alert("SOMETHING WRONG. PLEASE CONTACT DEVELOPER");
            }
            if (callback) callback();
        };
        
        xhr.send(
            'docName=' + data.docName + 
            '&oppointment=' + data.oppointment + 
            '&dateInput=' + data.dateInput + 
            '&age=' + data.age + 
            '&name=' + data.name + 
            '&tel=' + data.tel + 
            '&sex=' + data.sex + 
            '&nurse=' + data.nurse + 
            '&allergies=' + data.allergies + 
            '&medicalHistory=' + data.medicalHistory + 
            '&status=' + data.status
        );
    }

    function handleSubmitOrPrint(event, isPrint) {
        var formData = gatherFormData();

        if (!formData.age) {
            alert("PLEASE ENTER BIRTH DAY  BEFORE SAVE THE DATA");
            return;
        }
        if (formData.docName == 'SELECT' || !formData.docName) {
            alert("PLEASE SELECT DOCTOR BEFORE SAVE THE DATA");
            return;
        }
        if (formData.allergiesValue == '') {
            alert("THE ALLERGIES NOT TO BE EMPTY");
            return;
        }

        window.print();
        sendData(formData, function() {
            if (isPrint) {
                setTimeout(function() {
                }, 1000); // Delay to ensure the alert is displayed before printing
            }
        });
    }

    document.getElementById('submit').addEventListener('click', function(event) {
        handleSubmitOrPrint(event, false);
    });
    document.getElementById('print').addEventListener('click', function(event) {
        handleSubmitOrPrint(event, true);
    });
});


//<-------------------------End data send toi data base------------------------------------->


</script>




</body>

</html>
