<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session only if it hasn't been started
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
                <a href="../admin/logout.php" class="nav-button">Logout</a>
            <?php else: ?>
                <a href="../admin/login.php" class="nav-button">Admin Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
