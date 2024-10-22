<?php
session_start();  // Start the session

// Include the database connection
include '../includes/db.php';  // Adjust the path based on your project structure

// Check if admin_id and log_id are set in the session
if (isset($_SESSION['admin_id']) && isset($_SESSION['log_id'])) {
    $log_id = $_SESSION['log_id'];

    // Update the logout time for the current session's log entry
    $log_logout_sql = "UPDATE log SET logout_time = CURRENT_TIMESTAMP WHERE logid = $log_id";
    if ($conn->query($log_logout_sql) === TRUE) {
        echo "Logout event logged.<br>";
    } else {
        echo "Error logging logout event: " . $conn->error . "<br>";
    }
}

// Destroy the session and redirect to the login page
session_destroy();
header('Location: login.php');
exit();
?>
