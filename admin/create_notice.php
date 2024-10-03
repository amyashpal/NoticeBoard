<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch all tags for dropdown
$query_tags = "SELECT TagId, Name FROM tags";
$tags_result = $conn->query($query_tags);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file_path = '';
    $tag_ids = isset($_POST['tag_ids']) ? $_POST['tag_ids'] : [];

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Define upload directory
        $upload_dir = '../uploads/';
        $file_path = uniqid() . '.' . $file_ext;
        move_uploaded_file($file_tmp, $upload_dir . $file_path);
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO notices (Title, Description, FilePath, AdminId) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $description, $file_path, $_SESSION['admin_id']);
    
    if ($stmt->execute()) {
        $notice_id = $stmt->insert_id; // Get the inserted notice ID

        // Insert into notice_tags
        foreach ($tag_ids as $tag_id) {
            $stmt_tag = $conn->prepare("INSERT INTO notice_tags (NoticeId, TagId) VALUES (?, ?)");
            $stmt_tag->bind_param("ii", $notice_id, $tag_id);
            $stmt_tag->execute();
            $stmt_tag->close();
        }
        
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<div class="container">
    <h2>Create Notice</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>
        
        <label for="description">Description</label>
        <textarea name="description" id="description" required></textarea>
        
        <label for="tag_ids">Select Tags:</label>
        <select name="tag_ids[]" id="tag_ids" multiple>
            <?php while ($tag = $tags_result->fetch_assoc()): ?>
                <option value="<?php echo $tag['TagId']; ?>">
                    <?php echo htmlspecialchars($tag['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label for="file">Upload File (Image/PDF)</label>
        <input type="file" name="file" id="file" accept=".pdf,.jpg,.jpeg,.png">
        
        <button type="submit">Create Notice</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
