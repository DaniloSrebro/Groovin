<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$user = 'root';
$password = 'Sinke008';
$database = 'rezervacije';

// Create a connection to the database
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Define today's date
$fixedDate = date('Y-m-d');

// Query to fetch reservation data for today
$sql = 'SELECT vremedolaska, brojljudi FROM tocionica WHERE reservationstatus="approved" AND DATE(zadatum) = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $fixedDate);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add the fixed date to the time string
        $dateTime = $fixedDate . 'T' . $row['vremedolaska'];
        $reservations[] = [
            'vremedolaska' => $dateTime,
            'brojljudi' => (int)$row['brojljudi'] // Convert to integer
        ];
    }
}

// Output the data as JSON
echo json_encode($reservations);

// Close the connection
$conn->close();
?>
