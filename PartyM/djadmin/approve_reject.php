<?php
session_start();  // Assuming the DJ's user session is stored

// Database connection
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "djlikes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the POST parameters
$song_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Check if the song ID and action are valid
if ($song_id > 0 && in_array($action, ['approve', 'reject'])) {
    if ($action == 'approve') {
        // Mark the song as approved (change the status to 1 or 'approved')
        $sql = "UPDATE song_requests SET approved_by_dj = 1 WHERE id = $song_id";
    } else if ($action == 'reject') {
        // Set the song's approval field to NULL (or any other column you'd like to update)
        $sql = "UPDATE song_requests SET approved_by_dj = NULL WHERE id = $song_id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Song $action successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid parameters.";
}

$conn->close();
?>
