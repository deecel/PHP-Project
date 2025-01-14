<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Trimex Colleges - OJT MONITORING</title>
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../assets/images/big/img13.jpg) no-repeat center center; background-size: cover;">
            <div class="auth-box on-sidebar">
                <div>
                    <div class="logo">
                    <span class="db"><img src="../assets/images/logo-icon.png" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Trimex Colleges - OJT MONITORING</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <?php
                                include("connection.php");

                                $errors = array();
                                $message = '';

                                function registerUser($ID, $PASSWORD, $NAME, $STUDENT_ADDRESS, $STUDENT_EMAIL, $HOURS, $COMPANY, $COMPANY_ADDRESS, $EMAIL, $COMPANY_CONTACTS, $STUDENT_CONTACT,) {
                                    global $errors, $message, $connection;

                                  // Check if ID is empty
                                  if (empty($ID)) {
                                    $errors[] = "ID is required";
                                }

                                // Check if Ojt Hours is empty
                                if (empty($HOURS)) {
                                    $errors[] = "Ojt Hours is required";
                                }

                                // Check if PASSWORD is empty
                                if (empty($PASSWORD)) {
                                    $errors[] = "Password is required";
                                }

                                // Check if NAME is empty
                                if (empty($NAME)) {
                                    $errors[] = "Name is required";
                                }

                                // Check if STUDENT ADDRESS is empty
                                if (empty($STUDENT_ADDRESS)) {
                                    $errors[] = "Address is required";
                                }

                                // Check if COMPANY is empty
                                if (empty($COMPANY)) {
                                    $errors[] = "Company is required";
                                }

                                // Check if COMPANY ADDRESS is empty
                                if (empty($COMPANY_ADDRESS)) {
                                    $errors[] = "Company is required";
                                }

                                // Check if COMPANY_CONTACTS is empty
                                if (empty($COMPANY_CONTACTS)) {
                                    $errors[] = "Company Contact is required";
                                }

                                // Check if STUDENT_CONTACT is empty
                                if (empty($STUDENT_CONTACT)) {
                                    $errors[] = "Student contact is required";
                                }

                                // Check if EMAIL is empty and valid
                                if (empty($EMAIL) || !filter_var($EMAIL, FILTER_VALIDATE_EMAIL)) {
                                    $errors[] = "Valid EMAIL is required";
                                }

                                // Check if EMAIL is empty and valid
                                if (empty($STUDENT_EMAIL) || !filter_var($STUDENT_EMAIL, FILTER_VALIDATE_EMAIL)) {
                                    $errors[] = "Valid EMAIL is required";
                                }


                                    // If there are no errors, check if the ID already exists
                                    if (empty($errors)) {
                                        // Check if the ID already exists
                                        $check_query = "SELECT * FROM user_data WHERE ID='$ID'";
                                        $result = mysqli_query($connection, $check_query);
                                        if (mysqli_num_rows($result) > 0) {
                                            $errors[] = "ID already exists";
                                        }
                                    }

                                    // If there are still no errors, insert data into the database
                                    if (empty($errors)) {
                                        // Insert the new user into the database with 'pending' status
                                        $query = "INSERT INTO user_data (ID, PASSWORD, NAME, STUDENT_ADDRESS, STUDENT_EMAIL, HOURS, COMPANY, COMPANY_ADDRESS, EMAIL, COMPANY_CONTACTS, STUDENT_CONTACT, status) VALUES ('$ID', '$PASSWORD', '$NAME', '$STUDENT_ADDRESS', '$STUDENT_EMAIL', '$HOURS', '$COMPANY', '$COMPANY_ADDRESS', '$EMAIL', '$COMPANY_CONTACTS', '$STUDENT_CONTACT', 'pending')";
                                        if (mysqli_query($connection, $query)) {
                                            $message = "Registration successful. Please wait for admin approval.";
                                        } else {
                                            $errors[] = "Error inserting data: " . mysqli_error($connection);
                                        }
                                    }
                                }

                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $ID = $_POST['ID'];
                                    $PASSWORD = $_POST['PASSWORD'];
                                    $NAME = $_POST['NAME'];
                                    $STUDENT_ADDRESS = $_POST['STUDENT_ADDRESS'];
                                    $STUDENT_EMAIL = $_POST['STUDENT_EMAIL'];
                                    $HOURS = $_POST['HOURS'];
                                    $COMPANY = $_POST['COMPANY'];
                                    $COMPANY_ADDRESS = $_POST['COMPANY_ADDRESS'];
                                    $EMAIL = $_POST['EMAIL'];
                                    $COMPANY_CONTACTS = $_POST['COMPANY_CONTACTS'];
                                    $STUDENT_CONTACT = $_POST['STUDENT_CONTACT'];

                                    registerUser($ID, $PASSWORD, $NAME, $STUDENT_ADDRESS, $STUDENT_EMAIL, $HOURS, $COMPANY, $COMPANY_ADDRESS, $EMAIL, $COMPANY_CONTACTS, $STUDENT_CONTACT);
                                }
                                ?>
                                <?php
                                // Display errors if any
                                if (!empty($errors)) {
                                    echo "<div class='error-message'>";
                                    echo "<ul>";
                                    foreach ($errors as $error) {
                                        echo "<li>$error</li>";
                                    }
                                    echo "</ul>";
                                    echo "</div>";
                                }
                                ?>
                                <?php if (!empty($message)): ?>
                                    <p style="color: green;"><?php echo $message; ?></p>
                                <?php endif; ?>
                                <div class="form-group row ">
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" type="text" name="ID" required=" " placeholder="Student ID">
                                    </div>

                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" type="password" name="PASSWORD" required=" " placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" type="text" name="NAME" required=" " placeholder="Full Name">
                                    </div>
                            
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" type="text" name="STUDENT_ADDRESS" required=" " placeholder="Student Address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" type="text" name="STUDENT_EMAIL" required=" " placeholder="Student Email">
                                    </div>
                                
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" type="text" name="HOURS" required=" " placeholder="OJT Hours">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" type="text" name="COMPANY" required=" " placeholder="Company Name">
                                    </div>
                                
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" style="font-size: 14px;"type="text" name="COMPANY_ADDRESS" required=" " placeholder="Company Address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" type="text" name="EMAIL" required=" " placeholder="Company Email">
                                    </div>
                                
                                    <div class="col-6 ">
                                        <input class="form-control form-control-lg" style="font-size: 14px;" type="text" name="COMPANY_CONTACTS" required=" " placeholder="Company Contacts">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control form-control-lg text-center" type="text" name="STUDENT_CONTACT" required=" " placeholder="Student Contact">
                                    </div>
                                </div>
                                <div class="form-group text-center ">
                                    <div class="col-xs-12 p-b-20 ">
                                        <button class="btn btn-block btn-lg btn-info " type="submit ">SIGN UP</button>
                                    </div>
                                </div>
                                <div class="form-group m-b-0 m-t-10 ">
                                    <div class="col-sm-12 text-center ">
                                        Already have an account? <a href="../index.php " class="text-info m-l-5 "><b>Sign In</b></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js "></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
    $('[data-toggle="tooltip "]').tooltip();
    $(".preloader ").fadeOut();
    
    </script>
</body>

</html>
