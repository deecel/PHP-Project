
// if (isset($_GET["ID"] )  ) {
//     $ID = $_GET["ID"];

//     $servername = "localhost";
//     $username = "root";
//     $password = "";
//     $database = "trimexdbb";
    
//     // Create connection
//     $connection = new mysqli($servername, $username, $password, $database); 

//     $sql = "DELETE FROM user_data WHERE ID = $ID";
//     $connection->query($sql);
// }

// header("Location: dashboard.php");

// exit;
<?php 
if (isset($_GET["ID"])) {
    $ID = $_GET["ID"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trimexdbb";
    
    // Create connection
    $connection = new mysqli($servername, $username, $password, $database); 

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Begin transaction
    $connection->begin_transaction();

    try {
        // Delete from child table (messages table) where sender_id
        $sql = "DELETE FROM messages WHERE sender_id = $ID";
        $connection->query($sql);

        // Delete from child table (messages table) where receiver_id
        $sql = "DELETE FROM messages WHERE receiver_id = $ID";
        $connection->query($sql);

        // Delete from parent table (user_data table)
        $sql = "DELETE FROM user_data WHERE ID = $ID";
        $connection->query($sql);

        // Commit transaction
        $connection->commit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $connection->rollback();
        echo "Error deleting record: " . $e->getMessage();
        exit;
    }

    // Close connection
    $connection->close();
}

header("Location: dashboard.php");
exit;

?>
