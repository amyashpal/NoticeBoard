<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';



// Fetch all notices
$sql = "SELECT * FROM notices ORDER BY CreatedAt DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .notice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }

        .notice-table th, .notice-table td {
            border: 1px solid #ddd;
            padding: 10px;
            white-space: nowrap; /* Prevents text from wrapping */
            overflow: hidden; /* Ensures content does not overflow out of the cell */
            text-overflow: ellipsis; /* Adds ellipsis when the content overflows */
        }

        .notice-table th {
            background-color: #333;
            color: white;
        }

        .notice-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .notice-table tr:hover {
            background-color: #ddd;
        }

        .edit-btn, .delete-btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
        }

        .edit-btn {
            background-color: black;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        /* Success message styling */
        .success-tooltip {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: none;
            animation: fadeIn 3s forwards;
        }

        .tooltip-container {
            position: relative;
        }

        /* Animation for fade-in effect */
     
        
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <table class="notice-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $row['Title']; ?></td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <?php echo substr($row['Description'], 0, 50) . '...'; ?>
                    </td>
                    <td><?php echo $row['Category']; ?></td>
                    <td>
                        <a href="edit_notice.php?id=<?php echo $row['NoticeId']; ?>" class="edit-btn">Edit</a>
                        <a href="delete_notice.php?id=<?php echo $row['NoticeId']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/footer.php'; ?>

 
</body>
</html>
