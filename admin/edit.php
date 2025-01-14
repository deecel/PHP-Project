<?php
include("connection.php");

$ID = "";
$NAME = "";
$STUDENT_ADDRESS = "";
$STUDENT_EMAIL = "";
$HOURS = "";
$COMPANY = "";
$COMPANY_ADDRESS = "";
$EMAIL = "";
$COMPANY_CONTACTS = "";
$STUDENT_CONTACT = "";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET METHOD: SHOW THE DATA OF THE EMPLOYEES

    if (!isset($_GET["ID"])) {
        header("Location: index.php"); 
        exit;
    }

    $ID = $_GET["ID"];

    // READ THE ROW OF THE SELECTED DATABASE
    $sql = "SELECT * FROM user_data WHERE ID=$ID";
    $result =  $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: index.php"); 
        exit;
    }

    $ID = $row["ID"];
    $NAME = $row["NAME"];
    $STUDENT_ADDRESS = $row["STUDENT_ADDRESS"];
    $STUDENT_EMAIL = $row["STUDENT_EMAIL"];
    $HOURS = $row["HOURS"];
    $COMPANY = $row["COMPANY"];
    $COMPANY_ADDRESS = $row["COMPANY_ADDRESS"];
    $EMAIL = $row["EMAIL"];
    $COMPANY_CONTACTS = $row["COMPANY_CONTACTS"];
    $STUDENT_CONTACT = $row["STUDENT_CONTACT"];
    
}
else {
    // POST METHOD: UPDATE THE DATA OF THE EMPLOYEES

    $ID =$_POST["ID"];
    $NAME = $_POST["NAME"];
    $STUDENT_ADDRESS = $_POST["STUDENT_ADDRESS"];
    $STUDENT_EMAIL = $_POST["STUDENT_EMAIL"];
    $HOURS = $_POST["HOURS"];
    $COMPANY = $_POST["COMPANY"];
    $COMPANY_ADDRESS = $_POST["COMPANY_ADDRESS"];
    $EMAIL = $_POST["EMAIL"];
    $COMPANY_CONTACTS = $_POST["COMPANY_CONTACTS"];
    $STUDENT_CONTACT = $_POST["STUDENT_CONTACT"];
    
   

    if (empty($ID) || empty($NAME) || empty($STUDENT_ADDRESS) || empty($STUDENT_EMAIL) || empty($HOURS) || empty($COMPANY) || empty($COMPANY_ADDRESS) || empty($EMAIL) || empty($COMPANY_CONTACTS) || empty($STUDENT_CONTACT)) {
        $errorMessage = "All the fields must be filled";
    } else {
        $sql = "UPDATE user_data SET ID = '$ID', NAME = '$NAME' , STUDENT_ADDRESS = '$STUDENT_ADDRESS' , STUDENT_EMAIL = '$STUDENT_EMAIL', HOURS = '$HOURS', COMPANY = '$COMPANY' , COMPANY_ADDRESS = '$COMPANY_ADDRESS', EMAIL = '$EMAIL' , COMPANY_CONTACTS = '$COMPANY_CONTACTS' , STUDENT_CONTACT = '$STUDENT_CONTACT' WHERE ID = $ID";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        } else {
            $successMessage = "Updated successfully";
            header("Location: dashboard.php"); 
            exit;
        }
    }
}

