<?php
session_start();

if (!isset($_SESSION['dj_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

if (isset($_FILES['demo_file']) && $_FILES['demo_file']['error'] === UPLOAD_ERR_OK) {
    // Demo file upload process
    $uploadDir = '../djs/uploads/demo_mp3/';
    $fileTmpName = $_FILES['demo_file']['tmp_name'];
    $fileName = uniqid('demo_', true) . '.mp3';
    $uploadPath = $uploadDir . $fileName;

    // Move the uploaded file to the upload directory
    if (move_uploaded_file($fileTmpName, $uploadPath)) {
        // Update the user's demo MP3 in the database
        // Assume you already have the $dj_id session
        $mysqli = require __DIR__ . '/database.php';
        $dj_id = $_SESSION['dj_id'];

        $stmt = $mysqli->prepare("UPDATE dj SET demo_mp3 = ? WHERE id = ?");
        $stmt->bind_param('si', $fileName, $dj_id);
        $stmt->execute();
        $stmt->close();

        echo "Demo MP3 uploaded successfully!";
    } else {
        echo "Failed to upload the demo MP3.";
    }
} else {
    echo "No file uploaded or there was an error during the upload.";
}
?>