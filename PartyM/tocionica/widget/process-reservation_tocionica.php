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
$stmt = $conn->prepare("INSERT INTO tocionica (ime, brojtelefona, brojstola,vrstarez, brojljudi, reservationstatus, zadatum, vremedolaska, vremerez, mesto, mestosedenja, sedenje, email, notification_sent, kasnjenje) VALUES (?, ?, '#', ?, ?, 'pending', ?, ?, NOW(), 'tocionica', ?, ?, ?, '0', NULL)");
$stmt->bind_param("sssisssss", $ime, $brojtelefona, $vrstarez, $brojljudi, $zadatum, $vremedolaska, $mestosedenja, $sedenje, $email);


$ime = $_POST['ime'];
$vrstarez = $_POST['vrstarez'];
$brojtelefona = $_POST['brojtelefona'];

$brojljudi = $_POST['brojljudi'];
$zadatum = $_POST['zadatum'];
$vremedolaska = $_POST['vremedolaska'];
$mestosedenja = $_POST['mestosedenja'];
$sedenje = $_POST['sedenje'];
$email = $_POST['email'];


$stmt->execute();

$stmt->close();
$conn->close();

// Output success message and link to the user
echo "Uspešno ste poslali zahtev za rezervaciju. ";
echo "<br>";
echo "Ocekujte E-mail sa potvrdjenom rezervacijom!";
echo "<br>";
echo "Party M";

$htmlPageUrl = "https://www.google.com/";

// Output HTML content with a link
echo "<p>Na ovom <a href='$htmlPageUrl'>linku</a> možete proveriti status rezervacije</p>";
}
catch (mysqli_sql_exception $e) {
    // Check if the error code indicates a duplicate entry error
    if ($e->getCode() == 1062) {
        
        echo "";
       
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
