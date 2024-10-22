<?php
session_start();  // Start the session

include '../includes/db.php';  // Adjust the path based on your project structure

// Check if the user is logged in and has a log record
if (isset($_SESSION['user_id']) && isset($_SESSION['LogId'])) {
    $user_id = $_SESSION['user_id'];
    $log_id = $_SESSION['LogId'];  // Corrected to use the session variable 'LogId'

    // Print session details for debugging
    // echo "User ID: $user_id <br>";
    // echo "Log ID: $log_id <br>";

    // Update the logout time for the current session's log entry
    $log_logout_sql = "UPDATE userlog SET logout_time = CURRENT_TIMESTAMP WHERE LogId = ?";
    $stmt = $conn->prepare($log_logout_sql);
    $stmt->bind_param("i", $log_id);

    if ($stmt->execute()) {
        echo "Logout event logged successfully.<br>";
    } else {
        echo "Error logging logout event: " . $conn->error . "<br>";
    }
} else {
    echo "No active session found or log record missing.<br>";
}

// Destroy the session and redirect to the login page
session_destroy();
// echo "Session destroyed.<br>";
// echo "<a href='user_login.php'>Go to Login Page</a>";
// Redirect to the user dashboard
header('Location:../public/index.php');

exit();
?>
