<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session only if it hasn't been started
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect x='10' y='10' width='80' height='80' fill='%234a90e2' rx='10' ry='10' /><rect x='20' y='20' width='60' height='10' fill='%23ffffff' /><rect x='20' y='40' width='60' height='5' fill='%23ffffff' /><rect x='20' y='50' width='60' height='5' fill='%23ffffff' /><rect x='20' y='60' width='60' height='5' fill='%23ffffff' /><rect x='20' y='70' width='40' height='5' fill='%23ffffff' /></svg>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Notice Board</title>
    <style>
        h1 a {
    color: inherit; /* Inherit color from the parent element (h1) */
    text-decoration: none; /* Remove underline */
}

h1 a:hover {
    color: inherit; /* Ensure color stays the same on hover */
    text-decoration: none; /* Ensure no underline on hover */
}


    </style>
</head>
<body>
<header>
    <div class="header-container">
        <h1><a href="../public/index.php" >Notice Board</a></h1>
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
