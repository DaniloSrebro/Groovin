<?php

session_start();

$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "Sinke008"; // Replace with your DB password
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the live status for user Mikula
$dj_id = $_SESSION['dj_id']; // Get the DJ's ID from the session

$sql = "SELECT live FROM dj WHERE id = ?"; // Query to fetch live status by ID
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $dj_id); // Bind the session DJ ID as an integer parameter
$stmt->execute();
$stmt->bind_result($liveStatus); // Fetch the live status into $liveStatus
$stmt->fetch();
$stmt->close();
$conn->close();

if (!isset($_SESSION['dj_id'])) {
  // Redirect to login page if user is not logged in
  header("Location: ../formsdj/Login.php");
  exit();
}

if (isset($_SESSION["dj_id"])) {
    
    $mysqli = require __DIR__ . "../../formsdj/database.php";
    
    $sql = "SELECT * FROM dj
            WHERE id = {$_SESSION["dj_id"]}";
            
    $result = $mysqli->query($sql);
    
    $dj = $result->fetch_assoc();
}

$isLoggedIn = isset($_SESSION["dj_id"]);


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Party M - AdminMikula</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/logopartym.png" rel="icon">
  <link href="../assets/img/logopartym.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
        const liveCheckbox = document.getElementById('live');

        // Pass the dj_id and username from PHP to JavaScript
        const djId = "<?php echo $_SESSION['dj_id']; ?>";
        const username = "<?php echo htmlspecialchars($dj['username'], ENT_QUOTES, 'UTF-8'); ?>";

        liveCheckbox.addEventListener('change', () => {
            const liveStatus = liveCheckbox.checked ? 1 : 0;

            // Send updated live status via POST
            fetch('update_live_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `username=${username}&live=${liveStatus}&dj_id=${djId}`
            })
            .then(response => response.text())
            .then(data => console.log(data)) // Log the server response
            .catch(error => console.error('Error:', error));
        });
    });
</script>


 
 
  
  

 
  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
 
  <link href="../assets//vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets//vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
 

  

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
 

 <style>

body{
    background-color: black;
}


/* Center the checkbox and label */
.live {
  margin-top: 50px;
  display: flex;
  justify-content: center;
   /* Full height of the viewport */
  text-align: center;
}

/* Style the checkbox to be larger */
.live input[type="checkbox"] {
  transform: scale(1.5); /* Makes the checkbox bigger */
  margin-right: 10px; /* Optional: adds spacing between checkbox and label */
}

/* Optional: Style the label */
.live label {
    margin-bottom: auto;
    margin-left: 20px;
  font-size: 20px; /* Increase font size of label */
  cursor: pointer;
  color: white; /* Changes cursor to pointer when hovering over label */
}


/* From Uiverse.io by 00Kubi */ 
.neon-checkbox {
  --primary: #00ffaa;
  --primary-dark: #00cc88;
  --primary-light: #88ffdd;
  --size: 30px;
  position: relative;
  width: var(--size);
  height: var(--size);
  cursor: pointer;
  -webkit-tap-highlight-color: transparent;
}

.neon-checkbox input {
  display: none;
}

.neon-checkbox__frame {
  position: relative;
  width: 100%;
  height: 100%;
}

.neon-checkbox__box {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.8);
  border-radius: 4px;
  border: 2px solid var(--primary-dark);
  transition: all 0.4s ease;
}

.neon-checkbox__check-container {
  position: absolute;
  inset: 2px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.neon-checkbox__check {
  width: 80%;
  height: 80%;
  fill: none;
  stroke: var(--primary);
  stroke-width: 3;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-dasharray: 40;
  stroke-dashoffset: 40;
  transform-origin: center;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.neon-checkbox__glow {
  position: absolute;
  inset: -2px;
  border-radius: 6px;
  background: var(--primary);
  opacity: 0;
  filter: blur(8px);
  transform: scale(1.2);
  transition: all 0.4s ease;
}

.neon-checkbox__borders {
  position: absolute;
  inset: 0;
  border-radius: 4px;
  overflow: hidden;
}

.neon-checkbox__borders span {
  position: absolute;
  width: 40px;
  height: 1px;
  background: var(--primary);
  opacity: 0;
  transition: opacity 0.4s ease;
}

.neon-checkbox__borders span:nth-child(1) {
  top: 0;
  left: -100%;
  animation: borderFlow1 2s linear infinite;
}

.neon-checkbox__borders span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 1px;
  height: 40px;
  animation: borderFlow2 2s linear infinite;
}

.neon-checkbox__borders span:nth-child(3) {
  bottom: 0;
  right: -100%;
  animation: borderFlow3 2s linear infinite;
}

.neon-checkbox__borders span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 1px;
  height: 40px;
  animation: borderFlow4 2s linear infinite;
}

