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
            header('Location:../public/index.php');
            exit();
        } 
        else
        {
            echo '<script>alert("Wrong Username or Password")</script>';
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
            margin-top: 50px;
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
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>

