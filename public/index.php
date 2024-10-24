<?php include '../includes/header.php';  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice List</title>
    <style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}



.cc {
    width: 100%;
    width: 150vh;
    margin: 0 auto;
    margin-top:100px;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}


h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}


.notice-list {
    list-style-type: none;
    padding: 0;
}

.notice-list li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notice-list li:last-child {
    border-bottom: none;
}

.notice-list h3 {
    font-size: 18px;
    margin-bottom: 5px;
    color: #333;
}

.notice-list p {
    font-size: 14px;
    color: #666;
}
a{
    text-decoration:none;
    color: black;
    text-decoration: none;
    margin-left: 15px;
    padding: 10px 15px;
    border: 1px solid black;
    border-radius: 5px;
    transition: background-color 0.3s;

}

</style>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
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
