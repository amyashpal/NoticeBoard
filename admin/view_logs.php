<?php
include '../includes/db.php';  // Database connection

// Fetch log entries
$sql = "SELECT log.id, admins.username, log.action, log.timestamp 
        FROM log 
        JOIN admins ON log.admin_id = admins.id 
        ORDER BY log.timestamp DESC";
$result = $conn->query($sql);

echo "<h2>Admin Login/Logout Logs</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Admin Username</th>
            <th>Action</th>
            <th>Timestamp</th>
        </tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $row['id'] . "</td>
            <td>" . $row['username'] . "</td>
            <td>" . $row['action'] . "</td>
            <td>" . $row['timestamp'] . "</td>
          </tr>";
}
echo "</table>";
?>
