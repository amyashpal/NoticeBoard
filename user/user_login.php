<?php
session_start();  
include '../includes/db.php';  
include '../includes/header.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserId'];
            $user_id = $_SESSION['user_id'];

            $log_login_sql = "INSERT INTO userlog VALUES ('',$user_id, CURRENT_TIMESTAMP,'')";
            mysqli_query($conn, $log_login_sql);
                $_SESSION['LogId'] = mysqli_insert_id($conn);
             
            header('Location: ../public/index.php');
            exit();
        } else
        {
            echo '<script>alert("Wrong Username or Password")</script>';
        }
        
    }else
    {
        echo '<script>alert("Wrong Username or Password")</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        
        .container {
            max-width: 500px;
            height:350px;
    margin: 50px auto 0; /* Adds 50px margin from the top */
    padding: 15px;
}

        
    
        .row {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
     
        .col-md-4 {
            width: 100%;
            max-width: 400px;
        }

       
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

       
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }


        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        
        
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
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
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>

