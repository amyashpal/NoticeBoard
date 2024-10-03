<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch notices from the database
$notices_query = "SELECT n.NoticeId, n.Title, n.Description, n.FilePath, n.CreatedAt FROM notices n WHERE n.AdminId = ?";
$stmt = $conn->prepare($notices_query);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $_SESSION['admin_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("Database query failed: " . $stmt->error);
}
?>

<div class="container">
    <h2>Your Notices</h2>
    <div class="actions">
        <a href="create_notice.php" class="btn btn-primary">Create Notice</a>
    </div>
    <table class="notice-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>File</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($notice = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($notice['Title']); ?></td>
                        <td><?php echo htmlspecialchars($notice['Description']); ?></td>
                        <td>
                            <?php if ($notice['FilePath']): ?>
                                <a href="../uploads/<?php echo htmlspecialchars($notice['FilePath']); ?>" target="_blank">View File</a>
                            <?php else: ?>
                                No file uploaded
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars(date("F j, Y, g:i a", strtotime($notice['CreatedAt']))); ?></td>
                        <td>
                            <a href="edit_notice.php?id=<?php echo $notice['NoticeId']; ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_notice.php?id=<?php echo $notice['NoticeId']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this notice?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No notices found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    .container {
        max-width: 900px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    .actions {
        text-align: right;
        margin-bottom: 20px;
    }

    .btn {
        padding: 10px 15px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-edit {
        background-color: #ffc107;
        color: black;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .notice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .notice-table th,
    .notice-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .notice-table th {
        background-color: #f2f2f2;
    }

    .notice-table tr:hover {
        background-color: #f1f1f1;
    }
</style>

<?php include '../includes/footer.php'; ?>
