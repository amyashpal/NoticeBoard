<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Get the notice ID from the URL
$notice_id = $_GET['id'] ?? null;

// Validate the notice ID
if (!$notice_id) {
    echo "Invalid Notice ID.";
    exit();
}

// Fetch the notice details
$stmt = $conn->prepare("SELECT * FROM notices WHERE NoticeId = ?");
$stmt->bind_param("i", $notice_id);
$stmt->execute();
$notice = $stmt->get_result()->fetch_assoc();

// Check if notice exists
if (!$notice) {
    echo "Notice not found.";
    exit();
}

// Fetch all tags for the dropdown
$query_tags = "SELECT TagId, Name FROM tags";
$tags_result = $conn->query($query_tags);

// Fetch current tags for the notice
$current_tags = [];
$stmt = $conn->prepare("SELECT TagId FROM notice_tags WHERE NoticeId = ?");
$stmt->bind_param("i", $notice_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $current_tags[] = $row['TagId'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tag_ids = $_POST['tag_ids'] ?? []; // Use tag_ids array

    // Handle file upload
    $file_path = $notice['FilePath']; // Keep existing file path if no new file is uploaded
    if (isset($_FILES['notice_file']) && $_FILES['notice_file']['error'] == 0) {
        $upload_dir = '../uploads/';
        $uploaded_file = $upload_dir . basename($_FILES['notice_file']['name']);
        
        // Validate file type (example for PDF and DOCX)
       
    }

    // Update notice
    if (!isset($error)) {
        $stmt = $conn->prepare("UPDATE notices SET Title = ?, Description = ?, FilePath = ? WHERE NoticeId = ?");
        $stmt->bind_param("sssi", $title, $description, $file_path, $notice_id);
        if ($stmt->execute()) {
            // Update tags
            $stmt = $conn->prepare("DELETE FROM notice_tags WHERE NoticeId = ?");
            $stmt->bind_param("i", $notice_id);
            $stmt->execute();

            foreach ($tag_ids as $tag_id) {
                $stmt = $conn->prepare("INSERT INTO notice_tags (NoticeId, TagId) VALUES (?, ?)");
                $stmt->bind_param("ii", $notice_id, $tag_id);
                $stmt->execute();
            }

            $success = "Notice updated successfully!";
        } else {
            $error = "Error updating notice.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Notice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
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
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 150px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

     
        .success {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        .file-info {
            margin-top: 10px;
        }

        select {
            height: 45px;
        }

        input[type="file"] {
            padding: 6px;
            font-size: 14px;
        }

        .notice-link {
            color: #007BFF;
            text-decoration: none;
        }

        .notice-link:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Notice</h2>

        <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($notice['Title']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" required><?php echo htmlspecialchars($notice['Description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="tag_ids">Select Tags:</label>
                <select name="tag_ids[]" id="tag_ids" multiple>
                    <?php while ($tag = $tags_result->fetch_assoc()): ?>
                        <option value="<?php echo $tag['TagId']; ?>" <?php echo in_array($tag['TagId'], $current_tags) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($tag['Name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="notice_file">Change File (optional):</label>
                <input type="file" name="notice_file" id="notice_file">
            </div>

            <?php if ($notice['FilePath']): ?>
                <div class="file-info">
                    <p>Current File: <a href="<?php echo htmlspecialchars($notice['FilePath']); ?>" target="_blank" class="notice-link">View File</a></p>
                </div>
            <?php endif; ?>

            <button type="submit">Update Notice</button>
        </form>
    </div>

</body>
</html>
