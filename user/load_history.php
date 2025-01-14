<?php
session_start();
include("connection.php");

$sender_id = $_SESSION['id'];

// Fetch all users from admin and user_data tables, and the latest message timestamp
$history_sql = "SELECT u.ID, u.NAME, MAX(m.timestamp) AS last_message_time 
                FROM (
                    SELECT ID, NAME FROM admin 
                    UNION 
                    SELECT ID, NAME FROM user_data
                ) u
                LEFT JOIN messages m ON (u.ID = m.sender_id AND m.receiver_id = ?) 
                                     OR (u.ID = m.receiver_id AND m.sender_id = ?)
                GROUP BY u.ID, u.NAME
                ORDER BY last_message_time DESC";
$stmt = $connection->prepare($history_sql);
$stmt->bind_param("ii", $sender_id, $sender_id);
$stmt->execute();
$result = $stmt->get_result();

$contacts = [];
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

header('Content-Type: application/json');
echo json_encode($contacts);
?>
