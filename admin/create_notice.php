<?php
include '../includes/db.php';
include '../includes/header.php'; 
include '../includes/auth.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $admin_id = 1;  
 
    $file_path = "";
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $target_dir = "../uploads/";
        $file_name = basename($_FILES['file']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $file_path = $target_file;
        }
    }

    $sql = "INSERT INTO notices (Title, Description, FilePath, Category, Tags, CreatedAt, AdminId)
            VALUES ('$title', '$description', '$file_path', '$category', '$tags', NOW(), $admin_id)";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../public/index.php");  
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Notice</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    color: #333;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
textarea,
select,
input[type="file"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    resize: none;
}

button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #333;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #555;
}

select {
    height: 40px;
}

input[type="file"] {
    padding: 5px;
    font-size: 14px;
}

    </style>
    
</head>
<body>
    <div class="container">
        <h2>Create New Notice</h2>
        <form method="POST" action="create_notice.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" placeholder="Enter notice title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="5" placeholder="Enter notice description" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" required>
                    <option value="">Select a category</option>
                    <option value="General">General</option>
                    <option value="Event">Event</option>
                    <option value="Academic">Academic</option>
                    <option value="Sports">Sports</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" name="tags" id="tags" placeholder="Enter tags (comma-separated)">
            </div>
            <div class="form-group">
                <label for="file">File</label>
                <input type="file" name="file" id="file">
            </div>
            <button type="submit">Create Notice</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
