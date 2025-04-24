<?php
session_start();  // Start the session to access the user ID

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../forms/Login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "djlikes";

// Create the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['save_song'])) {
    // Get the song details from the form
    $song_name = $_POST['song_name'];
    $artist_name = $_POST['artist_name'];
    $album_name = $_POST['album_name'];
    $spotify_url = $_POST['spotify_url'];
    $cover_image = $_POST['cover_image'];
    
    // Get the user ID from session
    $user_id = $_SESSION['user_id'];

    // Get the DJ ID from the hidden input
    $dj_id = $_POST['dj_id'];

    // Get the current timestamp for request_time
    $request_time = date('Y-m-d H:i:s');

    // SQL query to insert data into the song_requests table, including dj_id
    $sql = "INSERT INTO song_requests (user_id, song_name, artist_name, album_name, spotify_url, cover_image, approved_by_dj, dj_id, request_time)
            VALUES ('$user_id', '$song_name', '$artist_name', '$album_name', '$spotify_url', '$cover_image', 0, '$dj_id', '$request_time')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        header("Location: profile.php?id=" . urlencode($dj_id));
        exit;
    } else {
        header("Location: profile.php?". urlencode($dj_id) ."?error=" . urlencode($conn->error));  // Redirect with error message
        exit;
    }
}

// Close the connection
$conn->close();
?>
