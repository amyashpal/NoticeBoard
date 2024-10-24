<?php
session_start(); 

include '../includes/db.php';  
if (isset($_SESSION['user_id']) && isset($_SESSION['LogId'])) {
    $user_id = $_SESSION['user_id'];
    $log_id = $_SESSION['LogId'];  

    $log_logout_sql = "UPDATE userlog SET logout_time = CURRENT_TIMESTAMP WHERE LogId = $log_id";
    mysqli_query($conn,$log_logout_sql);
  
} else {
    echo "No active session found or log record missing.<br>";
}

session_destroy();

header('Location:user_login.php');

exit();
?>
