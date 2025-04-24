<?php
// Start the session to access the session variables
session_start();

// Include your database connection file
$servername = "localhost";
$username = "root";
$password = "Sinke008"; 
$database = "rezervacije";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'delay' and 'user_id' values are set in POST
if (isset($_POST['delay']) && isset($_POST['user_id'])) {
    $delay = $_POST['delay'];
    $user_id = $_POST['user_id'];

    // Check if kasnjenje is NULL for the specific user
    $checkSql = "SELECT kasnjenje FROM tocionica WHERE id = ?";
    if ($checkStmt = $conn->prepare($checkSql)) {
        $checkStmt->bind_param('i', $user_id);
        $checkStmt->execute();
        $checkStmt->bind_result($kasnjenje);
        $checkStmt->fetch();
        $checkStmt->close();

        // If kasnjenje is NULL, proceed with the update
        if (is_null($kasnjenje)) {
            // Prepare the SQL query to update the 'kasnjenje' column for the specific user
            $sql = "UPDATE tocionica SET kasnjenje = ? WHERE id = ?";

            // Prepare the statement
            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters
                $stmt->bind_param('ii', $delay, $user_id);

                // Execute the statement
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Kašnjenje je uspešno ažurirano!";
                } else {
                    $_SESSION['error'] = "Error updating kasnjenje: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                $_SESSION['error'] = "Error preparing the statement: " . $conn->error;
            }
        } else {
            // If kasnjenje is not NULL, set an error message
            $_SESSION['error'] = "Kašnjenje je već postavljeno.";
        }
    } else {
        $_SESSION['error'] = "Error preparing the check statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();

    // Redirect to profil.php
    header("Location: profil.php");
    exit(); // Ensure no further code is executed after redirection
} else {
    echo "Invalid request!";
}

