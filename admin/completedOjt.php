<?php
session_start();
// Include the connection file
include 'connection.php';
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
                                <!-- dark Logo text -->
                                <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
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
                                    <i class="mdi mdi-magnify font-20 mr-1"></i>
                                    <div class="ml-1 d-none d-sm-block">
                                        <span>Search</span>
                                    </div>
                                </div>
                            </a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter">
                                <a class="srh-btn">
                                    <i class="ti-close"></i>
                                </a>
                            </form>
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
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Registered Accounts</h4>
                    </div>
                    <div class="col-7 align-self-center">
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
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

            <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                            </div>
                            <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-light">
                                    <thead>
                                        <tr>
                                        <th scope="col">Student ID</th>
                                                <th scope="col">Student Name</th>
                                                <th scope="col">Student Address</th>
                                                <th scope="col">Student Email</th>
                                                <th scope="col">OJT Hours</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Company Address</th>
                                                <th scope="col">Company Email</th>
                                                <th scope="col">Company Contact.</th>
                                                <th scope="col">Student Contact</th>
                                                <th scope="col">OJT</th>
                                                <th scope='col'>MOA, ENDORSEMENT, AND WAIVER</th>
                                                
                                                <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
function updateStatus($ID, $status) {
    global $connection;
    $sql_update = "UPDATE user_data SET STATUS='$status' WHERE ID='$ID'";
    if (mysqli_query($connection, $sql_update)) {
        echo "";
    } else {
        echo "Error updating status for user in user_data: " . mysqli_error($connection) . "<br>";
    }
}

// Function to lock or unlock a user in the user_data table
function toggleLock($ID, $lock) {
    global $connection;
    $lockValue = $lock ? 1 : 0; // Convert boolean $lock to 0 or 1
    $sql_update = "UPDATE user_data SET locked='$lockValue' WHERE ID='$ID'";
    if (mysqli_query($connection, $sql_update)) {
        $action = $lock ? "locked" : "unlocked";
        echo "";
    } else {
        echo "Error toggling lock for user in user_data: " . mysqli_error($connection) . "<br>";
    }
}

// Function to change OJT status from 'Ongoing' to 'Done'
function completeOJT($ID) {
    global $connection;
    $sql_update = "UPDATE user_data SET OJT='Ongoing' WHERE ID='$ID'";
    if (mysqli_query($connection, $sql_update)) {
        echo "";
    } else {
        echo "Error updating OJT status for user in user_data: " . mysqli_error($connection) . "<br>";
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID'])) {
    $ID = $_GET['ID'];
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'approve':
                updateStatus($ID, 'approve');
                break;
            case 'reject':
                updateStatus($ID, 'reject');
                break;
            case 'lock':
                toggleLock($ID, false);
                break;
            case 'unlock':
                toggleLock($ID, true);
                break;
            case 'completeOJT':
                completeOJT($ID);
                break;
            default:
                echo "Invalid action.";
        }
    }
}
// Fetch approved user registrations with ongoing OJT status
$sql_approved = "SELECT *, IFNULL(locked, 0) AS locked FROM user_data WHERE STATUS = 'approve' AND OJT = 'Ongoing'";
$result_approved = $connection->query($sql_approved);

if (!$result_approved) {
    die("Invalid query: " . $connection->error);
} 

// Read data of each row for approved registrations with ongoing OJT
while($row = $result_approved->fetch_assoc()){
    $lockIcon = $row['locked'] ? "<i class='fas fa-lock'></i>" : "<i class='fas fa-unlock'></i>";
    $lockAction = $row['locked'] ? "lock" : "unlock"; // Determine the action based on lock status
    echo "
    <tr>
        <td>{$row['ID']}</td>
        <td>{$row['NAME']}</td>
        <td>{$row['STUDENT_ADDRESS']}</td>
        <td>{$row['STUDENT_EMAIL']}</td>
        <td>{$row['HOURS']}</td>
        <td>{$row['COMPANY']}</td>
        <td>{$row['COMPANY_ADDRESS']}</td>
        <td>{$row['EMAIL']}</td>
        <td>{$row['COMPANY_CONTACTS']}</td>
        <td>{$row['STUDENT_CONTACT']}</td>
        <td>{$row['OJT']}</td>
        <td>
            <a href='allfiles.php?id={$row['ID']}'>VIEW FILES</a>
        </td>
        <td>
            <a href='edit.php?ID={$row['ID']}'><i class='fas fa-edit'></i></a>
            <a href='delete.php?ID={$row["ID"]}&action=delete'><i class='fas fa-trash-alt'></i></a>
            <a href='dashboard.php?ID={$row["ID"]}&action={$lockAction}'><i class='fas fa-{$lockAction}'></i></a> <!-- Dynamic action based on lock status -->
            <a href='completedOjt.php.php?ID={$row["ID"]}&action=completeOJT'><i class='fas fa-check'></i></a> <!-- Icon to mark OJT as Done -->
        </td>
    </tr>
    ";
}
?>



                                    </tbody>
                                </table>
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