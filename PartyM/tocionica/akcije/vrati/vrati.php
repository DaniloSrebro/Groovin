<?php

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
    $sql_update = "UPDATE tocionica SET reservationstatus='pending' WHERE id = $reservation_id AND zadatum = CURDATE()";

    if ($conn->query($sql_update) === TRUE) {
        echo "<div class='tekst'>";
        echo "Rezervacija uspešno vraćena u obradu";
        $htmlPageUrl = "../../pregled/pregledtocionica.php";
        echo "<p>Vrati se na <a href='$htmlPageUrl'>Pregled</a></p>";
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

echo "</div>";

// Close connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background-color: #141b2d;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .tekst{
            top: 40%;
            text-align: center;
           font-size: 20px;
        }
    </style>
</head>
<body>
    
</body>
</html>