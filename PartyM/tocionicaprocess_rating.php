<?php
session_start();

// Establish database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "Sinke008"; // Replace with your MySQL password
$database = "ocene"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted and data is valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating']) && isset($_SESSION['user_id'])) {
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id'];

    // Prepare and bind select statement
    $check_stmt = $conn->prepare("SELECT COUNT(*) AS count FROM tocionicaocene WHERE id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    if ($count > 0) {
        // User has already submitted a rating, set an error message
        $_SESSION['error'] = "Dozvoljeno je samo jednom oceniti lokal.";
    } else {
        // Prepare and bind insert statement
        $stmt = $conn->prepare("INSERT INTO tocionicaocene (id, rating) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $rating);

        // Execute insert statement
        if ($stmt->execute() === TRUE) {
            $_SESSION['message'] = "Hvala vam što koristite Party M!";
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
} else {
    $_SESSION['error'] = "Morate odabrati ocenu.";
}

// Close the database connection
$conn->close();

// Redirect to profil.php
header("Location: profil.php");
exit(); // Ensure no further code is executed after redirection

