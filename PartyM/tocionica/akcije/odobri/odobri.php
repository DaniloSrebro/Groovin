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
  $sql_update = "UPDATE tocionica SET brojstola = '$inputFieldValue', reservationstatus='approved' WHERE id = $reservation_id AND zadatum = CURDATE()" ; 
  
  if ($conn->query($sql_update) === TRUE) {
    $htmlPageUrl = "../../rezervacije/tocionicamenadzer.php";

    echo "Uspesno dodeljen sto";
    // Output HTML content with a link
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
}