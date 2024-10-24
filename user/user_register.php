<?php
session_start(); 
include '../includes/header.php';  
include '../includes/db.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match.")</script>';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $checkUserSql = "SELECT * FROM users WHERE Username = '$username' OR Email = '$email'";
        $result = mysqli_query($conn, $checkUserSql);

        if (mysqli_num_rows($result) > 0) {
            echo '<script>alert("A user with this username or email already exists.")</script>';
        } else {
            
            $insertUserSql = "INSERT INTO users (Username, Password, Email) VALUES ('$username', '$hashed_password', '$email')";
            if (mysqli_query($conn, $insertUserSql)) {
                header('Location: user_login.php');
                exit();
            } else {
                echo '<script>alert("Error: Something went wrong.")</script>';
            }
        }
    }
}


mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>  
</body>
</html>
