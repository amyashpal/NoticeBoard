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

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($dbname);

// SQL to create tables
$createAdminsTable = "
CREATE TABLE IF NOT EXISTS admins (
    AdminId INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE
);";

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

$createTagsTable = "
CREATE TABLE IF NOT EXISTS tags (
    TagId INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL UNIQUE
);";

$createNoticeTagsTable = "
CREATE TABLE IF NOT EXISTS notice_tags (
    NoticeId INT,
    TagId INT,
    PRIMARY KEY (NoticeId, TagId),
    FOREIGN KEY (NoticeId) REFERENCES notices(NoticeId) ON DELETE CASCADE,
    FOREIGN KEY (TagId) REFERENCES tags(TagId) ON DELETE CASCADE
);";

// Execute table creation queries
if ($conn->query($createAdminsTable) === TRUE) {
    echo "Table 'admins' created successfully<br>";
} else {
    echo "Error creating table 'admins': " . $conn->error . "<br>";
}

if ($conn->query($createNoticesTable) === TRUE) {
    echo "Table 'notices' created successfully<br>";
} else {
    echo "Error creating table 'notices': " . $conn->error . "<br>";
}

if ($conn->query($createTagsTable) === TRUE) {
    echo "Table 'tags' created successfully<br>";
} else {
    echo "Error creating table 'tags': " . $conn->error . "<br>";
}

if ($conn->query($createNoticeTagsTable) === TRUE) {
    echo "Table 'notice_tags' created successfully<br>";
} else {
    echo "Error creating table 'notice_tags': " . $conn->error . "<br>";
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
('Extra Curricular');
";

if ($conn->query($insertTags) === TRUE) {
    echo "Tags inserted successfully<br>";
} else {
    echo "Error inserting tags: " . $conn->error . "<br>";
}

// Close the connection
$conn->close();
?>
