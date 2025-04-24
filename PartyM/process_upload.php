<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "login_db";


$conn = new mysqli($servername, $username, $password, $dbname);
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    // Define upload directory
    $target_dir = "uploads/profile_pics/";

    // Get file information
    $file = $_FILES['profile_pic'];

    // Debugging: Check if file is uploaded
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Error during file upload: " . $file['error'];
        exit;
    }

    // Check if the file is an image
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        // Generate a unique filename
        $file_name = basename($file["name"]);
        $target_file = $target_dir . uniqid() . "_" . $file_name;

        // Move uploaded file to target directory
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            // File successfully uploaded, save file path to the database
            $user_id = $_SESSION['user_id']; 
            $profile_pic_url = $target_file;

            // Prepare SQL query to update the user's profile picture URL
            $stmt = $conn->prepare("UPDATE user SET profile_pic_url = ? WHERE id = ?");
            $stmt->bind_param("si", $profile_pic_url, $user_id);

            if ($stmt->execute()) {
                echo "Profile picture updated successfully!";
                header("Location: ./profil.php?upload=success");
                exit();
                
            } else {
                echo "Error updating profile picture in database.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
} else {
    echo "No file was uploaded.";
}


