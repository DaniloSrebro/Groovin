<?php
// update_live_status.php

header('Content-Type: text/plain');

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "Sinke008"; // Replace with your DB password
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $live = $_POST['live'];
    $dj_id = $_POST['dj_id'];

    // Validate inputs
    if (empty($username) || empty($dj_id) || !isset($live)) {
        echo "Invalid input.";
        $conn->close();
        exit;
    }

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE dj SET live = ? WHERE username = ? AND id = ?");
    $stmt->bind_param('isi', $live, $username, $dj_id);

    if ($stmt->execute()) {
        echo "Live status updated successfully to " . $live . " for DJ ID: " . $dj_id;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
