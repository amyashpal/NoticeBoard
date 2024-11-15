<?php
include '../includes/db.php'; 

// Assuming you have a user table and a logged-in user
// This example assumes the user ID is stored in a session
session_start();
$userId = $_SESSION['user_id']; // Assuming you have a session variable for user ID

$sql = "SELECT username FROM users WHERE userid = '$userId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['username']; // Output user name
} else {
    echo "No user found";
}

$conn->close();
?>
