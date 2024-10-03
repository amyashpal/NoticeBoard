<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$query = "SELECT * FROM Notice WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['admin_id']);
$stmt->execute();
$notices = $stmt->get_result();
?>

<div class="container">
    <h1>Manage Notices</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($notice = $notices->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($notice['title']); ?></td>
                    <td><?php echo htmlspecialchars($notice['description']); ?></td>
                    <td>
                        <a href="edit_notice.php?id=<?php echo $notice['notice_id']; ?>" class="admin-button">Edit</a>
                        <a href="delete_notice.php?id=<?php echo $notice['notice_id']; ?>" class="admin-button">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
