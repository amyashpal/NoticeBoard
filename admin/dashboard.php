<?php
include '../includes/db.php'; 
include '../includes/header.php'; 


if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {

    header('Location: login.php');
    exit;
}


$adminSql = "SELECT log.logid, admins.username, log.login_time, log.logout_time 
             FROM log 
             JOIN admins ON log.admin_id = admins.adminid 
             ORDER BY log.login_time DESC";
$adminResult = $conn->query($adminSql);

$studentSql = "SELECT userlog.logid, users.username, userlog.login_time, userlog.logout_time 
               FROM userlog 
               JOIN users ON userlog.user_id = users.userid 
               ORDER BY userlog.login_time DESC";
$studentResult = $conn->query($studentSql);

echo "<div class='container'>";


echo "<div class='c2'>";
echo "<h2>Admin Login/Logout Logs</h2>";
echo "<div class='table-container'><table border=1>
        <tr>
            <th>ID</th>
            <th>Admin Username</th>
            <th>Login Time</th>
            <th>Logout Time</th>
        </tr>";

while($row = $adminResult->fetch_assoc()) {
    echo "<tr>
            <td>" . $row['logid'] . "</td>
            <td>" . $row['username'] . "</td>
            <td>" . (!empty($row['login_time']) ? $row['login_time'] : 'N/A') . "</td>
            <td>" . (!empty($row['logout_time']) ? $row['logout_time'] : 'N/A') . "</td>
          </tr>";
}
echo "</table></div>";
echo "</div>"; 


echo "<div class='c3'>";
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
