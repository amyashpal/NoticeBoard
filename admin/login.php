<?php
session_start();
include '../includes/db.php';  
include '../includes/header.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['Password'])) {
            $_SESSION['admin_id'] = $admin['AdminId'];

            $admin_id = $_SESSION['admin_id'];
            $log_login_sql = "INSERT INTO log VALUES ('',$admin_id, CURRENT_TIMESTAMP,'')";
         
            mysqli_query($conn, $log_login_sql);
        
            $_SESSION['log_id'] = mysqli_insert_id($conn);
            header('Location: index.php');
            exit();
        } 
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <button type="submit">Login</button>
     
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
