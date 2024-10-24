<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notice Board</title>
    
    <!-- Internal CSS for .c1 -->
    <style>
        /* Styling for the header section */
        .c1 {
            background-color: black;
            /* padding-TOP: 500px; */
            text-align: center;
            margin-top:100px;
            border:1px solid black;
            height:700px;
            width:1000px;
           margin-left:auto;
           margin-RIGHT:auto;
           margin-top:70px;
           margin-bottom:auto;
           BORDER-radius:50px;
        }
        
        h2 {
            font-size: 2.5em;
            margin: 0;
            color:white;
            padding-top:30vh;
        }
    </style>
</head>

<body>
    <div class="c1">
        <h2>Welcome To Noticeboard</h1>
    </div>

    <!-- Body content can go here -->

</body>
</html>

<?php include '../includes/footer.php'; ?>
