<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id']; // Retrieve the user's ID from the session

// Function to generate a download link for a file
function generateDownloadLink($filename, $user_id) {
    return "download.php?filename=" . urlencode($filename) . "&user_id=" . urlencode($user_id);
}

// Directory where the uploaded files are stored
$upload_directory = "uploads/$user_id/";

// Check if the directory exists
if (!file_exists($upload_directory)) {
    die("No files uploaded yet.");
}

// Get a list of all files in the directory
$files = scandir($upload_directory);

// Display each file with download link
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "<a href='" . generateDownloadLink($file, $user_id) . "'>$file</a><br>";
    }
}
?>

<!-- download.php -->
<?php
if (isset($_GET['filename']) && isset($_GET['user_id'])) {
    $filename = $_GET['filename'];
    $user_id = $_GET['user_id'];
    $file_path = "uploads/$user_id/$filename";

    // Check if the file exists
    if (file_exists($file_path)) {
        // Send headers to force download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($file_path);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>
