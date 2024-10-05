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
        <?php if ($notices->num_rows > 0): ?> <!-- Check if there are notices -->
            <?php while ($notice = $notices->fetch_assoc()): ?>
                <div class="notice-card" style="position: relative; border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; border-radius: 10px;">
                    <h3 class="h11"><?php echo htmlspecialchars($notice['Title']); ?></h3>
                    <p><?php echo htmlspecialchars($notice['Description']); ?></p>
                    <p><strong>Tags:</strong> <?php echo htmlspecialchars($notice['tags']); ?></p>

                    <?php if ($notice['FilePath']): ?>
                        <!-- Download button in the top-right corner -->
                        <a href="../uploads/<?php echo htmlspecialchars($notice['FilePath']); ?>" download style="position: absolute; top: 10px; right: 10px;">
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5535 16.5061C12.4114 16.6615 12.2106 16.75 12 16.75C11.7894 16.75 11.5886 16.6615 11.4465 16.5061L7.44648 12.1311C7.16698 11.8254 7.18822 11.351 7.49392 11.0715C7.79963 10.792 8.27402 10.8132 8.55352 11.1189L11.25 14.0682V3C11.25 2.58579 11.5858 2.25 12 2.25C12.4142 2.25 12.75 2.58579 12.75 3V14.0682L15.4465 11.1189C15.726 10.8132 16.2004 10.792 16.5061 11.0715C16.8118 11.351 16.833 11.8254 16.5535 12.1311L12.5535 16.5061Z" fill="#1C274C"/>
                                <path d="M3.75 15C3.75 14.5858 3.41422 14.25 3 14.25C2.58579 14.25 2.25 14.5858 2.25 15V15.0549C2.24998 16.4225 2.24996 17.5248 2.36652 18.3918C2.48754 19.2919 2.74643 20.0497 3.34835 20.6516C3.95027 21.2536 4.70814 21.5125 5.60825 21.6335C6.47522 21.75 7.57754 21.75 8.94513 21.75H15.0549C16.4225 21.75 17.5248 21.75 18.3918 21.6335C19.2919 21.5125 20.0497 21.2536 20.6517 20.6516C21.2536 20.0497 21.5125 19.2919 21.6335 18.3918C21.75 17.5248 21.75 16.4225 21.75 15.0549V15C21.75 14.5858 21.4142 14.25 21 14.25C20.5858 14.25 20.25 14.5858 20.25 15C20.25 16.4354 20.2484 17.4365 20.1469 18.1919C20.0482 18.9257 19.8678 19.3142 19.591 19.591C19.3142 19.8678 18.9257 20.0482 18.1919 20.1469C17.4365 20.2484 16.4354 20.25 15 20.25H9C7.56459 20.25 6.56347 20.2484 5.80812 20.1469C5.07435 20.0482 4.68577 19.8678 4.40901 19.591C4.13225 19.3142 3.9518 18.9257 3.85315 18.1919C3.75159 17.4365 3.75 16.4354 3.75 15Z" fill="#1C274C"/>
                            </svg>
                        </a>

                        <?php if (pathinfo($notice['FilePath'], PATHINFO_EXTENSION) == 'pdf'): ?>
                            <!-- PDF Preview using iframe -->
                            <iframe src="../uploads/<?php echo htmlspecialchars($notice['FilePath']); ?>" width="100%" height="200px" style="border: none;"></iframe>
                        <?php else: ?>
                            <!-- Image Preview -->
                            <a href="../uploads/<?php echo htmlspecialchars($notice['FilePath']); ?>" target="_blank">
                                <img src="../uploads/<?php echo htmlspecialchars($notice['FilePath']); ?>" alt="Notice Image" class="notice-image" style="max-width: 100%; height: auto;">
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No notices available.</p> <!-- Message when no notices are found -->
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
