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
    <style>/* Reset default styling */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Header Styles */
header {
    background-color: #333;
    color: white;
    padding: 15px 20px;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
footer {
    background-color: #333;
    color: white;
    padding: 15px 20px;
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 1000;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

header h1 {
    font-size: 24px;
    margin: 0;
}

header nav {
    display: flex;
    gap: 15px;
}

header nav a {
    text-decoration: none;
    color: white;
    padding: 8px 15px;
    background-color: #444;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}


/* Basic Container Styling */
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 15px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
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
