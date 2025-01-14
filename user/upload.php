<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    die("Error: User not logged in.");
}

$user_id = $_SESSION['id']; // Retrieve the user's ID from the session

// Specify the directory to upload the file (using user ID as part of the directory name)
$upload_directory = "uploads/$user_id/";

// Create the directory if it doesn't exist
if (!file_exists($upload_directory)) {
    if (!mkdir($upload_directory, 0777, true)) {
        die("Error: Failed to create upload directory.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each uploaded file
    foreach ($_FILES as $file) {
        $filename = $file['name'];
        $tmp_name = $file['tmp_name'];

        // Check if the file is a valid PDF
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            die("Error: Only PDF files are allowed.");
        }

        if (!move_uploaded_file($tmp_name, $upload_directory . $filename)) {
            echo "Error uploading file: $filename";
        } else {
            echo "Uploaded Successfully!";
        }
    }
}
?>
