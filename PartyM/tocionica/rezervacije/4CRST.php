<?php

$mysqli = new mysqli("localhost", "root", "Sinke008", "rezervacije");    //PROVERA DA LI SU REZERVISANI STOLOVI ZBOG CSS BOJA 

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to check reservation status for each table
$query = "SELECT brojstola, reservationstatus FROM tocionica WHERE zadatum = DATE_ADD(CURDATE(), INTERVAL 4 DAY)";
$result = $mysqli->query($query);

$reservationStatus = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Store table number and reservation status
        $reservationStatus[$row['brojstola']] = $row['reservationstatus'];
    }
}

// Close database connection
$mysqli->close();

// Send reservation status as JSON
header('Content-Type: application/json');
echo json_encode($reservationStatus);
