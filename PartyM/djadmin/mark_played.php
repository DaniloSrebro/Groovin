<?php
// Database connection credentials
$host = "localhost";       // Replace with your database host
$username = "root";        // Replace with your database username
$password = "Sinke008";            // Replace with your database password
$dbname = "djlikes"; // Replace with your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the song ID from the POST request
    $song_id = intval($_POST['id']);

    // Update the 'played' column for the specified song ID
    $sql = "UPDATE song_requests SET played = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $song_id);
        
        if ($stmt->execute()) {
            http_response_code(200);
            echo "Song marked as played successfully.";
        } else {
            http_response_code(500);
            echo "Error: Could not mark song as played.";
        }
        
        $stmt->close();
    } else {
        http_response_code(500);
        echo "Error: Failed to prepare the SQL statement.";
    }
}

// Close the database connection
$conn->close();
?>