.neon-checkbox__particles span {
  position: absolute;
  width: 4px;
  height: 4px;
  background: var(--primary);
  border-radius: 50%;
  opacity: 0;
  pointer-events: none;
  top: 50%;
  left: 50%;
  box-shadow: 0 0 6px var(--primary);
}

.neon-checkbox__rings {
  position: absolute;
  inset: -20px;
  pointer-events: none;
}

.neon-checkbox__rings .ring {
  position: absolute;
  inset: 0;
  border-radius: 50%;
  border: 1px solid var(--primary);
  opacity: 0;
  transform: scale(0);
}

.neon-checkbox__sparks span {
  position: absolute;
  width: 20px;
  height: 1px;
  background: linear-gradient(90deg, var(--primary), transparent);
  opacity: 0;
}

/* Hover Effects */
.neon-checkbox:hover .neon-checkbox__box {
  border-color: var(--primary);
  transform: scale(1.05);
}

/* Checked State */
.neon-checkbox input:checked ~ .neon-checkbox__frame .neon-checkbox__box {
  border-color: var(--primary);
  background: rgba(0, 255, 170, 0.1);
}

.neon-checkbox input:checked ~ .neon-checkbox__frame .neon-checkbox__check {
  stroke-dashoffset: 0;
  transform: scale(1.1);
}

.neon-checkbox input:checked ~ .neon-checkbox__frame .neon-checkbox__glow {
  opacity: 0.2;
}

.neon-checkbox
  input:checked
  ~ .neon-checkbox__frame
  .neon-checkbox__borders
  span {
  opacity: 1;
}

/* Particle Animations */
.neon-checkbox
  input:checked
  ~ .neon-checkbox__frame
  .neon-checkbox__particles
  span {
  animation: particleExplosion 0.6s ease-out forwards;
}

.neon-checkbox
  input:checked
  ~ .neon-checkbox__frame
  .neon-checkbox__rings
  .ring {
  animation: ringPulse 0.6s ease-out forwards;
}

.neon-checkbox
  input:checked
  ~ .neon-checkbox__frame
  .neon-checkbox__sparks
  span {
  animation: sparkFlash 0.6s ease-out forwards;
}

/* Animations */
@keyframes borderFlow1 {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(200%);
  }
}

@keyframes borderFlow2 {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(200%);
  }
}

@keyframes borderFlow3 {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-200%);
  }
}

@keyframes borderFlow4 {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-200%);
  }
}

@keyframes particleExplosion {
  0% {
    transform: translate(-50%, -50%) scale(1);
    opacity: 0;
  }
  20% {
    opacity: 1;
  }
  100% {
    transform: translate(
        calc(-50% + var(--x, 20px)),
        calc(-50% + var(--y, 20px))
      )
      scale(0);
    opacity: 0;
  }
}

@keyframes ringPulse {
  0% {
    transform: scale(0);
    opacity: 1;
  }
  100% {
    transform: scale(2);
    opacity: 0;
  }
}

