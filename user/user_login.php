<?php
session_start();  // Start the session

// Include the database connection
include '../includes/db.php';  // Adjust the path based on your project structure
include '../includes/header.php';  // Adjust the path based on your project structure

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to find the user by username
    $sql = "SELECT * FROM users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, now verify the password
        $user = $result->fetch_assoc();

        // Verify the password (assuming it's hashed in the database)
        if (password_verify($password, $user['Password'])) {
            // Login successful, store user ID in session
            $_SESSION['user_id'] = $user['UserId'];

            // Insert the login event
            $user_id = $_SESSION['user_id'];
            $log_login_sql = "INSERT INTO userlog (user_id, login_time) VALUES (?, CURRENT_TIMESTAMP)";
            $stmt = $conn->prepare($log_login_sql);
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                // Get the LogId of the inserted log entry and store it in the session
                $_SESSION['LogId'] = $conn->insert_id;  // Store LogId in session
                echo "Login event logged. Log ID: " . $_SESSION['LogId'] . "<br>";
            } else {
                echo "Error logging login event: " . $conn->error . "<br>";
            }

            // Redirect to the user dashboard
            header('Location:../public/index.php');
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
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
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
