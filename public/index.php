<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        .cc {
            max-width: 960px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: left;
            margin-bottom: 20px;
        }
        .a {
            text-align: center;
            margin-bottom: 20px;
        }

        .category-buttons {
            text-align: center;
            margin-bottom: 20px;
        }

        .category-buttons button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
            transition: background-color 0.3s;
        }

        .category-buttons button:hover {
            background-color: #555;
        }

        .notice-list {
            list-style: none;
            padding: 0;
        }

        .notice-list li {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .notice-list li:last-child {
            border-bottom: none;
        }

        .notice-details {
            max-width: 70%;
        }

        .notice-details h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notice-details h3 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
            max-height: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .notice-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #777;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .actions {
            text-align: right;
        }

        .notice-file-link {
            padding: 8px 12px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .notice-file-link:hover {
            background-color: #555;
        }

        .read-more {
            color: blue;
            cursor: pointer;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        .full-description {
            display: none;
        }

        .expanded .full-description {
            display: block;
        }
    </style>
</head>
<body>
    <div class="cc">
        <h1 class="a">Notices</h1>

        <!-- Category Buttons for filtering -->
        <div class="category-buttons">
            <button onclick="filterNotices('all')">All</button>
            <button onclick="filterNotices('sports')">Sports</button>
            <button onclick="filterNotices('academic')">Academic</button>
        </div>

        <!-- Notice List -->
        <ul class="notice-list" id="notice-list">
            <?php
            include '../includes/db.php';

            // Fetch the category from URL if set, default to 'all'
            $category = isset($_GET['category']) ? $_GET['category'] : 'all';

            // SQL query to fetch notices based on selected category
            $noticeSql = "SELECT * FROM notices";
            if ($category !== 'all') {
                $noticeSql .= " WHERE Category = '" . $category . "'";
            }
            $noticeSql .= " ORDER BY CreatedAt DESC";
            
            $noticeResult = $conn->query($noticeSql);

            while ($row = $noticeResult->fetch_assoc()) {
                echo "<li class='notice-item' id='notice-{$row['NoticeId']}' data-category='{$row['Category']}'>";
                echo "<div class='notice-details'>";
                echo "<h2>Title: {$row['Title']}</h2>";
                echo "<h3 class='short-description'>" . (strlen($row['Description']) > 100 ? substr($row['Description'], 0, 100) . '...' : $row['Description']) . "</h3>";
                echo "<div class='full-description'>{$row['Description']}</div>";
                echo "<p>Category: {$row['Category']}</p>";
                echo "<p>Tags: {$row['Tags']}</p>";
                echo "<p>Created At: {$row['CreatedAt']}</p>";
                echo "<span class='read-more' onclick='toggleReadMore({$row['NoticeId']})'>Read more</span>";
                echo "</div>";
                echo "<div class='actions'>";
                echo "<a href='{$row['FilePath']}' class='notice-file-link' download>Download File</a>";
                echo "</div>";
                echo "</li>";
            }

            $conn->close();
            ?>
        </ul>
    </div>

    <script>
        // Function to toggle 'Read more' / 'Read less'
        function toggleReadMore(noticeId) {
            const noticeItem = document.getElementById('notice-' + noticeId);
            const fullDescription = noticeItem.querySelector('.full-description');
            const shortDescription = noticeItem.querySelector('.short-description');
            const readMoreLink = noticeItem.querySelector('.read-more');

            if (fullDescription.style.display === "none") {
                fullDescription.style.display = "block";
                readMoreLink.textContent = "Read less";
            } else {
                fullDescription.style.display = "none";
                readMoreLink.textContent = "Read more";
            }
        }

        // Function to filter notices by category
        function filterNotices(category) {
            // Redirect to the page with the selected category
            window.location.href = "?category=" + category;
        }
    </script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