@keyframes sparkFlash {
  0% {
    transform: rotate(var(--r, 0deg)) translateX(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: rotate(var(--r, 0deg)) translateX(30px) scale(0);
    opacity: 0;
  }
}

/* Particle Positions */
.neon-checkbox__particles span:nth-child(1) {
  --x: 25px;
  --y: -25px;
}
.neon-checkbox__particles span:nth-child(2) {
  --x: -25px;
  --y: -25px;
}
.neon-checkbox__particles span:nth-child(3) {
  --x: 25px;
  --y: 25px;
}
.neon-checkbox__particles span:nth-child(4) {
  --x: -25px;
  --y: 25px;
}
.neon-checkbox__particles span:nth-child(5) {
  --x: 35px;
  --y: 0px;
}
.neon-checkbox__particles span:nth-child(6) {
  --x: -35px;
  --y: 0px;
}
.neon-checkbox__particles span:nth-child(7) {
  --x: 0px;
  --y: 35px;
}
.neon-checkbox__particles span:nth-child(8) {
  --x: 0px;
  --y: -35px;
}
.neon-checkbox__particles span:nth-child(9) {
  --x: 20px;
  --y: -30px;
}
.neon-checkbox__particles span:nth-child(10) {
  --x: -20px;
  --y: 30px;
}
.neon-checkbox__particles span:nth-child(11) {
  --x: 30px;
  --y: 20px;
}
.neon-checkbox__particles span:nth-child(12) {
  --x: -30px;
  --y: -20px;
}

/* Spark Rotations */
.neon-checkbox__sparks span:nth-child(1) {
  --r: 0deg;
  top: 50%;
  left: 50%;
}
.neon-checkbox__sparks span:nth-child(2) {
  --r: 90deg;
  top: 50%;
  left: 50%;
}
.neon-checkbox__sparks span:nth-child(3) {
  --r: 180deg;
  top: 50%;
  left: 50%;
}
.neon-checkbox__sparks span:nth-child(4) {
  --r: 270deg;
  top: 50%;
  left: 50%;
}

/* Ring Delays */
.neon-checkbox__rings .ring:nth-child(1) {
  animation-delay: 0s;
}
.neon-checkbox__rings .ring:nth-child(2) {
  animation-delay: 0.1s;
}
.neon-checkbox__rings .ring:nth-child(3) {
  animation-delay: 0.2s;
}

/* Style for the Top Songs container */
/* Style for the container of the top songs */
.top-songs {
  background-color:transparent; /* Light background for the container */
  padding: 1px;
  margin: 30px auto; /* Center the container */
  width: 90%; /* Limit the width */
  max-width: 800px; /* Increased max-width for a wider container */
  border-radius: 8px; /* Rounded corners for a smooth look */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  text-align: center; /* Center all text */
}

/* Style for the header */
.top-songs h2 {
  font-size: 28px; /* Slightly larger for emphasis */
  margin-bottom: 20px; /* Keeps spacing consistent */
  color: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6); /* Soft shadow for better readability */
  font-weight: 600; /* Slightly bolder text for elegance */
  letter-spacing: 1px; /* Slight spacing for a refined look */
  background-color: rgba(0, 0, 0, 0.2); /* Subtle dark background */
  padding: 10px 15px; /* Add padding to make the header stand out */
  border-radius: 8px; /* Rounded corners for a smooth design */
  display: inline-block; /* Limits background to text size */
}

/* Style for the song list items */
.top-songs li {
  display: flex;
  justify-content: space-between; /* Ensure space between song name and buttons */
  align-items: center; /* Align items (song text and buttons) vertically */
  background-color: #f9f9f9; /* Background for each item */
  padding: 20px; /* Increase padding around the content for more space */
  margin-bottom: 15px; /* Space between items */
  border-radius: 8px; /* Rounded corners */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  font-size: 16px; /* Adjust text size */
  color: #333; /* Set text color */
  flex-wrap: nowrap; /* Ensure content does not wrap in the item */
}

.top-songs li span {
  flex-grow: 1; /* Allow song text to take up all available space */
  overflow: hidden; /* Hide overflow if the text is too long */
  white-space: nowrap; /* Prevent text from wrapping to new lines */
  text-overflow: ellipsis; /* Show ellipsis if the text overflows */
  font-size: 18px; /* Make the font size larger for better readability */
}
.top-songs li i {
 
 
  
  font-size: 18px; /* Make the font size larger for better readability */
}
/* Style for the buttons */
.top-songs li .buttons {
  display: flex;
  gap: 10px; /* Space between buttons */
}

