<?php

session_start();

include './connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $username = filter_var($_POST["uName"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    $selectedOption =filter_var ($_POST['flexRadioDefault'],FILTER_SANITIZE_STRING);

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT id, userName, level FROM system_user WHERE userName = ? AND password = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any row is returned
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["userName"];
        

        // Regenerate the session ID for security
        session_regenerate_id(true);
        $level = $user["level"];
        $user = $user["userName"];
        $task = 'Login';
        $other = $user . ' Logged Success';
        
        // Generate a secure timestamp
        include './home.php';
        switch ($selectedOption) {
            case 'register':
                $redirectPage = './home.php';
                break;
            case 'pharmacy':
                $redirectPage = './pharmacy.php';
                break;
            case 'payments':
                $redirectPage = './payment.php';
                break;
            case 'admin':
                $redirectPage = ($level == 'admin' || $level == 'doctor') ? 'dashboard/dashboard.php' : './home.php';
                break;
            default:
                // Default redirect to home.php or any other default page
                $redirectPage = 'home.php';
                break;
        }
        
        // Prepare the query with placeholders for security
        $query = "INSERT INTO log (task, other) VALUES (?, ?)";
        
        // Create a prepared statement
        $stmt = $conn->prepare($query);
        
        // Bind the values to the placeholders
        $stmt->bind_param("ss", $task, $other);
  
        $result = $stmt->execute();
        
        if ($result) {
            echo "Data inserted successfully";
            echo "<script>window.location.href = '$redirectPage';</script>";
            exit();
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    } else {
        // Invalid username or password, display a generic error message
        echo "<script>alert('User Name Or Password Incorrect')</script>";
    }

   
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./attributes/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url("./src/img/loginBack.png");
            background-size:cover ;
            background-position: center;
            background-repeat: no-repeat;
        }

        h3 {
            font-family: 'Courier New', Courier, monospace;
            color: purple;
            font-weight: bold;
        }
        input{
            background: #F8F8FF ;
        }
        .icon{
            width: 50px;
            height: auto;
            
           
        }

        /* Add any additional styles for your form elements if needed */
    </style>
    <title>Jeewaka Medical Centre</title>
</head>
<body class="container-fluid " >
    <div class="row">
        <div style="color: white;" class="col-6 "> <font face = "Comic sans MS" size =" 4">Jeewaka Medical Center</font></div>
     
    </div>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div style="background-color: #00002030; " class="border-0 border-radius-2xl px-4 py-1">
                        <div class="row mb-0 px-4 text-center ">
                            <div class="col-2"></div>
                            <div class="col-7 ">
                            <h2 style=" color: white ; font-family: 'Courier New', Courier, monospace ; font-weight: bolder; text-decoration-color: white; " >Login Here</h2>
                            </div>
                            <div class="col-2"></div>
                        </div>
                        <div class="row">
                        <div class="col-3"></div>
                            <div class="col-6 ">
                                <img style="width: 250px; height: auto; " src="./src/img/loginHuman.png" alt="" srcset="">
                            </div>
                            <div class="col-2"></div>
                        </div>
                    <form method="POST">
                        <div class="row px-3">
                            <label class="mb-1"><h6 class="mb-0 text-sm"><b>User Name</b></h6></label>
                            <input class="mb-4 " type="text" name="uName" id="uName" placeholder="Enter a valid user name">
                        </div>
                        <div class="row px-3">
                            <label class="mb-1"><h6 class="mb-0 text-sm"><b>Password</b></h6></label>
                            <input type="password" name="password" id="password" placeholder="Enter password">
                        </div>
                        <div class="row px-3 mt-4">
                            <label class="mb-1"><h6 class="mb-0 text-sm"><b>Which Page Will You Visit?</b></h6></label>
                        </div>
                        <div class="row text-white text-bold ">
                        <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input "type="radio" name="flexRadioDefault" id="register" value="register" checked>
                                    <label class="form-check-label" for="register">
                                       <img class="icon" src="./src/img/reg.png" alt="Reg">
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="pos" value="pharmacy" >
                                    <label class="form-check-label" for="pos">
                                    <img class="icon" src="./src/img/pharmacy.png" alt="Reg">
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class=" form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="payments" value="payments" >
                                    <label class="form-check-label " for="payments">
                                    <img class="icon" src="./src/img/cashier.png" alt="Cash">

                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class=" form-check">
                                    <input class="form-check-input"  type="radio" name="flexRadioDefault" id="admin" value="admin" >
                                    <label class="form-check-label " for="admin">
                                    <img class="icon" src="./src/img/admin.png" alt="Admin">

                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row mt-3 mb-3 px-3">
                            <div class="col-2"></div>
                            <div class="col-8"><button  type="submit" class="btn btn-dark text-center w-100 " ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
</svg> Login</button></div> 
                            <div class="col-2"></div>  
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        
    </div>
</div>

</body>
</html>