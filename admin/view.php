<?php
if (isset($_GET['filename']) && isset($_GET['user_id'])) {
    $filename = $_GET['filename'];
    $user_id = $_GET['user_id'];
    $file_path = "../user/uploads/$user_id/$filename";

    // Check if the file exists
    if (file_exists($file_path)) {
        // Send headers to display PDF in browser
        header('Content-Type: application/pdf');
        readfile($file_path);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>
