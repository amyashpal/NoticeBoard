<?php
session_start();  
include '../includes/db.php';  
include '../includes/header.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to get the user by username
    $sql = "SELECT * FROM users WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserId'];
            $user_id = $_SESSION['user_id'];

            $log_login_sql = "INSERT INTO userlog (user_id, login_time) VALUES ($user_id, CURRENT_TIMESTAMP)";
            mysqli_query($conn, $log_login_sql);
                $_SESSION['LogId'] = mysqli_insert_id($conn);
             
            header('Location: ../public/index.php');
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            
            <a href="../user/user_register.php">Register User</a>
            <button type="submit">Login</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
