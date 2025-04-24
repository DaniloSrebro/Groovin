<?php
// Database connection
require "db_connect.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the values
$sqlKiki = "SELECT value FROM kikometer WHERE id = 1";
$resultKiki = $conn->query($sqlKiki);
$temperatureValue = $resultKiki->num_rows > 0 ? $resultKiki->fetch_assoc()["value"] : 0;

$sqlHot = "SELECT value FROM hotometer WHERE id = 1";
$resultHot = $conn->query($sqlHot);
$hotTemperatureValue = $resultHot->num_rows > 0 ? $resultHot->fetch_assoc()["value"] : 0;

$sqlMiss = "SELECT value FROM missometer WHERE id = 1";
$resultMiss = $conn->query($sqlMiss);
$MissTemperatureValue = $resultMiss->num_rows > 0 ? $resultMiss->fetch_assoc()["value"] : 0;

$sqlText = "SELECT text_value FROM messageoftheday WHERE id = 1";
$resultText = $conn->query($sqlText);
$TextTemperatureValue = $resultText->num_rows > 0 ? $resultText->fetch_assoc()["text_value"] : 0;


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>

    <style>
      body {
  background-color: #1a1a1a; /* Off-black, gives a softer feel */
  color: #ffffff; /* White text for contrast */
  overflow-x: hidden;
}


.temperature-label {
    font-size: 24px; /* Increase font size for emphasis */
    font-weight: bold; /* Make the text bold */
    color: white; /* Match your site color */
    margin-bottom: 15px; /* Space below the label */
    text-align: center; /* Center the label */
    text-transform: uppercase; /* Uppercase text for a modern look */
    letter-spacing: 1px; /* Slight spacing between letters */
}

.temperature-label-text{
    font-size: 50px; /* Increase font size for emphasis */
    font-weight: bold; /* Make the text bold */
    color: white; /* Match your site color */
    margin-bottom: 15px; /* Space below the label */
    text-align: center; /* Center the label */
    font-family: "Tangerine", cursive;
  font-weight: 400;
  font-style: normal;
   
    letter-spacing: 1px;
}


        .temperature-container {
  width: 100%;
  height: 30px;
  background: linear-gradient(to right, #0000ff, #ff0000); /* Blue to Red */
  border-radius: 5px;
  position: relative;
  margin: 20px 0;
}

.temperature-arrow {
    position: absolute;
    bottom: -15px; /* Adjust so the arrow is just above the bar */
    font-size: 20px; /* Size of the arrow */
    color: white; /* Arrow color */
    left: 0; /* Initial position */
    transform: translateX(-30%); /* Center the arrow horizontally */
    transition: left 0.5s ease; /* Smooth transition when updating */
    /* Add a little padding to prevent cutting off */
    padding-left: 10px; /* Adjust this as needed */
}

.input-container {
            text-align: center;
            margin-top: 20px;
        }

        .input-container input {
            padding: 10px;
            font-size: 16px;
            width: 50px;
            text-align: center;
        }

        .input-container button {
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50; /* Green button */
            color: white;
            border: none;
            cursor: pointer;
        }

        .hot-temperature-form {
    display: flex;
    flex-direction: column;
    align-items: center; /* Center the elements horizontally */
    margin: 20px; /* Add some space around the form */
    /* Light background for the form */
    border-radius: 8px; /* Rounded corners */
    padding: 20px; /* Inner space for the form */
 /* Subtle shadow for depth */
}

.hot-temperature-input {
    width: 100%; /* Full width */
    max-width: 200px; /* Max width for the input */
    padding: 10px; /* Inner space for the input */
    border: 1px solid #ccc; /* Light border */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Font size for better readability */
    margin-bottom: 15px; /* Space below the input */
    transition: border-color 0.3s; /* Smooth transition for border color */
}

.hot-temperature-input:focus {
    border-color: #4b137d; /* Change border color on focus */
    outline: none; /* Remove default outline */
}

.update-button {
    background-color: #4b137d; /* Match your site color */
    color: white; /* White text */
    padding: 10px 20px; /* Inner space for the button */
    border: none; /* No border */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Font size */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s; /* Smooth transition for background color */
}

.update-button:hover {
    background-color: #3b0d6d; /* Darker shade on hover */
}
.form-container {
            background-color: #333; /* Darker form background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
            width: 100%;
            max-width: 400px;
            margin-left: 50%;
            transform: translateX(-50%);
        }

       

        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #666;
            background-color: #222; /* Darker input background */
            color: #fff;
            font-size: 16px;
            outline: none;
        }

        .form-container input[type="text"]:focus {
            border-color: #4b137d; /* Highlight border when focused */
            background-color: #2b2b2b;
        }

        .form-container input[type="submit"] {
            background-color: #4b137d; /* Button color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .form-container input[type="submit"]:hover {
            background-color: #6a1a9e; /* Hover effect */
        }
    </style>
    
</head>
<body>
    <br>
    


<div class="temperature-label">Kikimeter</div>
<div class="temperature-container">
  <div class="temperature-arrow" id="temperature-arrow">▲</div>
</div>


<div class="input-container">
        <form method="post" action="update.php"> <!-- Point to update_temperature.php -->
            
            <input type="number" id="temperature-input" name="temperature-input" min="0" max="10" value="<?php echo $temperatureValue; ?>">
            <button type="submit">Submit</button>
        </form>
    </div>
<br>
<br>
<br>

<div class="temperature-label">Hotometer</div>
<div class="temperature-container" style="background: linear-gradient(to right, #ffcc00, #ff6600);">
    <div class="temperature-arrow" id="hot-temperature-arrow">▲</div>
</div>


<form action="update_hot_temperature.php" method="POST" class="hot-temperature-form">
    <input type="number" id="hot-temperature-input" name="hot-temperature-input" min="0" max="10" value="<?php echo $hotTemperatureValue; ?>" class="hot-temperature-input">
    <input type="submit" value="Update" class="update-button">
</form>





<div class="temperature-label">Missometer</div>
<div class="temperature-container">
  <div class="temperature-arrow" id="Miss-temperature-arrow">▲</div>
</div>


<div class="input-container">
        <form method="post" action="missometer.php"> <!-- Point to update_temperature.php -->
            
            <input type="number" id="miss-temperature-input" name="miss-temperature-input" min="0" max="10" value="<?php echo $MissTemperatureValue; ?>">
            <button type="submit">Submit</button>
        </form>
    </div>


    <br>
    <br>
    <br>

    <div class="temperature-label">Message Of The Day</div>
    <div class="temperature-label-text">„<?php echo $TextTemperatureValue; ?>”</div>
<br>
<br>

    <div class="form-container">
        <form action="update_text.php" method="POST">
            
            <input type="text" id="text_value" name="text_value" required>
            <input type="submit" value="Promeni Poruku">
        </form>
    </div>


      <script>
         function updateTemperature(value, arrowId) {
            let percentage = (value / 10) * 100; // Calculate the percentage
            let arrow = document.getElementById(arrowId);

            // Move the arrow based on the percentage
            arrow.style.left = `calc(${percentage}% - 10px)`; // Adjust position for centering
        }

        // Update the arrows based on the values from PHP
        let dbValue = <?php echo $temperatureValue; ?>;
        updateTemperature(dbValue, 'temperature-arrow');

        let hotDbValue = <?php echo $hotTemperatureValue; ?>;
        updateTemperature(hotDbValue, 'hot-temperature-arrow');

        let MissDbValue = <?php echo $MissTemperatureValue; ?>; // PHP value to JavaScript
        updateTemperature(MissDbValue, 'Miss-temperature-arrow');
      </script>
</body>
</html>