.top-songs li .buttons button {
  padding: 10px 20px; /* Increase the button padding for better feel */
  font-size: 14px;
  border-radius: 5px; /* Round corners for buttons */
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.top-songs li .buttons button.like {
  background-color: #4CAF50; /* Green for Like button */
  color: white;
}

.top-songs li .buttons button.like:hover {
  background-color: #45a049; /* Darker green on hover */
}

.top-songs li .buttons button.dislike {
  background-color: #f44336; /* Red for Dislike button */
  color: white;
}

.top-songs li .buttons button.dislike:hover {
  background-color: #e53935; /* Darker red on hover */
}

/* Make layout responsive */
@media (max-width: 768px) {
  .top-songs li {
    flex-direction: column; /* Stack the content vertically */
    text-align: center; /* Center the text */
  }

  .top-songs li .buttons {
    justify-content: center; /* Center the buttons */
    margin-top: 10px;
  }
}

/* Optional hover effect for the song list */
/* General button styles */
button {
    background-color: transparent;
    border: 2px solid transparent;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: bold;
    color: white;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
}

/* Approve button */
.button-approve {
    border-color: #4CAF50;  /* Green color for approval */
    color: #4CAF50;  /* Green text */
    background-color: rgba(76, 175, 80, 0.1);  /* Light green background */
}

.button-approve:hover {
    background-color: #4CAF50;  /* Darken the background on hover */
    color: white;
}

.button-approve i {
    font-size: 20px;  /* Icon size */
}

/* Reject button */
.button-reject {
    border-color: #f44336;  /* Red color for rejection */
    color: #f44336;  /* Red text */
    background-color: rgba(244, 67, 54, 0.1);  /* Light red background */
}

.button-reject:hover {
    background-color: #f44336;  /* Darken the background on hover */
    color: white;
}

.button-reject i {
    font-size: 20px;  /* Icon size */
}

.button-played {
    border-color:rgb(255, 255, 255);  /* Green color for approval */
    color:rgb(255, 255, 255);  /* Green text */
    background-color: rgba(0, 0, 0, 0.1);  /* Light green background */
}

.button-played:hover {
    background-color:rgb(0, 0, 0);  /* Darken the background on hover */
    color: white;
}

.button-played i {
    font-size: 20px;  /* Icon size */
}

/* Adjust button appearance in the li */
.buttons button {
    margin: 5px 0;
    width: auto;  /* Make the width fit content */
}

/* Hover effects for both buttons */
button:hover {
    transform: scale(1.05);  /* Slightly enlarge on hover for better interactivity */
}



 </style>

</head>

<body>
<div id="preloader">
  
  </div>
 

  <header id="header" class="fixed-top d-flex align-items-center" style="font-style:italic">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="#">Party M</a></h1>
      

      <nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link active" href="#">Live</a></li>
         
          
          
        
          
         
          
          <li><a class="nav-link scrollto" href="./mikula_info.php">Info</a></li>
          <?php if($isLoggedIn): ?>
            <li><a class="getstartedout scrollto" href="../formsdj/logout.php">Logout</a></li>
          <?php else: ?>
            <li><a class="getstarted scrollto" href="../formsdj/Login.php">Login</a></li>
        <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center" style="color: white;font-style:italic">
          <h2>Live</h2>
          <ol>
            <li>Party M</li>
            <li><?php echo htmlspecialchars($dj['username'], ENT_QUOTES, 'UTF-8'); ?></li>
            <li>Live</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

 <main id="main">



 <?php
// Connection to database
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "djlikes";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the song requests that are approved but not played
$sql = "SELECT * FROM song_requests WHERE approved_by_dj = 1 AND dj_id = {$_SESSION["dj_id"]} AND played = 0 ORDER BY request_time ASC";
$result = $conn->query($sql);
?>


    <?php
    if ($result->num_rows > 0) {
      echo "<div class='top-songs'>";
        echo "<h2>In queue:</h2>";
        echo "<ul class='top-songs'>"; // Move the <ul> outside the loop

        while ($row = $result->fetch_assoc()) {
            $song_name = $row['song_name'];
            $artist_name = $row['artist_name'];
            $id = $row['id'];
            $cover_image = $row['cover_image']; // Get cover image URL

            echo "
                <li style='background-image: url($cover_image); background-size: cover; background-position: center; padding: 20px; color: white;'>
                    <div class='song-item' style='background-color: rgba(0, 0, 0, 0.4); padding: 6px; border-radius: 5px;'>
                        <span>$song_name - $artist_name</span>
                    </div>
                    <div class='buttons'>
                        <button class='button-played' onclick='playedSong($id)'>
                            <i class='bi bi-check-all'></i> Played
                        </button>
                    </div>
                </li>
            ";
        }

        echo "</ul>"; // Close the <ul> after the loop
    } else {
        echo "";
    }
    ?>
</div>


<script>
  function playedSong(songId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "mark_played.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
          location.reload();
        } else {
            console.error("Error: Unable to mark song as played.");
        }
    };
    xhr.send("id=" + songId);
}
</script>



 <div class="live">
 <form action="update_live_status.php" method="post">
 <label class="neon-checkbox">
  <input type="checkbox" id="live" 
        name="live"
        <?php echo $liveStatus == 1 ? 'checked' : ''; // Check the box if live is 1 ?>/>
  <div class="neon-checkbox__frame">
    <div class="neon-checkbox__box">
      <div class="neon-checkbox__check-container">
        <svg viewBox="0 0 24 24" class="neon-checkbox__check">
          <path d="M3,12.5l7,7L21,5"></path>
        </svg>
      </div>
      <div class="neon-checkbox__glow"></div>
      <div class="neon-checkbox__borders">
        <span></span><span></span><span></span><span></span>
      </div>
    </div>
    <div class="neon-checkbox__effects">
      <div class="neon-checkbox__particles">
        <span></span><span></span><span></span><span></span> <span></span
        ><span></span><span></span><span></span> <span></span><span></span
        ><span></span><span></span>
      </div>
      <div class="neon-checkbox__rings">
        <div class="ring"></div>
        <div class="ring"></div>
        <div class="ring"></div>
      </div>
      <div class="neon-checkbox__sparks">
        <span></span><span></span><span></span><span></span>
      </div>
    </div>
  </div>
