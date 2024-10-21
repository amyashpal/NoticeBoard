<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';
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

        // Validate and move the uploaded file
        if (move_uploaded_file($_FILES['notice_file']['tmp_name'], $uploaded_file)) {
            $file_path = $uploaded_file; // Update file path if upload is successful
        } else {
            $error = "Error uploading the file.";
        }
    }

    // Update notice
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Notice</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Notice</h1>
        </div>

        <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($notice['Title']); ?>" required>
            
            <label for="description">Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($notice['Description']); ?></textarea>
            
            <label for="tag_ids">Select Tags:</label>
            <select name="tag_ids[]" id="tag_ids" multiple>
                <?php while ($tag = $tags_result->fetch_assoc()): ?>
                    <option value="<?php echo $tag['TagId']; ?>" <?php echo in_array($tag['TagId'], $current_tags) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tag['Name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="notice_file">Change File (optional):</label>
            <input type="file" name="notice_file" id="notice_file">

            <?php if ($notice['FilePath']): ?>
                <p>Current File: <a href="<?php echo htmlspecialchars($notice['FilePath']); ?>" target="_blank">View File</a></p>
            <?php endif; ?>

            <button type="submit">Update Notice</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