?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

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
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
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
    
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>


    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <a href="dashboard.php" class="logo">
                            <!-- Logo icon -->
                            <b class="logo-icon">
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                               
                            </span>
                        </a>
                        <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                            <i class="mdi mdi-toggle-switch mdi-toggle-switch-off font-20"></i>
                        </a>
                    </div>

                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <!-- <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item search-box">
                            <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                                <div class="d-flex align-items-center">
                                    
                                    <div class="ml-1 d-none d-sm-block">
                                        <span></span>
                                    </div>
                                </div>
                            </a>
                            
                        </li>
                    </ul>

                    <ul class="navbar-nav float-right">
                


                    <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="m-l-5 font-medium d-none d-sm-inline-block">LOGOUT<i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-secondary"></span>
                                </span>
                                <div class="d-flex no-block align-items-center p-15 bg-secondary text-white m-b-10">
                                   
                                <div class="m-l-10">
                                        <h4 class="m-b-0">ARE YOU SURE?</h4>
                                        <p class=" m-b-0"></p>
                                    </div>
                                </div>
                                <div class="profile-dis scrollable">
                                    <a class="dropdown-item" href="logout.php">
                                        </i> YES</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="dashboard.php">
                                        </i> NO</a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                        </li>
                        </ul>
                </div>
            </nav>
        </header>


        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                       
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-av-timer"></i>
                                <span class="hide-menu">Student Accounts</span>
                               
                            </a>
                            
                            <ul aria-expanded="false" class="collapse  first-level">

                            <li class="sidebar-item">
                                    <a href="dashboard.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Registered Accounts</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="dashboard2.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">For Registrations</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="dashboard3.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> Dissapproved Accounts </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item" id="uploadLink">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="chat.php"  aria-expanded="false">
                                <i class="mdi mdi-cube-send"></i>
                                <span class="hide-menu" id="upload">Chat</span>

                            </a>
                        </li>
                        <li class="sidebar-item" id="uploadLink">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard4.php"  aria-expanded="false">
                                <i class="mdi mdi-cube-send"></i>
                                <span class="hide-menu" id="upload">Completed OJT</span>

                            </a>
                        </li>
                        </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-4 align-self-center">
                        <h4 class="page-title">Student Info</h4>
                    </div>
                    <?php 
                                    if (!empty($errorMessage)){
                                        echo "
                                        <div class='form-row'>
                                        <div class= 'alert alert-warning alert-dismissable fade show' role='alert'>
                                        <strong>$errorMessage</strong>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                                        </div>
                                        </div>
                                        ";
                                    }

                                    if (!empty($successMessage)){
                                        echo "
                                        <div class='form-row'>
                                          <div class= 'alert alert-success alert-dismissable fade show' role='alert'>
                                          <strong>$successMessage</strong>
                                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                                          </div>
                                          </div>
                                          "; 
                                          }

                                    ?>
                    <div class="col-8 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <form method="post" enctype="multipart/form-data">
            <div class="page-breadcrumb">
                        <div class="card">
                            <div class="card-body">
                                <form action="#">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Student ID</label>
                                                    <input type="text" class="form-control" name="ID" value="<?php echo $ID; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control" name="NAME" value="<?php echo $NAME; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Student Address</label>
                                                    <input type="text" class="form-control" name="STUDENT_ADDRESS" value="<?php echo $STUDENT_ADDRESS; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Student Email</label>
                                                    <input type="text" class="form-control" name="STUDENT_EMAIL" value="<?php echo $STUDENT_EMAIL; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Ojt Hours</label>
                                                    <input type="text" class="form-control" name="HOURS" value="<?php echo $HOURS; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Company</label>
                                                    <input type="text" class="form-control" name="COMPANY" value="<?php echo $COMPANY; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Company Address</label>
                                                    <input type="text" class="form-control" name="COMPANY_ADDRESS" value="<?php echo $COMPANY_ADDRESS; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Company Email</label>
                                                    <input type="text" class="form-control" name="EMAIL" value="<?php echo $EMAIL; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Company Contact</label>
                                                    <input type="text" class="form-control" name="COMPANY_CONTACTS" value="<?php echo $COMPANY_CONTACTS; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Student Contact</label>
                                                    <input type="text" class="form-control" name="STUDENT_CONTACT" value="<?php echo $STUDENT_CONTACT; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <div class="form-actions m-t-25">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>




            
<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../dist/js/app.min.js"></script>
    <script src="../dist/js/app.init.js"></script>
    <script src="../dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.js"></script>
</body>

</html>