<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Notice Board</title>
</head>
<body>
<header>
    <div class="header-container">
        <h1>Notice Board</h1>
        <nav>
            <a href="../public/index.php" class="nav-button">Home</a>
            <?php if (isset($_SESSION['admin_id'])): ?>
                <a href="../admin/dashboard.php" class="nav-button">Dashboard</a>
                <a href="../admin/create_notice.php" class="nav-button">Create Notice</a>
                <a href="../admin/admin_register.php" class="nav-button">Add Admin</a>
                <a href="../admin/logout.php" class="nav-button">Logout</a>
            <?php elseif (isset($_SESSION['user_id'])): ?>
                <a href="../user/user_dashboard.php" class="nav-button">User Dashboard</a>
                <a href="../user/user_logout.php" class="nav-button">Logout</a>
            <?php else: ?>
                <a href="../user/user_login.php" class="nav-button">User Login</a>
                <a href="../admin/login.php" class="nav-button">Admin Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
