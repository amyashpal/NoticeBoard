<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice List</title>
    
    <link rel="stylesheet" href="../styles/notice.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            // Fetch user name
            $('#fetchName').click(function(){
                $.get('fetch_user.php', function(response){
                    $('#userInfo').html('User Name: ' + response);
                });
            });

            // Fetch user role
            $('#fetchMail').click(function(){
                $.get('fetch_mail.php', function(response){
                    $('#userInfo').html('User Mail: ' + response);
                });
            });
        });
    </script>
</head>
<body>
<?php if (isset($_SESSION['user_id'])): ?>
    <div class="nclass" >
   
                 <!-- Buttons for fetching user name and role -->
        <button id="fetchName" class="nb">Fetch User Name</button>
        <button id="fetchMail" class="nb">Fetch User Mail</button>
        
           
            <!-- Div to display fetched user information -->
        <div id="userInfo"></div>
    </div>
    <?php endif; ?>
    <div class="cc">
        
        <h2>Notices</h2>
        <ul class="notice-list">
            <?php
            include '../includes/db.php'; 
            $noticeSql = "SELECT * FROM notices ORDER BY CreatedAt DESC";
            $noticeResult = $conn->query($noticeSql);
            while ($row = $noticeResult->fetch_assoc()) {
                echo "<li>";
                echo "<div class='notice-details'>";
                echo "<h2>Title:{$row['Title']}</h2>";
                echo "<h3>{$row['Description']}</h3>";
                echo "<p>Category: {$row['Category']}</p>";
                echo "<p>Tags: {$row['Tags']}</p>";
                echo "<p>Created At: {$row['CreatedAt']}</p>";
                echo "</div>";
                echo "<div class='actions'>";
                echo "<a href='{$row['FilePath']}' class='notice-file-link' download>Download File</a>";
                echo "</div>";
                echo "</li>";
            }
            $conn->close();
            ?>
        </ul>
        
       
        
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
