<?php
// Establish connection to your database
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "links";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the search query
$query = $_GET['q'];

// Execute a query to fetch relevant results based on $query from your database
$sql = "SELECT title, url, image_url FROM links WHERE title LIKE '%$query%'";
$result = $conn->query($sql);

// Initialize an array to store results
$results = array();

// Fetch results and add them to the array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results[] = array(
            "title" => $row["title"],
            "url" => $row["url"],
            "imageUrl" => $row["image_url"]
        );
    }
}

// Close the database connection
$conn->close();

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($results);
