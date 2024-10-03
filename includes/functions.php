<?php
function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function handleFileUpload($file) {
    $uploadDir = '../uploads/';
    $filePath = '';

    if ($file['error'] == UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $filePath = $uploadDir . $fileName;
        move_uploaded_file($file['tmp_name'], $filePath);
    }
    return $filePath;
}
?>
