<?php
// Database connection
require "db_connect.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted value and sanitize it
    $newValue = isset($_POST['temperature-input']) ? intval($_POST['temperature-input']) : 0;

    // Validate the new value
    if ($newValue >= 0 && $newValue <= 10) {
        // Update the value in the database
        $updateSql = "UPDATE kikometer SET value = ? WHERE id = 1";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("i", $newValue);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the main page (or wherever you want)
        header("Location: index.php"); // Change 'index.php' to the name of your main file
        exit();
    } else {
        // Handle invalid input
        echo "Invalid input. Please enter a number between 1 and 10.";
    }
}

$conn->close();
?>