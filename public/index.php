<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Fetch all tags for filtering
$query_tags = "SELECT * FROM tags";
$tags_result = $conn->query($query_tags);

// Check if a tag is selected for filtering
$selected_tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';

// Fetch notices with associated tags
$query_notices = "SELECT n.*, GROUP_CONCAT(t.Name SEPARATOR ', ') AS tags 
                  FROM notices n
                  LEFT JOIN notice_tags nt ON n.NoticeId = nt.NoticeId
                  LEFT JOIN tags t ON nt.TagId = t.TagId";

// Add filtering condition if a tag is selected
if ($selected_tag_id) {
    $query_notices .= " WHERE nt.TagId = ?";
}

$query_notices .= " GROUP BY n.NoticeId ORDER BY n.CreatedAt DESC";

$stmt = $conn->prepare($query_notices);

// Bind parameter if filtering
if ($selected_tag_id) {
    $stmt->bind_param("i", $selected_tag_id);
}

$stmt->execute();
$notices = $stmt->get_result();
?>

<div class="container">
    <h2>Notices</h2>
    <form method="GET" action="index.php">
        <label for="tag_id">Filter by Tag:</label>
        <select name="tag_id" id="tag_id" onchange="this.form.submit()">
            <option value="">All Notices</option>
            <?php while ($tag = $tags_result->fetch_assoc()): ?>
                <option value="<?php echo $tag['TagId']; ?>" <?php echo ($selected_tag_id == $tag['TagId']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($tag['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <div class="notices">
        <?php while ($notice = $notices->fetch_assoc()): ?>
            <div class="notice">
                <h3 class="h11"><?php echo htmlspecialchars($notice['Title']); ?></h3>
                <p><?php echo htmlspecialchars($notice['Description']); ?></p>
                <p><strong>Tags:</strong> <?php echo htmlspecialchars($notice['tags']); ?></p>
                
                <?php if ($notice['FilePath']): ?>
                    <?php if (pathinfo($notice['FilePath'], PATHINFO_EXTENSION) == 'pdf'): ?>
                        <a href="../uploads/<?php echo $notice['FilePath']; ?>" target="_blank">View PDF</a>
                    <?php else: ?>
                        <img src="../uploads/<?php echo $notice['FilePath']; ?>" alt="Notice Image" class="notice-image" style="max-width: 100%; height: auto;">
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
