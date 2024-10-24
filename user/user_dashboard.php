<?php
include '../includes/header.php'; 
include '../includes/db.php'; 

if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
 
    header('Location: user_login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$studentSql = "SELECT userlog.logid, users.username, userlog.login_time, userlog.logout_time 
               FROM userlog 
               JOIN users ON userlog.user_id = users.userid 
               WHERE userlog.user_id = $user_id
               ORDER BY userlog.login_time DESC";
$studentResult = $conn->query($studentSql);

echo "<div class='container'>"; 
echo "<div class='c2'>";
echo "<h2>Student Login/Logout Logs</h2>";
echo "<div class='table-container'><table border=1>
        <tr>
            <th>ID</th>
            <th>Student Username</th>
            <th>Login Time</th>
            <th>Logout Time</th>
        </tr>";


while($row = $studentResult->fetch_assoc()) {
    echo "<tr>
            <td>" . $row['logid'] . "</td>
            <td>" . $row['username'] . "</td>
            <td>" . (!empty($row['login_time']) ? $row['login_time'] : 'N/A') . "</td>
            <td>" . (!empty($row['logout_time']) ? $row['logout_time'] : 'N/A') . "</td>
          </tr>";
}
echo "</table></div>"; 
echo "</div>"; 
echo "</div>"; 

$conn->close();  
include '../includes/footer.php'; 
?>
