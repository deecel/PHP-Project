<?php 
if (isset($_GET["ID"] )  ) {
    $ID = $_GET["ID"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trimexdbb";
    
    // Create connection
    $connection = new mysqli($servername, $username, $password, $database); 

    $sql = "DELETE FROM user_data WHERE ID = $ID";
    $connection->query($sql);
}

header("Location: index.php");

exit;

?>