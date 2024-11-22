<?php
session_start();
include '../includes/db.php';

// Initialize message variables
$success = '';
$error = '';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Check if a notice ID is provided in the URL
if (isset($_GET['id'])) {
    $notice_id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM notices WHERE NoticeId = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $notice_id);
        if ($stmt->execute()) {
            // Set success message and redirect to dashboard
            $_SESSION['message'] = "Notice deleted successfully!";
            header('Location: dashboard.php');
            exit();
        } else {
            // Set error message
            $error = "Error deleting notice: " . htmlspecialchars($stmt->error);
        }
        $stmt->close(); // Close the prepared statement
    } else {
        $error = "Error preparing statement: " . htmlspecialchars($conn->error);
    }
} else {
    $error = "No notice ID provided.";
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Notice</title>
    <style>
        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
