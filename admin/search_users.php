<?php
include("connection.php");

$query = $_GET['query'];

$user_sql = "SELECT ID, NAME FROM user_data WHERE NAME LIKE '%$query%' OR ID LIKE '%$query%'";
$user_result = $connection->query($user_sql);

$users = [];
while ($row = $user_result->fetch_assoc()) {
    $users[] = $row;
}

$admin_sql = "SELECT ID, NAME FROM admin WHERE NAME LIKE '%$query%' OR ID LIKE '%$query%'";
$admin_result = $connection->query($admin_sql);

$admins = [];
while ($row = $admin_result->fetch_assoc()) {
    $admins[] = $row;
}

$connection->close();

$search_results = array_merge($users, $admins);

echo json_encode($search_results);
?>
