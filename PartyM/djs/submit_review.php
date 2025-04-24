<?php
header('Content-Type: application/json'); // Set correct header for JSON response
session_start(); // Start the session for user authentication

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection credentials
    $host = 'localhost';
    $username = 'root';
    $password = 'Sinke008';
    $database = 'djlikes';

    // Create database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit();
    }

    // Retrieve form data
    $rating = $conn->real_escape_string($_POST['rating']);
    $review_text = $conn->real_escape_string($_POST['review_text']);

    // Get user ID from session
    $user_id = $_SESSION['user_id'] ?? null; // Ensure a user is logged in

    
   

    $dj_id = $conn->real_escape_string($_POST['dj_id']);

    // Validate form input
    if (empty($rating) || empty($review_text)) {
        echo json_encode(['status' => 'error', 'message' => 'Both rating and review text are required.']);
        exit();
    }

    // Ensure user ID is available
    if ($user_id === null) {
        echo json_encode(['status' => 'error', 'message' => 'User is not logged in.']);
        exit();
    }

    // Insert review into the database
    $sql = "INSERT INTO reviews (user_id, dj_id, rating, review_text, review_date) 
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $user_id,$dj_id, $rating, $review_text);

    // Execute query and check result
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Review successfully submitted!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while submitting your review: ' . $stmt->error]);
    }


    
    // Close resources
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
