<?php
include '../includes/db.php';
include '../includes/header.php'; 
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
    <link rel="stylesheet" href="../styles.css">
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
