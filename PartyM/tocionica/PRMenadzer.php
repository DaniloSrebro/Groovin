<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
        }
        .message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">

<?php

session_start();
// Database connection parameters
include 'dbconnect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
$stmt = $conn->prepare("INSERT INTO tocionica (ime, brojtelefona, brojstola,vrstarez, brojljudi, reservationstatus, zadatum, vremedolaska, vremerez, mesto, mestosedenja, sedenje, email, notification_sent, kasnjenje) VALUES (?, ?, ?, ?, ?, 'approved', ?, ?, NOW(), 'tocionica', ?, ?, '/', '1', NULL)");
$stmt->bind_param("ssisissss", $ime, $brojtelefona, $brojstola, $vrstarez, $brojljudi, $zadatum, $vremedolaska, $mestosedenja, $sedenje);

// Set parameters and execute

$ime = $_POST['ime'];
$vrstarez = $_POST['vrstarez'];
$brojstola = $_POST['inputFieldd'];
$brojtelefona = $_POST['brojtelefona'];
$brojljudi = $_POST['brojljudi'];
$zadatum = $_POST['zadatum'];
$vremedolaska = $_POST['vremedolaska'];
$mestosedenja = $_POST['mestosedenja'];
$sedenje = $_POST['sedenje'];
$stmt->execute();

$stmt->close();
$conn->close();

// Output success message and link to the user
echo "Uspešno ubacena rezervacija ";


// Define the URL of the HTML page you want to link to
$htmlPageUrl = "./rezervacije/tocionicamenadzer.php";

// Output HTML content with a link
echo "<p>Vrati se na  <a href='$htmlPageUrl'>Menadzera</a></p>";
}
catch (mysqli_sql_exception $e) {
    // Check if the error code indicates a duplicate entry error
    if ($e->getCode() == 1062) {
        $htmlPageUrl = "../index.php";
        echo "Vec imate rezervaciju za ovaj klub,";
        echo "<p>vratite se na <a href='$htmlPageUrl'>pocetnu stranu</a></p>";
       
    } else {
        // For other types of errors, you may want to log the error for debugging purposes
        echo "An error occurred: " . $e->getMessage();
    }
}
?>

</div>
    </div>
</body>
</html>
