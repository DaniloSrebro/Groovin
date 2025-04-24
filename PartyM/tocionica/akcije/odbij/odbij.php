<?php
// Database connection details
include 'dbconnect.php';




// Create connection to the second database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection to the first database


// Check connection to the second database
if ($conn->connect_error) {
    die("Connection to second database failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reservation_id"])) {
    // Check if the form was submitted and the stiglarez_button was clicked

    // Retrieve the value of the hidden input field
    $reservation_id = $_POST["reservation_id"];

    // Update the 'bodovi' column for the user in the first database
    

    // Copy data from 'user' table in the first database to 'tocionicaistorija' table in the second database
    $copy_sql = "INSERT INTO rezervacije.tocionicaodbijene (id, ime, vrstarez, brojljudi, brojtelefona, brojstola, reservationstatus, zadatum, vremerez, mesto, vremedolaska, mestosedenja, sedenje, email, notification_sent) 
                 SELECT id, ime, vrstarez, brojljudi, brojtelefona, brojstola, 'rejected' AS reservationstatus, zadatum, vremerez, mesto, vremedolaska, mestosedenja, sedenje, email, '0' AS notification_sent FROM rezervacije.tocionica WHERE id = ? AND zadatum = CURDATE()";
    $copy_stmt = $conn->prepare($copy_sql);
    $copy_stmt->bind_param("i", $reservation_id);
    $copy_stmt->execute();
    $copy_stmt->close();

    // Delete from 'tocionica' table in the second database where userid=id
    $delete_sql = "DELETE FROM rezervacije.tocionica WHERE id = ? AND zadatum = CURDATE()";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $reservation_id);
    $delete_stmt->execute();
    $delete_stmt->close();

    echo "Uspešno.";

    // Define the URL of the HTML page you want to link to
    $htmlPageUrl = "../../rezervacije/tocionicamenadzer.php";

    // Output HTML content with a link
    echo "<p>Povratak na <a href='$htmlPageUrl'>Menadzera</a></p>";
    echo "<script>
    
    var redirectUrl = '$htmlPageUrl';

   
    var delay = 1000;

    
    function redirect() {
        window.location.href = redirectUrl;
    }

  
    setTimeout(redirect, delay);
</script>";
}

// Close the database connections

$conn->close();

