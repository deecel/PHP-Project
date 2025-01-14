<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

// Retrieve user ID
$sender_id = $_SESSION['id'];

// Pagination logic
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of users per page
$offset = ($page - 1) * $limit;

// Get total number of users with messaging history
$total_users_sql = "SELECT COUNT(DISTINCT u.ID) AS total_users 
                    FROM (
                        SELECT ID, NAME FROM admin 
                        UNION 
                        SELECT ID, NAME FROM user_data
                    ) u
                    JOIN messages m ON (u.ID = m.sender_id OR u.ID = m.receiver_id)
                    WHERE (m.sender_id = ? OR m.receiver_id = ?)
                    AND u.ID != ?";
$stmt = $connection->prepare($total_users_sql);
$stmt->bind_param("iii", $sender_id, $sender_id, $sender_id);
$stmt->execute();
$total_users_result = $stmt->get_result();
$total_users = $total_users_result->fetch_assoc()['total_users'];
$total_pages = ceil($total_users / $limit);

// Handle new message submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Check if sender_id exists in admin or user_data table
    $check_sender_sql = "SELECT ID FROM admin WHERE ID = $sender_id UNION SELECT ID FROM user_data WHERE ID = $sender_id";
    $check_sender_result = $connection->query($check_sender_sql);
    
    // Check if receiver_id exists in admin or user_data table
    $check_receiver_sql = "SELECT ID FROM admin WHERE ID = $receiver_id UNION SELECT ID FROM user_data WHERE ID = $receiver_id";
    $check_receiver_result = $connection->query($check_receiver_sql);
    
    if ($check_sender_result->num_rows == 1 && $check_receiver_result->num_rows == 1) {
        $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
        $connection->query($sql);
        
        // Redirect back to the same conversation
        header("Location: ?receiver_id=$receiver_id");
        exit();
    } else {
        // Invalid sender_id or receiver_id
        echo "Invalid sender or receiver.";
        exit();
    }
}

// Get users with messaging history with pagination
$history_sql = "SELECT DISTINCT u.ID, u.NAME 
                FROM (
                    SELECT ID, NAME FROM admin 
                    UNION 
                    SELECT ID, NAME FROM user_data
                ) u
                JOIN messages m ON (u.ID = m.sender_id OR u.ID = m.receiver_id)
                WHERE (m.sender_id = ? OR m.receiver_id = ?)
                AND u.ID != ?
                LIMIT ? OFFSET ?";
$stmt = $connection->prepare($history_sql);
$stmt->bind_param("iiiii", $sender_id, $sender_id, $sender_id, $limit, $offset);
$stmt->execute();
$history_result = $stmt->get_result();

