<?php
session_start();
include '../includes/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Check if a notice ID is provided
if (isset($_GET['id'])) {  // Change 'notice_id' to 'id'
    $notice_id = $_GET['id'];

    // Prepare statement to delete notice
    $stmt = $conn->prepare("DELETE FROM notices WHERE NoticeId = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $notice_id);
        if ($stmt->execute()) {
            // Redirect to the dashboard after successful deletion
            header('Location: dashboard.php');
            exit;
        } else {
            echo "Error deleting notice: " . htmlspecialchars($stmt->error);
        }
        $stmt->close(); // Close the statement
    } else {
        echo "Error preparing statement: " . htmlspecialchars($conn->error);
    }
} else {
    echo "No notice ID provided.";
}

$conn->close(); // Close the database connection
?>
