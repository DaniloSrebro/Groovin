<?php
// Database connection parameters
include 'dbconnect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form field "reservation_id" is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reservation_id"])) {
    // Retrieve reservation ID from the form data
    $reservation_id = $_POST["reservation_id"];

    // SQL query to update the reservation status to "rejected"
    $sql_update = "UPDATE tocionica SET reservationstatus='pending' WHERE id = $reservation_id AND zadatum = DATE_ADD(CURDATE(), INTERVAL 6 DAY)";

    if ($conn->query($sql_update) === TRUE) {
        echo "Reservation rejected successfully";
        $htmlPageUrl = "../../pregled/6pregledtocionica.php";
        echo "<p>Return to <a href='$htmlPageUrl'>Pregled</a></p>";
        echo "<script>
    // Define the URL to redirect to
    var redirectUrl = '$htmlPageUrl';

    // Delay in milliseconds (2 seconds = 2000 milliseconds)
    var delay = 100;

    // Function to redirect after delay
    function redirect() {
        window.location.href = redirectUrl;
    }

    // Call the redirect function after the specified delay
    setTimeout(redirect, delay);
</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Handle case where reservation ID is not set
    echo "Reservation ID not provided";
}

// Close connection
$conn->close();