</label>


   
</form>
</div>





<?php
// Connection to database
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "djlikes";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the song requests that are not approved or rejected
$sql = "SELECT * FROM song_requests WHERE approved_by_dj = 0 AND dj_id = {$_SESSION["dj_id"]} order by request_time asc";
$result = $conn->query($sql);
?>

<div class="top-songs">
    <ul class="top-songs">
        <?php
        // Loop through each song request
        if ($result->num_rows > 0) {
          echo "<h2>Requests:</h2>";
            while($row = $result->fetch_assoc()) {
                $song_name = $row['song_name'];
                $artist_name = $row['artist_name'];
                $id = $row['id'];
                $cover_image = $row['cover_image'];  // Get cover image URL
                
                echo "
                <li style='background-image: url($cover_image); background-size: cover; background-position: center; padding: 20px; color: white;'>
                    <div class='song-item' style='background-color: rgba(0, 0, 0, 0.4); padding: 6px; border-radius:5px;'>
                        <span>$song_name - $artist_name</span>
                    </div>
                    <div class='buttons'>
                        <button class='button-approve' onclick='approveSong($id)'>
    <i class='bi bi-check-circle'></i> Approve
</button>
<button class='button-reject' onclick='rejectSong($id)'>
    <i class='bi bi-trash3'></i> Reject
</button>

                    </div>
                </li>
                ";
            }
        } else {
            echo "<li>No new song requests.</li>";
        }
        ?>
    </ul>
</div>




<?php
// Connection to database
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "djlikes";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the song requests that are approved and played
$sql = "SELECT * FROM song_requests WHERE approved_by_dj = 1 AND dj_id = {$_SESSION["dj_id"]} AND played = 1 ORDER BY request_time ASC";
$result = $conn->query($sql);
?>

<div class='top-songs'>
    <?php
    if ($result->num_rows > 0) {
        echo "<h2>History:</h2>";
        echo "<ul class='top-songs'>"; // Move the <ul> outside the loop

        while ($row = $result->fetch_assoc()) {
            $song_name = $row['song_name'];
            $artist_name = $row['artist_name'];
            $id = $row['id'];
            $cover_image = $row['cover_image'];  // Get cover image URL

            echo "
                <li style='background-image: url($cover_image); background-size: cover; background-position: center; padding: 20px; color: white;'>
                    <div class='song-item' style='background-color: rgba(0, 0, 0, 0.4); padding: 6px; border-radius: 5px;'>
                        <span>$song_name - $artist_name</span>
                    </div>
                </li>
            ";
        }

        echo "</ul>"; // Close the <ul> after the loop
    } else {
        echo "<h2>No songs in history.</h2>";
    }
    ?>
</div>







</main>




<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
  




  <!-- ======= Footer ======= -->
  <footer id="footer" style="font-style:italic">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Party M <img src="../assets/img/logopartym.png" alt="" style="width:70px; height:70px;"></h3>
              
              <p>
                <strong>Email:</strong> info@partym.rs<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 offset-lg-6 col-md-6 footer-links">
            <h4>Nasi Servisi</h4>
            <ul>
              
              <li><i class="bi bi-arrow-right-short"></i> <a href="../restoranikafici.php">Restorani/Kafici</a></li>
              
              
            </ul>
            <br>
            <h4>Partneri:</h4>
            <ul>
              
              <li><i class="bi bi-arrow-right-short"></i> <a href="#">Točionica</a></li>
              
              
            </ul>
            
          </div>

          

        </div>
      </div>
    </div>
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Party M</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
       
        Designed by Zaun
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  

  <script>
var loader = document.getElementById("preloader");

window.addEventListener("load", function() {
  // Fade out the loader
  loader.style.opacity = "0";
  
  // Wait for the transition to complete before hiding it
  setTimeout(function() {
    loader.style.display = "none";
  }, 500); // Match this time to your CSS transition duration
});
</script>

<script>
  // Approve the song (Update the status in DB)
  function approveSong(songId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "approve_reject.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            location.reload();  // Reload page to show updated list
        }
    };
    xhr.send("id=" + songId + "&action=approve");
}

// Reject the song (Delete the song from DB)
function rejectSong(songId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "approve_reject.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
      if (xhr.status === 200) {
            location.reload();  // Reload page to show updated list
        }
    };
    xhr.send("id=" + songId + "&action=reject");
}

</script>


  <!-- Vendor JS Files -->
  <script src="../assets/"></script>
  <script src="../assets//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets//vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets//vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets//vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets//vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets//js/main.js"></script>


</body>

</html>

        