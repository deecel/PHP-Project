<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id']; // Retrieve the user's ID from the session

// Directory where the uploaded files are stored
$upload_directory = "uploads/$user_id/";

// Check if the directory exists
if (!file_exists($upload_directory)) {
    die("No files uploaded yet.");
}

// Get a list of all PDF files in the directory
$files = scandir($upload_directory);
$pdf_files = array();
foreach ($files as $file) {
    if ($file != '.' && $file != '..' && pathinfo($file, PATHINFO_EXTENSION) == 'pdf') {
        $pdf_files[] = $file;
    }
}

// Display the selected PDF file
if (!empty($_POST['pdf_file'])) {
    $selected_pdf = $_POST['pdf_file'];
    $pdf_url = 'view.php?filename=' . urlencode($selected_pdf) . '&user_id=' . urlencode($user_id);
} else {
    // Default to the first PDF file if none is selected
    $selected_pdf = '';
    if (!empty($pdf_files)) {
        $selected_pdf = $pdf_files[0];
    }
    $pdf_url = 'view.php?filename=' . urlencode($selected_pdf) . '&user_id=' . urlencode($user_id);
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Trimex Colleges - OJT MONITORING </title>
    <!-- Custom CSS -->
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <title>PDF Viewer</title>
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
                        <a href="index.php" class="logo">
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
                            <img src="../assets/images/ojtmonitoring.png" class="light-logo" alt="homepage" />
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
                                    <a class="dropdown-item" href="index.php">
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
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php" aria-expanded="false">
                            <i class="mdi mdi-cube-send"></i>
                                <span class="hide-menu">Student Info</span>   
                            </a>

                        
                            <li class="sidebar-item" id="uploadLink">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false">
                                <i class="mdi mdi-cube-send"></i>
                                <span class="hide-menu" id="upload">Upload</span>

                            </a>
                        </li>
                        <li class="sidebar-item" id="uploadLink">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="file.php"  aria-expanded="false">
                                <i class="mdi mdi-cube-send"></i>
                                <span class="hide-menu" id="upload">View</span>

                            </a>
                        </li>
                        <li class="sidebar-item" id="uploadLink">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="chat.php"  aria-expanded="false">
                                <i class="mdi mdi-cube-send"></i>
                                <span class="hide-menu" id="upload">Chat</span>

                            </a>
                        </li>
                        </nav>
                        </div>
                        </aside>
                      
                        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-4 align-self-center">
                        <h4 class="page-title"></h4>
                    </div>
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

            
            <table style="width: 100%; height: 100%;">
    <tr>
        <td style="vertical-align: middle; text-align: center; height: 100%;">
            <div class="center-container">
            <h3>Choose a file:</h3>
                <form action="" method="post">
                    <select name="pdf_file" onchange="this.form.submit()">
                        <?php
                        foreach ($pdf_files as $pdf_file) {
                            echo "<option value='$pdf_file' " . ($pdf_file == $selected_pdf ? 'selected' : '') . ">$pdf_file</option>";
                        }
                        ?>
                    </select>
                </form>
                <iframe src="<?php echo $pdf_url; ?>" style="width: 90%; height: 100vh; border: 1px solid;"></iframe>
                
            </div>
        </td>
    </tr>
</table>

 <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file1">Select File:</label>
                        <input type="file" class="form-control-file" id="file1" name="file1" required accept=".pdf">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
     <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file1">Select File:</label>
                        <input type="file" class="form-control-file" id="file1" name="file1" required accept=".pdf">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        
        $("#uploadLink").on("click", function() {
            $("#uploadModal").modal("show");
        });
        
        
        $("#uploadModal .close").on("click", function() {
            $("#uploadModal").modal("hide");
        });

        $("#uploadForm").on("submit", function(event) {
            event.preventDefault(); 
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    alert(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        
        $("#uploadLink").on("click", function() {
            $("#uploadModal").modal("show");
        });
        
        
        $("#uploadModal .close").on("click", function() {
            $("#uploadModal").modal("hide");
        });

        $("#uploadForm").on("submit", function(event) {
            event.preventDefault(); 
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'upload_handler.php',
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    alert(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
</script>


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
