<?php
// Start the session
session_start();

// Unset only user session variables
unset($_SESSION['user_logged_in']);

// Optionally destroy the session if no other session variables are set
if (empty($_SESSION)) {
    session_destroy();
}

// Redirect to the login page (or any other page)
header("Location: ../index.php");
exit;
?>
