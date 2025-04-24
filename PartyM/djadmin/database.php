<?php
// database.php

$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "Sinke008"; // Replace with your DB password
$dbname = "login_db"; // Replace with your database name

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Return the connection object for use in other PHP files
return $mysqli;
