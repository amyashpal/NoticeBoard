    <?php
    session_start(); 
    include '../includes/header.php'; 


    include '../includes/db.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $email= $_POST['email'];

    
        if ($password !== $confirm_password) {
                echo '<script>alert("Wrong Username or Password")</script>';
        } else {
         
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

       
            $sql = "INSERT INTO admins (Username, Password,Email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $hashed_password,$email);

            if ($stmt->execute()) {
               
                header('Location: login.php');
                exit();
            } else {
                echo '<script>alert("Something went Wrong")</script>';
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Registration</title>
        <link rel="stylesheet" href="../styles.css">
    </head>
    <body>
        <div class="container">
            <h2>Admin Registration</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="text" name="email" id="email" placeholder="Enter your Email" required>
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
            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </div>
        <?php include '../includes/footer.php'; ?>

    </body>
    </html>
