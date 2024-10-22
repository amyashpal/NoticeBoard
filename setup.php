<?php
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "notice_board";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    die("Error creating database: " . $conn->error . "<br>");
}

// Select the database
$conn->select_db($dbname);

// SQL to create tables

// Create the `admins` table
$createAdminsTable = "
CREATE TABLE IF NOT EXISTS admins (
    AdminId INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE
);";

// Create the `users` table
$createUsersTable = "
CREATE TABLE IF NOT EXISTS users (
    UserId INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE
);";

// Create the `notices` table
$createNoticesTable = "
CREATE TABLE IF NOT EXISTS notices (
    NoticeId INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Description TEXT NOT NULL,
    FilePath VARCHAR(255),
    Category VARCHAR(100),
    Tags VARCHAR(255),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    AdminId INT,
    FOREIGN KEY (AdminId) REFERENCES admins(AdminId)
);";

// Create the `tags` table
$createTagsTable = "
CREATE TABLE IF NOT EXISTS tags (
    TagId INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL UNIQUE
);";

// Create the `notice_tags` table
$createNoticeTagsTable = "
CREATE TABLE IF NOT EXISTS notice_tags (
    NoticeId INT,
    TagId INT,
    PRIMARY KEY (NoticeId, TagId),
    FOREIGN KEY (NoticeId) REFERENCES notices(NoticeId) ON DELETE CASCADE,
    FOREIGN KEY (TagId) REFERENCES tags(TagId) ON DELETE CASCADE
);";

// Create the `log` table with `login_time` and `logout_time` as NULL
$createLogTable = "
CREATE TABLE IF NOT EXISTS log (
    logid INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    login_time TIMESTAMP NULL DEFAULT NULL,
    logout_time TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (admin_id) REFERENCES admins(AdminId)
);";

// Create the `userlog` table with `login_time` and `logout_time` as NULL
$createUserLogTable = "
CREATE TABLE IF NOT EXISTS userlog (
    logid INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    login_time TIMESTAMP NULL DEFAULT NULL,
    logout_time TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(UserId)
);";

// Execute table creation queries
$tables = [
    'admins' => $createAdminsTable,
    'users' => $createUsersTable,
    'notices' => $createNoticesTable,
    'tags' => $createTagsTable,
    'notice_tags' => $createNoticeTagsTable,
    'log' => $createLogTable,
    'userlog' => $createUserLogTable
];

foreach ($tables as $tableName => $createQuery) {
    if ($conn->query($createQuery) === TRUE) {
        echo "Table '$tableName' created successfully<br>";
    } else {
        echo "Error creating table '$tableName': " . $conn->error . "<br>";
    }
}

// Insert initial tags
$insertTags = "
INSERT IGNORE INTO tags (Name) VALUES
('Semester 1'),
('Semester 2'),
('Semester 3'),
('Semester 4'),
('Semester 5'),
('Semester 6'),
('Semester 7'),
('Semester 8'),
('Sports'),
('For All');
";

if ($conn->query($insertTags) === TRUE) {
    echo "Tags inserted successfully<br>";
} else {
    echo "Error inserting tags: " . $conn->error . "<br>";
}

// Close the connection
$conn->close();
?>
