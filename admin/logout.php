<?php
session_start();  


include '../includes/db.php'; 


if (isset($_SESSION['admin_id']) && isset($_SESSION['log_id'])) {
    $log_id = $_SESSION['log_id'];

    
    $log_logout_sql = "UPDATE log SET logout_time = CURRENT_TIMESTAMP WHERE logid = $log_id";
    if ($conn->query($log_logout_sql) === TRUE) {
        echo "Logout event logged.<br>";
    } else {
        echo "Error logging logout event:<br>";
    }
}

session_destroy();
header('Location: login.php');
exit();
?>
