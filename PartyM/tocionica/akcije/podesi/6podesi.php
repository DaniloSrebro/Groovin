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
// Database connection details
include 'dbconnect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $reservation_id = $_POST["reservation_id"];
  $inputFieldValue = $_POST["inputField"]; // Change "inputField" to the actual name of your input field
  
  // SQL query to update the specific row in the tocionica table
  $sql_update = "UPDATE tocionica SET brojstola = '$inputFieldValue' WHERE id = $reservation_id AND zadatum = DATE_ADD(CURDATE(), INTERVAL 6 DAY)" ; 
  
  if ($conn->query($sql_update) === TRUE) {
       
    $htmlPageUrl = "../../pregled/6pregledtocionica.php";

    // Output HTML content with a link
    echo "<p><a href='$htmlPageUrl'>Uspešno</a></p>";
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
}


    




// Close the database connections

$conn->close();
?>
</div>
    </div>
</body>
</html>