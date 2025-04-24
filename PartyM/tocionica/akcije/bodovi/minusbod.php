<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <style>
        body {
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
// Database connection details
include 'dbconnect.php';

// Create connection to the first database
$conn1 = new mysqli($servername, $username, $password, $database1);

// Create connection to the second database
$conn2 = new mysqli($servername, $username, $password, $database2);

// Check connection to the first database
if ($conn1->connect_error) {
    die("Connection to first database failed: " . $conn1->connect_error);
}

// Check connection to the second database
if ($conn2->connect_error) {
    die("Connection to second database failed: " . $conn2->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nijestiglarez'])) {
    // Check if the form was submitted and the stiglarez_button was clicked

    // Retrieve the value of the hidden input field
    $userId = $_POST['nijestiglarez'];

    // Update the 'bodovi' column for the user in the first database
    $sql = "UPDATE login_db.user SET bodovi = bodovi - 1 WHERE id = ?";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();

    // Copy data from 'user' table in the first database to 'tocionicaistorija' table in the second database
    $copy_sql = "INSERT INTO rezervacije.tocionicaistorija (id, ime, vrstarez, brojtelefona, brojstola, brojljudi, reservationstatus, zadatum, vremerez, mesto, vremedolaska, mestosedenja, sedenje, dosli, email) 
                 SELECT id, ime, vrstarez, brojtelefona, brojstola, brojljudi, reservationstatus, zadatum, vremerez, mesto, vremedolaska, mestosedenja, sedenje, 'ne' AS dosli, email FROM rezervacije.tocionica WHERE id = ? AND zadatum = CURDATE()";
    $copy_stmt = $conn2->prepare($copy_sql);
    $copy_stmt->bind_param("i", $userId);
    $copy_stmt->execute();
    $copy_stmt->close();

    // Delete from 'tocionica' table in the second database where userid=id
    $delete_sql = "DELETE FROM rezervacije.tocionica WHERE id = ? AND zadatum = CURDATE()";
    $delete_stmt = $conn2->prepare($delete_sql);
    $delete_stmt->bind_param("i", $userId);
    $delete_stmt->execute();
    $delete_stmt->close();

    echo "Uspešno.";

    // Define the URL of the HTML page you want to link to
    $htmlPageUrl = "../../pregled/pregledtocionica.php";

    // Output HTML content with a link
    echo "<p>Return to <a href='$htmlPageUrl'>Pregled</a></p>";
    echo "<script>
    // Define the URL to redirect to
    var redirectUrl = '$htmlPageUrl';

    // Delay in milliseconds (2 seconds = 2000 milliseconds)
    var delay = 1000;

    // Function to redirect after delay
    function redirect() {
        window.location.href = redirectUrl;
    }

    // Call the redirect function after the specified delay
    setTimeout(redirect, delay);
</script>";
}

// Close the database connections
$conn1->close();
$conn2->close();
?>
</div>
    </div>
</body>
</html>