// Retrieve messages and receiver's name if users are selected
$conversation = [];
$receiver_name = '';
$selected_receiver_id = null;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['receiver_id'])) {
    $selected_receiver_id = $_GET['receiver_id'];
    
    // Fetch receiver's name
    $receiver_sql = "SELECT NAME FROM (SELECT ID, NAME FROM admin UNION SELECT ID, NAME FROM user_data) as u WHERE ID = $selected_receiver_id";
    $receiver_result = $connection->query($receiver_sql);
    if ($receiver_result->num_rows > 0) {
        $receiver_row = $receiver_result->fetch_assoc();
        $receiver_name = $receiver_row['NAME'];
    }

    $message_sql = "SELECT m.message, m.timestamp, u1.NAME AS sender, u2.NAME AS receiver, m.sender_id
                    FROM messages m
                    JOIN (SELECT ID, NAME FROM admin UNION SELECT ID, NAME FROM user_data) u1 ON m.sender_id = u1.ID
                    JOIN (SELECT ID, NAME FROM admin UNION SELECT ID, NAME FROM user_data) u2 ON m.receiver_id = u2.ID
                    WHERE (m.sender_id = $sender_id AND m.receiver_id = $selected_receiver_id)
                       OR (m.sender_id = $selected_receiver_id AND m.receiver_id = $sender_id)
                    ORDER BY m.timestamp DESC";
    $conversation = $connection->query($message_sql);
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
    <style>
        body { font-family: Arial, sans-serif; }
        .container { display: flex; }
        .user-list { flex: 1; padding: 10px; }
        .chat-box { flex: 2; padding: 10px; border: 1px solid #ccc; }
        .messages { display: flex; flex-direction: column; }
        .message { margin-bottom: 10px; padding: 10px; border-radius: 5px; max-width: 60%; }
        .message.sender { align-self: flex-end; background-color: #dcf8c6; }
        .message.receiver { align-self: flex-start; background-color: #ffffff; }
        .message span { display: block; }
        .message .sender-name { font-weight: bold; }
        .message .timestamp { font-size: small; color: #999; }
        .form-group { margin-bottom: 10px; }
        textarea { width: 100%; height: 60px; }
        #searchBar { margin-bottom: 10px; }
        .left-part {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 300px; /* Pushes pagination to the bottom */
    margin-bottom: 10px; /* Adds space between pagination and chat section */
}

.pagination a {
    text-decoration: none;
    padding: 5px 8px;
    margin: 0 2px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 14px;
}

.pagination a.active {
    background-color: #007bff;
    color: #fff;
}

.pagination a:hover {
    background-color: #f0f0f0;
}

    </style>
    <script>
        function filterUsers() {
            let input = document.getElementById('searchBar').value.toUpperCase();
            let ul = document.getElementById('userList');
            let li = ul.getElementsByTagName('li');

            if (input.length === 0) {
                // Reload users with conversation history
                fetch('load_history.php')
                    .then(response => response.json())
                    .then(data => {
                        ul.innerHTML = '';
                        data.forEach(user => {
                            let li = document.createElement('li');
                            li.innerHTML = `<a href="?receiver_id=${user.ID}">${user.ID} - ${user.NAME.split(' ')[0]}</a>`;
                            ul.appendChild(li);
                        });
                    });
            } else {
                for (let i = 0; i < li.length; i++) {
                    let a = li[i].getElementsByTagName('a')[0];
                    if (a.innerHTML.toUpperCase().indexOf(input) > -1) {
                        li[i].style.display = '';
                    } else {
                        li[i].style.display = 'none';
                    }
                }

                // Fetch and display users without history if search term is not empty
                if (input.length > 0) {
                    fetch(`search_users.php?query=${input}`)
                        .then(response => response.json())
                        .then(data => {
                            ul.innerHTML = '';
                            data.forEach(user => {
                                let li = document.createElement('li');
                                li.innerHTML = `<a href="?receiver_id=${user.ID}">${user.ID} - ${user.NAME.split(' ')[0]}</a>`;
                                ul.appendChild(li);
                            });
                        });
                }
            }
        }
    </script>
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
            <!-- Left Part  -->
            <!-- ============================================================== -->
            <div class="left-part bg-white fixed-left-part">
                <!-- Mobile toggle button -->
                <a class="ti-menu ti-close btn btn-success show-left-part d-block d-md-none" href="javascript:void(0)"></a>
                <!-- Mobile toggle button -->
                <div class="p-15">
                    <h4>Chat Sidebar</h4>
                </div>
                <div class="scrollable position-relative" style="height:100%;">
                    <div class="p-15">
                        <h5 class="card-title">Search Contact</h5>
                        <form>
                        <input type="text" id="searchBar" onkeyup="filterUsers()" placeholder="Search for users..">
                        </form>
                    </div>
                    <hr>
                    <ul class="mailbox list-style-none">
                         <!-- Display user names fetched from the database (CONTACTS) -->
                         <ul id="userList">
                         <?php while($row = $history_result->fetch_assoc()): ?>
                            <?php $first_name = explode(' ', $row['NAME'])[0]; ?>
                            <li>
    <a href="?receiver_id=<?php echo $row['ID']; ?>">
        <i class="fas fa-user" style="vertical-align:middle;"></i>
        <?php echo htmlspecialchars($row['ID']) . ' - ' . htmlspecialchars($first_name); ?>
    </a>
</li>

            <?php endwhile; ?>
                         </ul>
                       <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <a class="active" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo ($page + 1); ?>">Next &raquo;</a>
            <?php endif; ?>
</div>
                               
                                
                         
                        </li>
                    </ul>
                </div>
            </div>

  

            
            <div class="right-part">
                <div class="p-20">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title">Chat With <?php echo htmlspecialchars($receiver_name); ?></h4>
                            
                            <div class="chat-box scrollable" style="height:calc(100vh - 300px);">
                                <!--chat Row -->
                                 <?php if ($selected_receiver_id): ?>
            <!-- Display Conversation -->
            <div class="messages">
            <?php if ($conversation && $conversation->num_rows > 0): ?>
                    <?php
                    // Fetch all messages into an array and reverse it for display
                    $messages = [];
                    while ($row = $conversation->fetch_assoc()) {
                        $messages[] = $row;
                    }
                    $messages = array_reverse($messages);
                    ?>
                    <?php foreach ($messages as $row): ?>
                        <div class="message <?php echo ($row['sender_id'] == $sender_id) ? 'sender' : 'receiver'; ?>">
                            <span class="sender-name"><?php echo htmlspecialchars($row['sender']); ?>:</span>
                            <span class="text"><?php echo htmlspecialchars($row['message']); ?></span>
                            <span class="timestamp"><?php echo htmlspecialchars($row['timestamp']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No messages found.</p>
                <?php endif; ?>
            </div>
                                <ul class="chat-list">
                                    <!--chat Row -->
                                   
                                </ul>
                            </div>
                        </div>
                        <div class="card-body border-top">
                            <div class="row">
                                <div class="col-9">
                                <form method="post" action="">
                                    <input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>">
                                    <input type="hidden" name="receiver_id" value="<?php echo $selected_receiver_id; ?>">
                                    <div class="input-field m-t-0 m-b-0">
                                    <textarea name="message" placeholder="Type a message" class="form-control border-0" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                <button type="submit">
    <i class="fas fa-paper-plane"></i> Send
</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
          
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

        
          
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
