<?php

require "db_connect.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text_value = $_POST['text_value']; // Get the text value from the form

    // Sanitize input to prevent XSS attacks
    $text_value = htmlspecialchars($text_value);

    // Prepare and bind SQL query to update text_value where id = 1
    $stmt = $conn->prepare("UPDATE messageoftheday SET text_value = ? WHERE id = 1");
    $stmt->bind_param("s", $text_value);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "Text value updated successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();

// Redirect to the main page after updating (optional)
header("Location: index.php"); // Change 'index.php' to your actual page
exit();
