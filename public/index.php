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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* General Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            width: 100vw;
            overflow-x: hidden;
            background-color: #f7fafc; /* Light gray background */
        }

        img {
            width: 100%;
            object-fit: contain;
        }

        /* Masonry Layout */
        .notice-container {
            columns: 320px; /* Adjust the column width */
            margin: 2rem; /* Space around the container */
        }

        .notice {
            display: inline-block;
            margin-bottom: 1rem;
            width: 100%;
            break-inside: avoid;
            background-color: white;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            cursor: pointer;
        }

        .notice h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .notice p {
            margin-bottom: 0.5rem;
            color: #555;
        }

        .notice-image {
            max-width: 100%;
            height: auto;
            margin-top: 0.5rem;
            border-radius: 0.5rem;
        }

        .popup {
            transition: visibility 0s, opacity 0.5s linear;
        }
        .popup.hidden {
            visibility: hidden;
            opacity: 0;
        }
        .popup.visible {
            visibility: visible;
            opacity: 1;
        }

        .index-navbar {
            position: sticky; /* Make the navbar sticky */
            top: 0; /* Stick to the top */
            z-index: 50;
        }
    </style>
    <title>Notice Board</title>
</head>

<body>
    
    <div class="container mx-auto py-10">
        <h2 class="text-3xl font-bold text-center text-gray-700 mb-8 ">Notices</h2>
        <form method="GET" action="index.php" class="text-center mb-8">
            <label for="tag_id" class="text-lg font-semibold mr-2">Filter by Tag:</label>
            <select name="tag_id" id="tag_id" onchange="this.form.submit()" class="p-2 border rounded-md">
                <option value="">All Notices</option>
                <?php while ($tag = $tags_result->fetch_assoc()): ?>
                    <option value="<?php echo $tag['TagId']; ?>" <?php echo ($selected_tag_id == $tag['TagId']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tag['Name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <!-- Masonry Grid for Notices -->
        <div id="project-container" class="notice-container">
            <?php while ($notice = $notices->fetch_assoc()): ?>
                <div class="notice" onclick="showPopup('<?php echo htmlspecialchars($notice['Title']); ?>', '<?php echo htmlspecialchars($notice['Description']); ?>', '<?php echo $notice['FilePath'] ? '../uploads/' . $notice['FilePath'] : ''; ?>')">
                    <h3><?php echo htmlspecialchars($notice['Title']); ?></h3>
                    <p><?php echo htmlspecialchars($notice['Description']); ?></p>
                    <p><strong>Tags:</strong> <?php echo htmlspecialchars($notice['tags']); ?></p>
                    <?php if ($notice['FilePath']): ?>
                        <?php if (pathinfo($notice['FilePath'], PATHINFO_EXTENSION) == 'pdf'): ?>
                            <a href="../uploads/<?php echo $notice['FilePath']; ?>" target="_blank" class="text-blue-600">View PDF</a>
                        <?php else: ?>
                            <img src="../uploads/<?php echo $notice['FilePath']; ?>" alt="Notice Image" class="notice-image">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Popup Window -->
        <div id="popup" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden popup">
            <div class="relative max-w-lg w-full">
                <span id="close-popup" class="absolute top-2 right-2 text-white cursor-pointer text-2xl">&times;</span>
                <div id="popup-content" class="rounded-lg shadow-lg bg-white overflow-hidden">
                    <div class="p-6">
                        <h3 id="popup-title" class="text-2xl font-semibold text-gray-800 mb-4 text-center"></h3>
                        <p id="popup-description" class="text-gray-600 mt-2 mb-2 text-justify text-xl"></p>
                    </div>
                    <img id="popup-image" src="" alt="" class="w-full rounded-b-lg object-cover">
                </div>
            </div>
        </div>
    </div>

    <script>
        const popup = document.getElementById("popup");
        const popupImage = document.getElementById("popup-image");
        const popupTitle = document.getElementById("popup-title");
        const popupDescription = document.getElementById("popup-description");
        const closePopup = document.getElementById("close-popup");

        // Close popup on clicking the close button
        closePopup.addEventListener("click", () => {
            popup.classList.remove("visible");
            popup.classList.add("hidden");
        });

        // Close popup when clicking outside the image
        popup.addEventListener("click", (event) => {
            if (event.target === popup) {
                popup.classList.remove("visible");
                popup.classList.add("hidden");
            }
        });

        // Show popup with dynamic content
        function showPopup(title, description, imageUrl) {
            popupTitle.textContent = title;
            popupDescription.textContent = description;
            if (imageUrl) {
                popupImage.src = imageUrl;
                popupImage.classList.remove('hidden');
            } else {
                popupImage.classList.add('hidden');
            }
            popup.classList.remove("hidden");
            popup.classList.add("visible");
        }
    </script>
</body>
</html>

<?php include '../includes/footer.php'; ?>
