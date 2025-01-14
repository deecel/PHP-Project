<?php
include("connection.php");

// Retrieve user's ID from session
session_start();
$sender_id = $_SESSION['admin_logged_in'];

// Get users with messaging history
$history_sql = "SELECT DISTINCT u.ID, u.NAME 
                FROM (SELECT ID, NAME FROM admin UNION SELECT ID, NAME FROM user_data) u
                JOIN messages m ON (u.ID = m.sender_id OR u.ID = m.receiver_id)
                WHERE (m.sender_id = $sender_id OR m.receiver_id = $sender_id)
                AND u.ID != $sender_id";
$history_result = $connection->query($history_sql);

$users = [];
while ($row = $history_result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);

$connection->close();
?>

