<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$notice_id = $_GET['id'];

// Fetch the notice details
$stmt = $conn->prepare("SELECT * FROM notices WHERE NoticeId = ?");
$stmt->bind_param("i", $notice_id);
$stmt->execute();
$notice = $stmt->get_result()->fetch_assoc();

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

    // Update notice
    $stmt = $conn->prepare("UPDATE notices SET Title = ?, Description = ? WHERE NoticeId = ?");
    $stmt->bind_param("ssi", $title, $description, $notice_id);
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
<html>
<head>
    <title>Edit Notice</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Notice</h1>
        </div>

        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
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
            
            <button type="submit">Update Notice</button>
        </form>

        <div class="footer">
            <p>&copy; 2024 Notice Board</p>
        </div>
    </div>
</body>
</html>
