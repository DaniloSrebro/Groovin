<?php
session_start();

if (!isset($_SESSION['dj_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    // Profile picture upload process
    $uploadDir = '../djs/uploads/profile_pictures/';
    $fileTmpName = $_FILES['profile_picture']['tmp_name'];
    $fileName = uniqid('profile_', true) . '.' . pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
    $uploadPath = $uploadDir . $fileName;

    // Check if the file is an image
    if (getimagesize($fileTmpName) !== false) {
        // Move the uploaded file to the upload directory
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            // Update the user's profile picture in the database
            // Assume you already have the $dj_id session
            $mysqli = require __DIR__ . '/database.php';
            $dj_id = $_SESSION['dj_id'];

            $stmt = $mysqli->prepare("UPDATE dj SET profile_picture = ? WHERE id = ?");
            $stmt->bind_param('si', $fileName, $dj_id);
            $stmt->execute();
            $stmt->close();

            echo "Profile picture uploaded successfully!";
        } else {
            echo "Failed to upload the profile picture.";
        }
    } else {
        echo "Please upload a valid image file.";
    }
} else {
    echo "No file uploaded or there was an error during the upload.";
}
?>
