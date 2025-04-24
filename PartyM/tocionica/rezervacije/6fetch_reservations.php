<?php
// Replace these with your actual database connection details
$host = 'localhost';
$db   = 'rezervacije';
$user = 'root';
$pass = 'Sinke008';
$charset = 'utf8mb4';

// Data Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a new PDO instance to connect to the database
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // If the connection fails, return an error message
    error_log("Connection failed: " . $e->getMessage());
    echo "Error connecting to database.";
    exit;
}

// Check if the 'table_number' parameter is present in the URL query string
if (isset($_GET['table_number'])) {
    $tableNumber = $_GET['table_number'];

    // Prepare and execute the query to fetch reservation times for the specified table
    $stmt = $pdo->prepare('SELECT vremedolaska FROM tocionica WHERE brojstola = ? AND zadatum = DATE_ADD(CURDATE(), INTERVAL 6 DAY) AND reservationstatus="approved"');
    $stmt->execute([$tableNumber]);

    // Fetch all matching records as an array
    $times = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Encode the array as JSON and return it as the response
    echo json_encode($times);
} else {
    // If 'table_number' is not provided, return an error message
    echo "Table number not provided.";
}
