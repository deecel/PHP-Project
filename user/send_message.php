<?php
session_start();
include("connection.php");

// Establish database connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the message data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the sender ID (current user's ID)
    $senderId = $_SESSION['id'];
    // Get the receiver ID from the POST data
    $receiverId = $_POST['receiver_id']; // This line might be causing the error
    // Get the message from the POST data
    $message = $_POST['message_content']; // This line might be causing the error

    // Insert the message into the database
    // (You need to implement the insertMessage function here)
    // For now, let's assume it's implemented correctly
    // insertMessage($connection, $senderId, $receiverId, $message);

    // For testing purposes, let's just echo the received data
    echo "Sender ID: $senderId, Receiver ID: $receiverId, Message: $message";

    // Terminate script execution after handling the message
    exit();
}
?>
